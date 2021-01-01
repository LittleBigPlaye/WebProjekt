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
        //TODO check if user is logged in and is admin
        //obtain vendors from database
        $this->setParam('vendors', \myf\core\loadVendors());

        //obtain categories from database
        $this->setParam('categories', \myf\core\loadCategories());

        //check, if form has been submitted
        if(isset($_POST['submit']))
        {
            //get inputs from form
            $name        = $_POST['productName'];
            $catchPhrase = $_POST['catchPhrase'];
            $description = $_POST['productDescription'];
            $price       = $_POST['productPrice'];
            $vendor      = $_POST['vendor'];
            $category    = $_POST['category'];

            //check, if inputs are valid
            if(!empty($name) && !empty($description) && \myf\core\validateNumberInput($price, 2) && !empty($vendor) && !empty($category))
            {
                //check if product with same name already exists
                if(is_array(\myf\models\Product::findOne('productName LIKE "' . $name .'"')))
                {
                    $errorMessage = 'Ein Produkt mit dem angegebenen Namen existiert bereits!';
                }
                else
                {
                    //TODO add function to upload and validate images
                    //check if there are files to be uploaded
                    $fileNames = array_filter($_FILES['productImages']['name']);
                    if(!empty($fileNames))
                    {
                        //make sure to replace directory separator symbols in product name
                        //replace all characters that are not allowed within file names
                        $directoryName = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $name);
                        // remove ramaining whitespaces, make sure the path is in lower case
                        $directoryName = strtolower(str_replace(' ', '_', $directoryName));
                        $directoryName = PRODUCT_IMAGE_PATH . DIRECTORY_SEPARATOR . $directoryName;
                        //create directory, if it does not exist
                        if(!file_exists($directoryName))
                        {
                            mkdir($directoryName, 0755, true);
                        }
                        echo $directoryName;

                        //check if images are okay
                        foreach($_FILES['productImages']['name'] as $key => $value)
                        {
                            $currentFileName = basename($_FILES['productImages']['name'][$key]);
                            $fileType = pathinfo($currentFileName, PATHINFO_EXTENSION);
                            //check, if file type is okay
                            if(!in_array($fileType, $GLOBALS['supportedFiles']))
                            {
                                $errorMessage = 'Der Dateityp von ' . $currentFileName . ' wird nicht unterstützt!';
                                break;
                            }
                            //check if image size is okay
                            if($_FILES['productImages']['size'][$key] > MAX_FILE_SIZE)
                            {
                                $errorMessage = 'Die Datei ' . $currentFileName . ' übersteigt die maximale Dateigröße von ' . MAX_FILE_SIZE . ' KB!';
                                break;
                            }
                        }

                        //echo  date('Ydmhis', time());

                        if(empty($errorMessage))
                        {
                            $product = new \myf\models\Product(array());

                            //upload images
                            foreach($_FILES['productImages']['name'] as $key => $value)
                            {
                                //make sure the file name is unique
                                $currentFileName = str_replace(' ', '_', basename($_FILES['productImages']['name'][$key]));
                                $imageName       = substr(pathinfo($currentFileName, PATHINFO_BASENAME), 0, 10) . date('Ydmhis', time());
                                $fileType        = pathinfo($currentFileName, PATHINFO_EXTENSION); 
                                $targetPath      = $directoryName . DIRECTORY_SEPARATOR . $imageName . '.' . $fileType;

                                //try to upload the file
                                //try to upload the file
                                $uploadWasSuccessful = \move_uploaded_file($_FILES['productImages']['tmp_name'][$key], $targetPath);
                                if($uploadWasSuccessful)
                                {
                                    $product->addImage($targetPath);
                                }
                            }

                            //build new product
                            
                            $product->productName        = $name;
                            $product->catchPhrase        = $catchPhrase;
                            $product->productDescription = $description;
                            $product->vendorID           = $vendor;
                            $product->categoryID         = $category;
                            $product->standardPrice      = $price;
                            //insert product into database
                            $product->save();

                            //redirect to product page
                            header('Location: ?c=products&a=view&prod=' . $product->id);
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
                $errorMessage = 'Bitte alle Felder ausfüllen!';
            }
        }
        $this->setParam('errorMessage', $errorMessage);
     }

     
     public function actionEdit()
     {
        $errorMessage = '';
        //TODO check if user is logged in and is admin
        //check if product exists
        $productID = $_GET['product'] ?? null;
        $productResult = null;
        if($productID != null)
        {
            $productResult = \myf\models\Product::findOne('id=' . $productID);
        }
        if($productResult != null && is_array($productResult))
        {
            //load Product
            $product = new \myf\models\Product($productResult);

            //obtain vendors from database
            $this->setParam('vendors', \myf\core\loadVendors());

            //obtain categories from database
            $this->setParam('categories', \myf\core\loadCategories());
            $this->setParam('product', $product);
            //get inputs from from
            if(isset($_POST['submit']))
            {
                $name        = $_POST['productName'];
                $catchPhrase = $_POST['catchPhrase'];
                $description = $_POST['productDescription'];
                $price       = $_POST['productPrice'];
                $vendor      = $_POST['vendor'];
                $category    = $_POST['category'];

                //check if inputs are valid
                if(!empty($name) && !empty($description) && \myf\core\validateNumberInput($price, 2) && !empty($vendor) && !empty($category))
                {
                    //check if product with same name already exists
                    if($name != $product->productName && is_array(\myf\models\Product::findOne('productName LIKE "' . $name .'"')))
                    {
                        $errorMessage = 'Ein Produkt mit dem angegebenen Namen existiert bereits!';
                    }
                    else
                    {
                        //TODO: image handling
                        //apply changes to product
                        $product->productName        = $name;
                        $product->catchPhrase        = $catchPhrase;
                        $product->productDescription = $description;
                        $product->vendorID           = $vendor;
                        $product->categoryID         = $category;
                        $product->standardPrice      = $price;

                        //save product to database
                        $product->save();

                        //redirect to product page
                        header('Location: ?c=products&a=view&prod=' . $product->id);
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
            //TODO: direct to 404 page
            die();
        }
     }

     public function actionView()
     {
         if(isset($_GET['prod']))
         {
            // get product id from url
            $productID = $_GET['prod'];
            // try to find product with id in database
            $productResult = \myf\models\Product::findOne('id=' . $productID);

            // check if product has been found
            if(is_array($productResult))
            {
                // create new product
                $product = new \myf\models\Product($productResult);
                // save product temporary in controller to have access from view
                $this->setParam('product', $product);
            }
            else
            {
                // TODO - Redirect to 404 page
                echo "Produkt nicht gefunden";
            }
         }
         else
         {
             //TODO - Redirect to 404 page
         }
     }

     public function actionList()
     {
         if(isset($_GET['IDForCart']))
         {
             $this->addToCart($_GET['IDForCart']);
         }


        $this->setParam('currentPosition', 'products');
        $page = $_GET['page'] ?? 1; 
        
        //check how many products are available
        $numberOfProducts = count(\myf\models\Product::find());
        //calculate the number of pages
        $numberOfPages = ceil($numberOfProducts / PRODUCTS_PER_PAGE);

        $this->setParam('numberOfPages', $numberOfPages);
        
        //determine current page
        $page = ($page > $numberOfPages) ? $numberOfPages : $page;
        if($numberOfPages > 0 && $page > $numberOfPages)
        {
            $page = $numberOfPages;
        }
        else if($page < 1)
        {
            $page = 1;
        }
        $this->setParam('currentPage', $page);

        //prepare bottom navigation to always display the same number of sites (except there are less pages than defined in PRODUCT_LIST_RANGE)
        $startIndex = 0;

        if($numberOfPages - $page < PRODUCT_LIST_RANGE)
        {
            $deltaPages = PRODUCT_LIST_RANGE - ($numberOfPages - $page);
            $startIndex = max($page-$deltaPages, 0);
        }
        else
        {
            $startIndex = $page;
        }
        $this->setParam('startIndex', $startIndex);

        //get products from database
        $productResults = \myf\models\Product::findRange(($page-1) * PRODUCTS_PER_PAGE, PRODUCTS_PER_PAGE);
         if(is_array($productResults))
         {
             $products = [];
             foreach($productResults as $result)
             {
                array_push($products, new \myf\models\Product($result));
             }
             $this->setParam('products', $products);
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