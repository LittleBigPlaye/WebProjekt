<?php

namespace myf\controller;

 class ProductsController extends \myf\core\controller
 {
     public function actionNewProduct()
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
            //check, if inputs are valid
            $name        = $_POST['productName'];
            $catchPhrase = $_POST['catchPhrase'];
            $description = $_POST['productDescription'];
            $price       = $_POST['productPrice'];
            $vendor      = $_POST['vendor'];
            $category    = $_POST['category'];

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
                    //build new product
                    $product = new \myf\models\Product(array());
                    $product->productName        = $name;
                    $product->catchPhrase        = $catchPhrase;
                    $product->productDescription = $description;
                    $product->vendorID           = $vendor;
                    $product->categoryID         = $category;
                    $product->standardPrice      = $price;
                    
                    //insert product into database
                    $product->save();
                }

            }
            else
            {
                $errorMessage = 'Bitte alle Felder ausfüllen!';
            }
        }
        $this->setParam('errorMessage', $errorMessage);
     }

     public function actionEditProduct()
     {
        //TODO check if user is logged in and is admin
     }

     public function actionViewProduct()
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

     public function actionListProducts()
     {
        $this->setParam('currentPosition', 'products');
        $page = $_GET['page'] ?? 1; 
        
        //check how many products are available
        $numberOfProducts = count(\myf\models\Product::find());
        //calculate the number of pages
        $numberOfPages = ceil($numberOfProducts / PRODUCTS_PER_PAGE);

        $this->setParam('numberOfPages', $numberOfPages);
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
 }