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

        if($this->isLoggedIn())
        {
            //TODO: stuff, when user is logged in
            //TODO: store current user in $currentUser
        }
    }


    public function isLoggedIn()
    {
        return (isset($_SESSION['isLoggedIn']) && ($_SESSION['isLoggedIn'] === true));
    }

    public function isAdmin()
    {
        //TODO: remove next line when login is done and uncomment the other return
        return true;
        //return ($this->isLoggedIn() && $this->currentLogin->user->role === 'admin');
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
            if(\myf\models\Product::findOne('id=' . $productID) !== null)
            {
                if(!isset($_SESSION['cartInfos']))
                {
                    $_SESSION['cartInfos']= array(); //erzeugt ein leeres Array
                }

                array_push($_SESSION['cartInfos'], $productID);
            }

     }
}