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
                //check if product with same name already exists
                if(is_array(\myf\models\Product::findOne('productName LIKE "' . $name .'"')))
                {
                    $errorMessage = 'Ein Produkt mit dem angegebenen Namen existiert bereits!';
                }
                else
                {
                    //check if there are files to be uploaded
                    $fileNames = array_filter($_FILES['productImages']['name']);
                    if(!empty($fileNames))
                    {
                        \myf\core\validateImages($name, 'productImages', $errorMessage);

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
                            \myf\core\addImagesToProduct($product, 'productImages');

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
                    //check if product with same name already exists
                    if($name != $product->productName && is_array(\myf\models\Product::findOne('productName LIKE "' . $name .'"')))
                    {
                        $errorMessage = 'Ein Produkt mit dem angegebenen Namen existiert bereits!';
                    }
                    else
                    {
                        //TODO: image handling
                        //go through all images of the current product
                        foreach($product->images as $productImage)
                        {
                            //TODO: check if image should be deleted
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
                            \myf\core\validateImages($name, 'productImages', $errorMessage);
                            if(empty($errorMessage))
                            {
                                \myf\core\addImagesToProduct($product, 'productImages');
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
                            header('Location: ?c=products&a=view&prod=' . $product->id);
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
        $this->setParam('currentPosition', 'products');
        $page = $_GET['page'] ?? 1; 
        
        //check how many products are available
        //TODO: replace $isAdmin as soon as login is done
        $isAdmin = true;
        //determine if users should see all products or just hidden products
        $whereClause = $isAdmin ? '' : 'isHidden = 0'; 

        //calculate the number of pages
        $numberOfProducts = count(\myf\models\Product::find($whereClause));
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

        // prepare bottom navigation to always display the same number of sites (except there are less pages than defined in PRODUCT_LIST_RANGE)
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
        $productResults = \myf\models\Product::findRange(($page-1) * PRODUCTS_PER_PAGE, PRODUCTS_PER_PAGE, $whereClause);
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
 }