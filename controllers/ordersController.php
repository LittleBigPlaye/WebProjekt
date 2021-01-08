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
            $productResult = \myf\models\Product::findOne('id='.$productID);
            if(is_array($productResult))
            {
                array_push($products, new Product($productResult));
            }
        }

        $this->setParam('products', $products);
        $this->setParam('currentPosition', 'shoppingcart');
    }
}