<?php

namespace myf\controller;

 class ProductsController extends \myf\core\controller
 {
     public function actionNewProduct()
     {
        //TODO check if user is logged in and is admin
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
 }