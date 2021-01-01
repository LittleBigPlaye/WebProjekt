<?php

namespace myf\core;

abstract class Controller
{
    protected $controllerName   = null;
    protected $actionName       = null;
    protected $currentUser      = null;
    
    protected $params = [];

    public function __construct($controllerName, $actionName)
    {
        $this->controllerName = $controllerName;
        $this->actionName     = $actionName;

        if($this->loggedIn())
        {
            //TODO: stuff, when user is logged in
            //TODO: store current user in $currentUser
        }
    }


    public function loggedIn()
    {
        return (isset($_SESSION['isLoggedIn']) && ($_SESSION['isLoggedIn'] === true));
    }

    public function renderView()
    {
        $viewPath = VIEWSPATH . $this->controllerName . DIRECTORY_SEPARATOR .  $this->actionName . '.php';
        if(!file_exists($viewPath))
        {
            //TODO: proper 404 page
            die ('404 no view available');
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
}