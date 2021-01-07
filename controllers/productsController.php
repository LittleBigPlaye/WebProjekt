<?php
/**
 * @author Robin Beck
 */


namespace myf\controller;

 class ProductsController extends \myf\core\controller
 {
     
    public function actionNew()
     {
        $errorMessage = '';
        $isAdmin = false;
        if($isAdmin)
        {
            //obtain vendors from database
            $this->setParam('vendors', $this->loadVendors());

            //obtain categories from database
            $this->setParam('categories', $this->loadCategories());

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
                $isHidden    = isset($_POST['isHidden']) ? true : false;

                //check, if inputs are valid
                if(!empty($name) && !empty($description) && \myf\core\validateNumberInput($price, 2) && !empty($vendor) && !empty($category))
                {
                    $db = $GLOBALS['database'];

                    //check if product with same name already exists
                    if(is_array(\myf\models\Product::findOne('productName LIKE ' . $db->quote($name))))
                    {
                        $errorMessage = 'Ein Produkt mit dem angegebenen Namen existiert bereits!';
                    }
                    else
                    {
                        //check if there are files to be uploaded
                        $fileNames = array_filter($_FILES['productImages']['name']);
                        if(!empty($fileNames))
                        {
                            $this->validateImages($name, 'productImages', $errorMessage);

                            if(empty($errorMessage))
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

                                //redirect to product page
                                header('Location: ?c=products&a=view&pid=' . $product->id);
                            }
                        }
                        else
                        {
                            $errorMessage = 'Bitte wählen Sie mindestens ein Bild zum Upload für das Produkt aus!';
                        }
                    }
                }
                else
                {
                    $errorMessage = 'Bitte füllen Sie alle Felder aus!';
                }
            }
            $this->setParam('errorMessage', $errorMessage);
        }
        else
        {
            header('Location: index.php?c=errors&a=403');
        }
     }

     
     public function actionEdit()
     {
        $errorMessage = '';
        $isAdmin = true;
        if($isAdmin)
        {
            //check if product exists
            $productID = $_GET['pid'] ?? null;
            $productResult = null;
            if($productID != null && is_numeric($productID))
            {
                $productResult = \myf\models\Product::findOne('id=' . $productID);
            }
            if($productResult != null && is_array($productResult))
            {
                //load Product
                $product = new \myf\models\Product($productResult);

                //obtain vendors from database
                $this->setParam('vendors', $this->loadVendors());

                //obtain categories from database
                $this->setParam('categories', $this->loadCategories());
                $this->setParam('product', $product);
                //get inputs from from
                if(isset($_POST['submit']))
                {
                    $name        = $_POST['productName'] ?? '';
                    $catchPhrase = $_POST['catchPhrase'] ?? '';
                    $description = $_POST['productDescription'] ?? '';
                    $price       = $_POST['productPrice'] ?? '';
                    $vendor      = $_POST['vendor'] ?? '';
                    $category    = $_POST['category'] ?? '';
                    $isHidden    = isset($_POST['isHidden']) ? true : false;

                    //check if inputs are valid
                    if(!empty($name) && !empty($description) && \myf\core\validateNumberInput($price, 2) && !empty($vendor) && !empty($category))
                    {
                        $db = $GLOBALS['database'];
                        //check if product with same name already exists
                        if($name != $product->productName && is_array(\myf\models\Product::findOne('productName LIKE ' . $db->quote($name))))
                        {
                            $errorMessage = 'Ein Produkt mit dem angegebenen Namen existiert bereits!';
                        }
                        else
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

                            //check if there are files to be uploaded
                            $fileNames = array_filter($_FILES['productImages']['name']);
                            if(!empty($fileNames))
                            {
                                //check if all images are okay
                                $this->validateImages($name, 'productImages', $errorMessage);
                                if(empty($errorMessage))
                                {
                                    $this->addImagesToProduct($product, 'productImages');
                                }
                            }

                            if(empty($errorMessage))
                            {
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

                                //redirect to product page
                                header('Location: ?c=products&a=view&pid=' . $product->id);
                            }
                        }
                    }
                    else
                    {
                        $errorMessage = 'Bitte alle Felder ausfüllen!';
                    }
                }
                $this->setParam('errorMessage', $errorMessage);
            }
            else
            {
                header('Location: index.php?c=errors&a=404');
            }
        }
        else
        {
            header('Location: index.php?c=errors&a=403');
        }
     }

    private function generateDirectoryPath($productName)
    {
        //make sure to replace directory separator symbols in product name
        //replace all characters that are not allowed within file names
        $directoryName = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $productName);
        // remove ramaining whitespaces, make sure the path is in lower case
        $directoryName = strtolower(str_replace(' ', '_', $directoryName));
        //create new directory path
        $directoryName = PRODUCT_IMAGE_PATH . DIRECTORY_SEPARATOR . $directoryName;
        return $directoryName;
    }

    private function validateImages($productName, $imagesKey, &$errorMessage)
    {
        $directoryName = $this->generateDirectoryPath($productName);
        
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

    private function addImagesToProduct(&$product, $imagesKey)
    {
        $directoryName = $this->generateDirectoryPath($product->productName);
        
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
         if(isset($_GET['pid']) && is_numeric($_GET['pid']))
         {
            // get product id from url
            $productID = $_GET['pid'];

            //TODO replace isAdmin as soon as the login is done
            $isAdmin = true;
            $whereClause = $isAdmin ? '' : ' AND isHidden=0';
            // try to find product with id in database
            $productResult = \myf\models\Product::findOne('id=' . $productID . $whereClause);

            // check if product has been found
            if(is_array($productResult))
            {
                // create new product
                $product = new \myf\models\Product($productResult);

                if(isset($_GET['IDForCart']) && is_numeric($_GET['IDForCart']))
                {
                    $this->addToCart($_GET['IDForCart']);
                }
                // save product temporary in controller to have access from view
                $this->setParam('product', $product);
            }
            else
            {
                header('Location: index.php?c=errors&a=404');
            }
         }
         else
         {
            header('Location: index.php?c=errors&a=404');
         }
     }
  

    public function actionList()
    {
        //set current position for nav bar highlight
        $this->setParam('currentPosition', 'products');
        if(isset($_GET['IDForCart']) && is_numeric($_GET['IDForCart']))
        {
            $this->addToCart($_GET['IDForCart']);
        }
        //TODO: replace $isAdmin as soon as login is done
        $isAdmin = true;
        
        //determine if users should see all products or just hidden products
        $where = $isAdmin ? '' : 'isHidden = 0'; 
        //check how many products are available
        $numberOfPages = 0;
        $currentPage = $_GET['page'] ?? 1; ;
        $startIndex = 0;
               
        $products = $this->prepareProductList($numberOfPages, $currentPage, $startIndex, $where);
        $this->setParam('numberOfPages', $numberOfPages);
        $this->setParam('currentPage', $currentPage);
        $this->setParam('startIndex', $startIndex);
        $this->setParam('products', $products);
    }

    public function actionSearch()
    {
        //obtain vendors from database
        $vendors = $this->loadVendors();
        $this->setParam('vendors', $vendors);

        //obtain categories from database
        $categories = $this->loadCategories();
        $this->setParam('categories', $categories);

        //TODO: replace $isAdmin as soon as login is done
        $isAdmin = true;

        //determine if users should see all products or just hidden products
        $where = $isAdmin ? '' : 'isHidden = 0'; 

        $searchString = $_GET['s'] ?? '';
       
        //retrieve vendorFilters
        $vendorFilters = [];
        foreach($vendors as $vendor)
        {
            if(isset($_GET['v' . $vendor->id]))
            {
                array_push($vendorFilters, $vendor->id);
            }
        }

        //retrieve CategoryFilters
        $categoryFilters = [];
        foreach($categories as $category)
        {
            if(isset($_GET['c' . $category->id]))
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
        $currentPage = $_GET['page'] ?? 1; ;
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

            $splitSearchString = explode(' ', $searchString);
            foreach($splitSearchString as $search)
            {
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

    private function loadVendors()
    {
        $vendorResults = \myf\models\Vendor::find();
            $vendors = [];
            foreach($vendorResults as $result)
            {
                array_push($vendors, new \myf\models\Vendor($result));
            }
        return $vendors;
    }

    private function loadCategories()
    {
        $categoryResults = \myf\models\Category::find();
            $categories = [];
            foreach($categoryResults as $result)
            {
                array_push($categories, new \myf\models\Category($result));
            }
        return $categories;
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

    public function addToCart($productID)
     {
            if(is_array(\myf\models\Product::findOne('id=' . $productID)))
            {
                if(!isset($_SESSION['cartInfos']))
                {
                    $_SESSION['cartInfos']= array(); //erzeugt ein leeres Array
                }

                array_push($_SESSION['cartInfos'], $productID);
            }

     }
 }