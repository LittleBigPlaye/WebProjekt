<?php


namespace myf\controller;


use myf\core\Controller;
use myf\models\Product;

class ordersController extends Controller
{
    public function actionShoppingcart()
    {
        $orderItems = [];
        $totalPrice = 0;
        $order = null;

        if(isset($_SESSION['shoppingCart']) && count($_SESSION['shoppingCart'])  > 0)
        { 
            $targetQuantity  = null;
            $targetProductID = null;
            //check if the amount of an item should be changed
            if(isset($_POST['pid']) && isset($_POST['updateCart']) && isset($_POST['quantity']))
            {
                $targetQuantity  = $_POST['quantity'];
                $targetProductID = $_POST['pid'];
                if($targetQuantity <= 0)
                {
                    $targetQuantity = 0;
                    unset($_SESSION['shoppingCart'][$targetProductID]);
                }
                else
                {
                    $_SESSION['shoppingCart'][$targetProductID] = $targetQuantity;
                }
            }

            $order = new \myf\models\Order(array());
                   
            //create new Order Item for each entry in cart
            foreach($_SESSION['shoppingCart'] as $productID => $quantity)
            {
                
                //check if product ID is valid
                $currentProduct = \myf\models\Product::findOne('id=' . $productID . ' AND isHidden=0');
                if($currentProduct !== null)
                {
                    //add new Item to orders
                    $currentOrderItem = new \myf\models\OrderItem(array());
                    
                    $currentOrderItem->quantity = $quantity;
                    $currentOrderItem->productsID = $productID;
                    $currentOrderItem->actualPrice = $quantity * $currentProduct->standardPrice;

                    $order->addOrderItem($currentOrderItem);
                }
            }

            $totalPrice = $order->calculateTotalPrice();
            $_SESSION['currentOrder'] = serialize($order);

            if(isset($_POST['ajax']) && $_POST['ajax'] == 1) {
                $returnArray = array(
                    'productID' => $targetProductID,
                    'targetQuantity' => $targetQuantity,
                    'numberOfProducts' => $this->getNumberOfCartItems(),
                    'totalPrice' => strval($totalPrice)
                );
                echo json_encode($returnArray);
                exit(0);
            }
        }
        
        $this->setParam('orderItems', $orderItems);
        $this->setParam('totalPrice', $totalPrice);
        $this->setParam('order'     , $order);
        $this->setParam('currentPosition', 'shoppingcart');
    }

    public function actionConfirmOrder() 
    {
        //redirect user to login if the user is not already logged in
        if(!$this->isLoggedIn())
        {
            header('Location: index.php?c=pages&a=login');
        }

        $order = null;
        if(isset($_SESSION['currentOrder']))
        {
            $order = unserialize($_SESSION['currentOrder']);
            $this->setParam('totalPrice', $order->calculateTotalPrice());
        }
        else
        {
            header('Location: index.php?c=orders&a=shoppingcart');
        }

        if(isset($_POST['submitOrder']) && $order !== null)
        {
            //add login id of current user to order
            $order->loginID = $this->currentLogin->id;
            //save order and all orderitems to database
            $order->save();

            //remove order from current session
            unset($_SESSION['currentOrder']);

            //clear cart
            unset($_SESSION['shoppingCart']);

            //header('Location: index.php?c=pages&a=login');
            $_SESSION['success'] = 'Ihre Bestellung mit der Bestellnummer ' . str_pad($order->id,12,'0',STR_PAD_LEFT) . ' ist erfolgreich bei uns eingegangen!';
            $this->updateLastActiveTime();
            header('Location: index.php?c=accounts&a=myspace');
        }

        $this->setParam('user', $this->currentLogin->user);
        $this->setParam('address', $this->currentLogin->user->address);
        
        $this->setParam('order', $order);
    }



}