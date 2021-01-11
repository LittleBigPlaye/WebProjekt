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

    public function renderView()
    {
        $viewPath = VIEWSPATH . $this->controllerName . DIRECTORY_SEPARATOR .  $this->actionName . '.php';
        if(!file_exists($viewPath))
        {
            header('Location: index.php?c=errors&a=404');
        }

        extract($this->params);

        
        include (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'header.php');
        include (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'navBar.php');
        
        include ($viewPath);

        include (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'footer.php');
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
     }
}