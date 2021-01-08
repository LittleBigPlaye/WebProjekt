<?php


namespace myf\controller;


use myf\core\Controller;
use myf\models\Product;

class ordersController extends Controller
{
    public function actionShoppingcart()
    {
        $products = [];
        foreach ($_SESSION['cartInfos'] as $productID )
        {
            $currentProduct = \myf\models\Product::findOne('id='.$productID);
            if($currentProduct !== null)
            {
                array_push($products, $currentProduct);
            }
        }
        $this->setParam('products', $products);
        $this->setParam('currentPosition', 'shoppingcart');
    }
}