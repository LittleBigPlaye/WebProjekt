<?php
/**
 * @author Robin Beck
 */


namespace myf\controller;

 class ProductsController extends \myf\core\controller
 {
     
    public function actionNew()
     {
        $this->setParam('currentPosition', 'administration');
        $errorMessages = [];
        $isAdmin = $this->isAdmin();
        if($isAdmin)
        {
            //obtain vendors from database
            $this->setParam('vendors', \myf\models\Vendor::find());

            //obtain categories from database
            $this->setParam('categories', \myf\models\Category::find());

            //check, if form has been submitted
            if(isset($_POST['submit']))
            {
                //get inputs from form
                $name        = $_POST['productName'] ?? '';
                $catchPhrase = $_POST['catchPhrase'] ?? '';
                $description = $_POST['productDescription'] ?? '';
                $price       = $_POST['productPrice'] ?? '';
                $vendor      = $_POST['vendor'] ?? '';
                $category    = $_POST['category'] ?? '';
                $isHidden    = isset($_POST['isHidden']);

                $db = $GLOBALS['database'];

                //check if name exists
                if(empty($name))
                {
                    $errorMessages['productName'] = 'Es muss ein Produktname angegeben werden.';
                }

                //check if description exists
                if(empty($description))
                {
                    $errorMessages['description'] = 'Geben Sie eine Produktbezeichnung an.';
                }

                //check if price is valid
                if(!\myf\core\validateNumberInput($price, 2))
                {
                    $errorMessages['price'] = 'Geben Sie einen Preis größer 0 € und mit maximal zwei Nachkommastellen an.';
                }

                //check if vendor exists
                if(empty($vendor) || \myf\models\Vendor::findOne('id=' . $db->quote($vendor)) == null)
                {
                    $errorMessages['vendor'] = 'Wählen Sie eine gültige Marke aus.';
                }

                //check if category exists
                if(empty($category) || \myf\models\Category::findOne('id=' . $db->quote($category)) == null)
                {
                    $errorMessages['category'] = 'Wählen Sie eine gültige Kategorie aus.';
                }

                //check if productname is not new
                if(!empty($name) && \myf\models\Product::findOne('productName LIKE ' . $db->quote($name)) !== null)
                {
                    $errorMessages['productFound'] = 'Es existiert bereits ein Produkt mit dem von Ihnen gewünschten Namen!';
                }

                //check if there is at least one picture selected
                $fileNames = array_filter($_FILES['productImages']['name']);
                if(count($fileNames) == 0)
                {
                    $errorMessages['noImages'] = 'Wählen Sie mindestens ein Bild zum Upload aus!';
                }
                //validate the images
                else
                {
                    $this->validateImages('productImages', $errorMessages);
                }                

                if(count($errorMessages) === 0)
                {
                    //build new product
                    $product = new \myf\models\Product(array());
                    $product->productName        = $name;
                    $product->catchPhrase        = $catchPhrase;
                    $product->productDescription = $description;
                    $product->vendorID           = $vendor;
                    $product->categoryID         = $category;
                    $product->standardPrice      = $price;
                    $product->isHidden           = $isHidden;

                    //add images
                    $this->addImagesToProduct($product, 'productImages');

                    //insert product into database
                    $product->save();
                    //save success message to session to display in on product view
                    $_SESSION['productSuccess'] = 'Das Produkt "' . $name . '" wurde ergolgreich angelegt!';
                    //redirect to product page
                    header('Location: ?c=products&a=view&pid=' . $product->id);
                }
            }
            $this->setParam('errorMessages', $errorMessages);
        }
        else
        {
            header('Location: index.php?c=errors&a=403');
        }
    }

     
     public function actionEdit()
    {
        $this->setParam('currentPosition', 'products');
        $errorMessages = [];
        $isAdmin = $this->isAdmin();
        
        if(!$isAdmin)
        {
            header('Location: index.php?c=errors&a=403');
        }

        //check if product exists
        $productID = $_GET['pid'] ?? null;
        $product = null;

        //check if the product that has to be edited exists
        if($productID == null || !is_numeric($productID) || \myf\models\Product::findOne('id=' . $productID) == null)
        {
            header('Location: index.php?c=errors&a=404');
        }

        $product = \myf\models\Product::findOne('id=' . $productID);

        //obtain vendors from database
        $this->setParam('vendors', \myf\models\Vendor::find());
        
        //obtain categories from database
        $this->setParam('categories', \myf\models\Category::find());
        $this->setParam('product', $product);   
        
        //get inputs from from
        if(isset($_POST['submit']))
        {
            //retrieve inputs from form
            $name        = $_POST['productName'] ?? '';
            $catchPhrase = $_POST['catchPhrase'] ?? '';
            $description = $_POST['productDescription'] ?? '';
            $price       = $_POST['productPrice'] ?? '';
            $vendor      = $_POST['vendor'] ?? '';
            $category    = $_POST['category'] ?? '';
            $isHidden    = isset($_POST['isHidden']);

            //check if name is empty
            if(empty($name))
            {
                $errorMessages['productName'] = 'Bitte geben Sie einen Produktnamen an!';
            }

            //check if description is empty
            if(empty($description))
            {
                $errorMessages['description'] = 'Bitte geben Sie eine Produktbeschreibung an!';
            }

            //check if price is valid
            if(!\myf\core\validateNumberInput($price, 2))
            {
                $errorMessages['price'] = 'Geben Sie einen Preis größer 0 € und mit maximal zwei Nachkommastellen an.';
            }

            $db = $GLOBALS['database'];

            //check if vendor exists
            if(empty($vendor) || \myf\models\Vendor::findOne('id=' . $db->quote($vendor)) == null)
            {
                $errorMessages['vendor'] = 'Wählen Sie eine gültige Marke aus.';
            }

            //check if category exists
            if(empty($category) || \myf\models\Category::findOne('id=' . $db->quote($category)) == null)
            {
                $errorMessages['category'] = 'Wählen Sie eine gültige Kategorie aus.';
            }

            //check if productname is not new
            if(!empty($name) && ($name != $product->productName) && \myf\models\Product::findOne('productName LIKE ' . $db->quote($name)) !== null)
            {
                $errorMessages['productFound'] = 'Es existiert bereits ein Produkt mit dem von Ihnen gewünschten Namen!';
            }

            //check if there are files to be uploaded
            $fileNames = array_filter($_FILES['productImages']['name']);
            if(!empty($fileNames))
            {
                //check if all images are okay
                $this->validateImages('productImages', $errorMessages);
            }
            
            if(count($errorMessages) === 0)    
            {
                //go through all images of the current product
                foreach($product->images as $productImage)
                {
                    $deleteImage = isset($_POST['deleteImage' . $productImage->id]) ? true : false;
                    if($deleteImage)
                    {
                        $productImage->delete();
                    }
                    else
                    {
                        //change image title
                        $newTitle = $_POST['imageName' . $productImage->id] ?? $productImage->name;
                        $productImage->image->imageName = $newTitle;
                        $productImage->image->save();
                    }
                }

                //upload new images (if available)
                if(count($errorMessages) === 0 && !empty($fileNames))
                {
                    $this->addImagesToProduct($product, 'productImages');
                }

                //apply changes to product
                $product->productName        = $name;
                $product->catchPhrase        = $catchPhrase;
                $product->productDescription = $description;
                $product->vendorID           = $vendor;
                $product->categoryID         = $category;
                $product->standardPrice      = $price;
                $product->isHidden           = $isHidden;

                //save product to database
                $product->save();
                $_SESSION['productSuccess'] = 'Das Produkt "' . $name . '" wurde ergolgreich geändert!';
                //redirect to product page
                header('Location: ?c=products&a=view&pid=' . $product->id);
            }
        }
        $this->setParam('errorMessages', $errorMessages);
            
    }

    private function generateDirectoryPath($productName)
    {
        //make sure to replace directory separator symbols in product name
        //replace all characters that are not allowed within file names
        $directoryName = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $productName);
        
        // remove ramaining whitespaces, make sure the path is in lower case
        $directoryName = strtolower(str_replace(' ', '_', $directoryName));
        
        //create new directory path
        $directoryName = PRODUCT_IMAGE_PATH . DIRECTORY_SEPARATOR . md5($productName);
        return $directoryName;
    }

    private function validateImages($imagesKey, &$errorMessages)
    {
        //check if images are okay
        foreach($_FILES[$imagesKey]['name'] as $key => $value)
        {
            $currentFileName = basename($_FILES[$imagesKey]['name'][$key]);
            $fileType = pathinfo($currentFileName, PATHINFO_EXTENSION);
            
            //check, if file type is okay
            if(!in_array($fileType, $GLOBALS['supportedFiles']))
            {
                $errorMessages['img' . $key . 'type'] = 'Der Dateityp von ' . $currentFileName . ' wird nicht unterstützt!';
            }
            
            //check if image size is okay
            if($_FILES[$imagesKey]['size'][$key] > MAX_FILE_SIZE)
            {
                $errorMessages['img' . $key . 'size'] = 'Die Datei ' . $currentFileName . ' übersteigt die maximale Dateigröße von ' . MAX_FILE_SIZE . ' KB!';
            }
        }
    }

    private function addImagesToProduct(&$product, $imagesKey)
    {
        $directoryName = $this->generateDirectoryPath($product->productName);
        
        //create directory, if it does not exist
        if(!file_exists($directoryName))
        {
            mkdir($directoryName, 0755, true);
        }

        //upload images
        foreach($_FILES['productImages']['name'] as $key => $value)
        {
            //extract base name of file without file extension
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

    public function actionView()
    {
        $this->setParam('currentPosition', 'products');
        //check if the given pid is valid formatted
        if(!isset($_GET['pid']) || !(is_numeric($_GET['pid']) || $_GET['pid'] == 'random'))
        {
           header('Location: index.php?c=errors&a=404');
        }

        //check if there are any success messages in the session
        if(isset($_SESSION['productSuccess']))
        {
            $successMessage = $_SESSION['productSuccess'];
            unset($_SESSION['productSuccess']);
            $this->setParam('successMessage', $successMessage);
        }

        // get product id from url
        $productID = $_GET['pid'];
        
        //TODO replace isAdmin as soon as the login is done
        $isAdmin = $this->isAdmin();
        $whereClause = $isAdmin ? '' : ' AND isHidden=0';

        $product = null;

        // try to find product with id in database
        if($_GET['pid'] == 'random')
        {
            $product = \myf\models\Product::findOne('', 'RAND()');
        }
        else
        {
            $product = \myf\models\Product::findOne('id=' . $productID . $whereClause);
        }

        // check if product has been found
        if($product !== null)
        {
            //check if product should be added to the cart
            if(isset($_POST['addToCart']) && is_numeric($_POST['addToCart']))
            {
                $this->addToCart($_POST['addToCart']);
            }
            
            // save product temporary in controller to have access from view
            $this->setParam('product', $product);
        }
        else
        {
            header('Location: index.php?c=errors&a=404');
        }
    }
  
    public function actionSearch()
    {
        $this->setParam('currentPosition', 'products');
        //check if products should be added to cart
        if(isset($_POST['addToCart']) && is_numeric($_POST['addToCart']))
        {
            $this->addToCart($_POST['addToCart']);
        }
        
        //obtain vendors from database
        $vendors = \myf\models\Vendor::find();
        $this->setParam('vendors', $vendors);

        //obtain categories from database
        $categories = \myf\models\Category::find();
        $this->setParam('categories', $categories);

        //TODO: replace $isAdmin as soon as login is done
        $isAdmin = $this->isAdmin();

        //determine if users should see all products or just hidden products
        $where = $isAdmin ? '' : 'isHidden = 0'; 

        $searchString = $_GET['s'] ?? '';
       
        //retrieve vendorFilters
        $vendorFilters = [];
        foreach($vendors as $vendor)
        {
            if(isset($_GET['ven' . $vendor->id]))
            {
                array_push($vendorFilters, $vendor->id);
            }
        }

        //retrieve CategoryFilters
        $categoryFilters = [];
        foreach($categories as $category)
        {
            if(isset($_GET['cat' . $category->id]))
            {
                array_push($categoryFilters, $category->id);
            }
        }
        $minPrice = $_GET['minPrice'] ?? '';
        $maxPrice = $_GET['maxPrice'] ?? '';

        //build where
        $this->appendSearchQuery($searchString, $where, array('productName', 'catchPhrase', 'productDescription'));
        $this->appendINQuery($vendorFilters,   $where, 'vendorID');
        $this->appendINQuery($categoryFilters, $where, 'categoryID');
        
       
        if(!empty($where) && !empty($minPrice))
        {
            $where .= ' AND ';
        }
        if(!empty($minPrice))
        {
            $where .= 'standardPrice > ' . $minPrice;
        }

        if(!empty($where) && !empty($maxPrice))
        {
            $where .= ' AND ';
        }
        if(!empty($maxPrice))
        {
            $where .= 'standardPrice < ' . $maxPrice;
        }

        //build order part of the sql statement
        $order = '';
        $sort = $_GET['sort'] ?? '';
        switch($sort)
        {
            case 'nameASC':
                $order = 'productName ASC';
                break;
            case 'nameDESC':
                $order = 'productName DESC';
                break;
            case 'priceASC':
                $order = 'standardPrice ASC';
                break;
            case 'priceDESC':
                $order = 'standardPrice DESC';
                break;
            case 'dateASC':
                $order = 'createdAt ASC';
                break;
            case 'dateDESC':
                $order = 'createdAt DESC';
                break;
        }
        
        //check how many products are available
        $numberOfPages = 0;
        $currentPage = $_GET['page'] ?? 1;
        $startIndex = 0;        
        
        $products = $this->prepareProductList($numberOfPages, $currentPage, $startIndex, $where, $order);
        $this->setParam('numberOfPages', $numberOfPages);
        $this->setParam('currentPage', $currentPage);
        $this->setParam('startIndex', $startIndex);
        $this->setParam('products', $products);

        //prepare getString for navigation
        $getString = 'c=products&a=search';
        foreach($_GET AS $name => $value)
        {
            if($name != 'c' && $name != 'a' && $name != 'page')
            {
                $getString .= '&' . $name . '=' . urlencode($value);
            }
        }
        $this->setParam('getString', $getString);

    }

    private function appendINQuery($filterList, &$where, $attributeName)
    {
        if(!empty($filterList))
        {
            $db = $GLOBALS['database'];
            if(!empty($where))
            {
                $where .= ' AND ';
            }
            $where .= $attributeName .' IN (';
                foreach($filterList as $key => $id)
                {
                    $where .= $db->quote($id) . ', ';
                }
            $where = trim($where, ' ,');
            $where .= ')';
        }
    }
    
    private function appendSearchQuery($searchString, &$where, $attributes)
    {
        if(!empty($where) && !empty($searchString))
        {
            $where .= ' AND ';
        }
        if(!empty($searchString))
        {
            $db = $GLOBALS['database'];
            $where .= '(';

            //clean search String from non alphanumerical letters to increase the number of matches
            $searchString = preg_replace( '/[^a-z0-9äöüß ]/i', '', $searchString);

            $splitSearchString = explode(' ', $searchString);
            //prevent searching for the same word multiple times
            $splitSearchString = array_unique($splitSearchString);

            foreach($splitSearchString as $key => $search)
            {
                //limit number keywords to keep the sql query shorter
                if($key == SEARCH_LIMIT)
                {
                    break;
                }
                if(!empty($search))
                {
                    foreach($attributes as $attribute)
                    {
                        $where .= $attribute . ' LIKE ' . $db->quote('%' . $search . '%') . ' OR ';
                    }
                }
            }
            $where = trim($where, ' OR ');
            $where .= ')';
        }       
    }

    private function calculateNumberOfProductPages($where = '')
    {
        //calculate the number of pages
        $numberOfProducts = count(\myf\models\Product::find($where));
        $numberOfPages = ceil($numberOfProducts / PRODUCTS_PER_PAGE);
        return $numberOfPages;
    }


    private function determineCurrentPage($currentPage = 1, $numberOfPages)
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

    private function calculateStartIndex($numberOfPages, $currentPage)
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

    private function prepareProductList(&$numberOfPages, &$currentPage, &$startIndex, $where = '', $orderBy = '')
    {
        $numberOfPages = $this->calculateNumberOfProductPages($where);

        $currentPage = $this->determineCurrentPage($currentPage, $numberOfPages);

        // prepare bottom navigation to always display the same number of sites (except there are less pages than defined in PRODUCT_LIST_RANGE)
        $startIndex = $this->calculateStartIndex($numberOfPages, $currentPage);

        //get products from database
        $products = \myf\models\Product::findRange(($currentPage-1) * PRODUCTS_PER_PAGE, PRODUCTS_PER_PAGE, $where, $orderBy);
        return $products;
    }

    public function actionVendors() 
    {
        $this->setParam('currentPosition', 'products');

        //fetch all vendors from database
        $vendors = \myf\models\Vendor::find('', 'vendorName ASC');

        //fetch three random products for each vendor
        $vendorProducts = [];
        foreach($vendors as $key => $vendor)
        {
            $vendorProducts[$key] = \myf\models\Product::findRange(0,3,'vendorID = ' . $vendor->id, 'RAND()');
            
        }

        $this->setParam('vendors', $vendors);
        $this->setParam('vendorProducts', $vendorProducts);
    }
}