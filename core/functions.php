<?
namespace myf\core;
/**
 * @author Robin Beck
 */

function loadVendors()
{
    $vendorResults = \myf\models\Vendor::find();
        $vendors = [];
        foreach($vendorResults as $result)
        {
            array_push($vendors, new \myf\models\Vendor($result));
        }
    return $vendors;
}

/**
 * Undocumented function
 *
 * @return void
 */
function loadCategories()
{
    $categoryResults = \myf\models\Category::find();
        $categories = [];
        foreach($categoryResults as $result)
        {
            array_push($categories, new \myf\models\Category($result));
        }
    return $categories;
}

/**
 * Checks if a given string is a number with the given amount of decimals
 *
 * @param [type] $number
 * @param [type] $numberOfDecimals
 * @return void
 */
function validateNumberInput($number, $numberOfDecimals)
{
    if(is_numeric($number) && preg_match('/(^[1-9]+[0-9]*)| (^[0-9]+\.[0-9]{'.$numberOfDecimals.'}$)/', $number))
    {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 * uses a given product name to generate a valid path
 *
 * @param [type] $productName
 * @return void
 */
function generateDirectoryPath($productName)
{
    //make sure to replace directory separator symbols in product name
    //replace all characters that are not allowed within file names
    $directoryName = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $productName);
    // remove ramaining whitespaces, make sure the path is in lower case
    $directoryName = strtolower(str_replace(' ', '_', $directoryName));
    $directoryName = PRODUCT_IMAGE_PATH . DIRECTORY_SEPARATOR . $directoryName;
    return $directoryName;
}

/**
 * Undocumented function
 *
 * @param [type] $productName
 * @param [type] $imagesKey
 * @param [type] $errorMessage
 * @return void
 */
function validateImages($productName, $imagesKey, &$errorMessage)
{
    $directoryName = generateDirectoryPath($productName);
    //create directory, if it does not exist
    if(!file_exists($directoryName))
    {
        mkdir($directoryName, 0755, true);
    }

    //check if images are okay
    foreach($_FILES[$imagesKey]['name'] as $key => $value)
    {
        $currentFileName = basename($_FILES[$imagesKey]['name'][$key]);
        $fileType = pathinfo($currentFileName, PATHINFO_EXTENSION);
        //check, if file type is okay
        if(!in_array($fileType, $GLOBALS['supportedFiles']))
        {
            $errorMessage = 'Der Dateityp von ' . $currentFileName . ' wird nicht unterstützt!';
            return false;
        }
        //check if image size is okay
        if($_FILES[$imagesKey]['size'][$key] > MAX_FILE_SIZE)
        {
            $errorMessage = 'Die Datei ' . $currentFileName . ' übersteigt die maximale Dateigröße von ' . MAX_FILE_SIZE . ' KB!';
            return false;
        }
    }
    return true;
}

/**
 * Undocumented function
 *
 * @param [type] $product
 * @param [type] $imagesKey
 * @return void
 */
function addImagesToProduct(&$product, $imagesKey)
{
    $directoryName = generateDirectoryPath($product->productName);
    //upload images
    foreach($_FILES['productImages']['name'] as $key => $value)
    {
        //make sure the file name is unique
        $fileName = explode('.', $_FILES['productImages']['name'][$key])[0];
     
        //create (almost) unique filename
        $currentFileName = str_replace(' ', '_', $fileName);
        $imageName       = substr(explode('_', $currentFileName)[0], 0, 10) . date('Ydmhis', time()) . uniqid('', true);
        $fileType        = pathinfo($_FILES['productImages']['name'][$key], PATHINFO_EXTENSION); 
        $targetPath      = $directoryName . DIRECTORY_SEPARATOR . $imageName . '.' . $fileType;

        //try to upload the file
        $uploadWasSuccessful = \move_uploaded_file($_FILES['productImages']['tmp_name'][$key], $targetPath);
        if($uploadWasSuccessful)
        {
            $product->addImage($targetPath);
        }
    }
}

/**
 * Undocumented function
 *
 * @param string $where
 * @return void
 */
function calculateNumberOfProductPages($where = '')
{
    //calculate the number of pages
    $numberOfProducts = count(\myf\models\Product::find($where));
    $numberOfPages = ceil($numberOfProducts / PRODUCTS_PER_PAGE);
    return $numberOfPages;
}

/**
 * Undocumented function
 *
 * @param [type] $numberOfPages
 * @return void
 */
function determineCurrentPage($currentPage = 1, $numberOfPages)
{
    $currentPage = ($currentPage > $numberOfPages) ? $numberOfPages : $currentPage;
    if($numberOfPages > 0 && $currentPage > $numberOfPages)
    {
        $currentPage = $numberOfPages;
    }
    else if($currentPage < 1)
    {
        $currentPage = 1;
    }
    return $currentPage;
}

/**
 * Undocumented function
 *
 * @param [type] $numberOfPages
 * @param [type] $currentPage
 * @return void
 */
function calculateStartIndex($numberOfPages, $currentPage)
{
    if($numberOfPages - $currentPage < PRODUCT_LIST_RANGE)
    {
        $deltaPages = PRODUCT_LIST_RANGE - ($numberOfPages - $currentPage);
        $startIndex = max($currentPage-$deltaPages, 0);
    }
    else
    {
        $startIndex = $currentPage;
    }
    return $startIndex;
}

/**
 * Undocumented function
 *
 * @param [type] $numberOfPages
 * @param [type] $currentPage
 * @param [type] $startIndex
 * @param string $where
 * @param string $orderBy
 * @return void
 */
function prepareProductList(&$numberOfPages, &$currentPage, &$startIndex, $where = '', $orderBy = '')
{
    $numberOfPages = calculateNumberOfProductPages($where);

    $currentPage = determineCurrentPage($currentPage, $numberOfPages);

    // prepare bottom navigation to always display the same number of sites (except there are less pages than defined in PRODUCT_LIST_RANGE)
    $startIndex = calculateStartIndex($numberOfPages, $currentPage);

    //get products from database
    $productResults = \myf\models\Product::findRange(($currentPage-1) * PRODUCTS_PER_PAGE, PRODUCTS_PER_PAGE, $where, $orderBy);
    if(is_array($productResults))
    {
        $products = [];
        foreach($productResults as $result)
        {
           array_push($products, new \myf\models\Product($result));
        }
        return $products;
    }
}