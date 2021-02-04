<?php

namespace myf\core;

/**
 * This class is used as a base for all controllers and provides some essential functions
 * @author Robin Beck
 */
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


    /**
     * This function is used to check wether a user is logged in or not
     *
     * @return boolean true, if a user is logged in
     */
    public function isLoggedIn()
    {
        return (isset($_SESSION['isLoggedIn']) && ($_SESSION['isLoggedIn'] === true));
    }

    /**
     * This function is used to check wether the currently logged is user has administrative
     * privileges or not
     *
     * @return boolean true, if the current user has administrative privileges
     */
    public function isAdmin()
    {
        return ($this->isLoggedIn() && $this->currentLogin->user->role === 'admin');
    }

    /**
     * This function is used to update the current users "last active time"
     *
     * @return void
     */
    public function updateLastActiveTime()
    {
        if($this->currentLogin != null)
        {
            $this->currentLogin->lastActive = date('Y-m-d H:i:s');
            echo date('Y-m-d H:i:s');
            $this->currentLogin->save();
        }
    }

    /**
     * This function is used to display / render the desired view
     * It redirects to the 404 view, if no view has been found
     *
     * @return void
     */
    public function renderView()
    {
        $viewPath = VIEWSPATH . $this->controllerName . DIRECTORY_SEPARATOR .  $this->actionName . '.php';

        if(!file_exists($viewPath))
        {
            $this->redirect('index.php?c=errors&a=404&err=view');
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

    /**
     * Used to unify the redirect process within the controllers
     *
     * @param string $targetURL the url that should be reached
     * @return void
     */
    protected function redirect ($targetURL) {
        header('Location: ' . $targetURL);
        exit(0);
    }

    /**
     * This function is used to add a param to the params array
     * added params become available to the view after rendering
     *
     * @param string $key   the name that should be used for the param
     * @param [type] $value tha actual value of the param
     * @return void
     */
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

    /**
     * This function is used to add items to the shopping cart.
     * It can be also used to add items dynamically with ajax
     *
     * @param int $productID    must be id of existing product. The product must not be hidden
     * @return void             prints number of cart items, if ajax is set in post
     */
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
        if(isset($_POST['ajax']) && $_POST['ajax'] == 1) 
        {
            echo $this->getNumberOfCartItems();
            exit(0);
        }
    }

    /**
     * This function is used to calculate the current number of items inside the cart
     *
     * @return int  the number of cart items, minimum: 0 
     */
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