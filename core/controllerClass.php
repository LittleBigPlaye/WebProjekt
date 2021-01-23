<?php

namespace myf\core;

abstract class Controller
{
    protected $controllerName   = null;
    protected $actionName       = null;
    protected $currentLogin      = null;
    
    protected $params = [];

    public function __construct($controllerName, $actionName)
    {
        $this->controllerName = $controllerName;
        $this->actionName     = $actionName;
        
        if($this->isLoggedIn() && isset($_SESSION['currentLogin']))
        {
            $this->currentLogin = unserialize($_SESSION['currentLogin']);
            $this->setParam('userRole', $this->currentLogin->user->role);
        }
    }


    public function isLoggedIn()
    {
        return (isset($_SESSION['isLoggedIn']) && ($_SESSION['isLoggedIn'] === true));
    }

    public function isAdmin()
    {
        return ($this->isLoggedIn() && $this->currentLogin->user->role === 'admin');
    }

    public function updateLastActiveTime()
    {
        if($this->currentLogin != null)
        {
            $this->currentLogin->lastActive = date('Y-m-d H:i:s');
            echo date('Y-m-d H:i:s');
            $this->currentLogin->save();
        }
    }

    public function renderView()
    {
        $viewPath = VIEWSPATH . $this->controllerName . DIRECTORY_SEPARATOR .  $this->actionName . '.php';
        if(!file_exists($viewPath))
        {
            header('Location: index.php?c=errors&a=404');
        }

        extract($this->params);

        require_once (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'header.php');
        require_once (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'navBar.php');
        echo '<div class="content">';
        
        require_once ($viewPath);

        echo '</div>';
        require_once (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'footer.php');
        require_once (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'upButton.php');

    }



    protected function setParam($key, $value = null)
    {
        $this->params[$key] = $value;
    }

    public function __destruct()
    {
        $this->controllerName   = null;
        $this->actionName       = null;
        $this->params           = null;
    }

    protected function addToCart($productID)
    {
        //check if the given Product ID is an valid id
        if(\myf\models\Product::findOne('id=' . $productID . ' AND isHidden=false') !== null)
        {
            if(!isset($_SESSION['shoppingCart']))
            {
                $_SESSION['shoppingCart'] = array(); 
            }
            //check if the current Product has already been added to the shopping cart
            if(isset($_SESSION['shoppingCart'][$productID]))
            {
                //increase quantity
                $_SESSION['shoppingCart'][$productID]++;
            }
            else
            {
                $_SESSION['shoppingCart'][$productID] = 1;
            }
        }
        if(isset($_GET['ajax'])) 
        {
            echo $this->getNumberOfCartItems();
            exit(0);
        }
    }

    public function getNumberOfCartItems() 
    {
        $numberOfCartItems = 0;
        if(isset($_SESSION['shoppingCart']))
        {
            $numberOfCartItems = array_sum($_SESSION['shoppingCart']);
        }
        return $numberOfCartItems;
    }

}