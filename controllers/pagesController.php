<?php

namespace myf\controller;

use myf\models\Login    as Login;
use myf\core\Controller as Controller;
use myf\models\Product  as Product;
/**
 * This Controller includes
 * @author Hannes Lenz, Robin Beck
 */
class PagesController extends Controller
{
    /**
     * This action is used to prepare the products that should be displayed on the index
     *
     * @return void
     */
    public function actionIndex()
    {
        $this->setPositionIndicator(Controller::POSITION_INDEX);
        //check if products should be added to cart
        if(isset($_POST['addToCart']) && is_numeric($_POST['addToCart']))
        {
            $this->addToCart($_POST['addToCart']);
        }

        //fetch products for product spotlight
        $spotlightProducts = Product::findRange(0,4,'isHidden = 0', 'createdAt DESC');

        //open file and read products from file
        $lines = null;
        //check if file is available
        
        $cardProductsFirstRow = $this->fetchProductsFromFile('config' . DIRECTORY_SEPARATOR . 'indexProductConfiguration.txt');
        $cardProductsSecondRow = $this->fetchProductsFromFile();
        
        $this->setParam('cardProductsFirstRow', $cardProductsFirstRow);
        $this->setParam('cardProductsSecondRow', $cardProductsSecondRow);
        $this->setParam('spotlightProducts', $spotlightProducts);
    }

    /**
     * This function is used to search products from a simple txt file in the database
     * If no file is given or a product has not been found, a random product will be used instead
     *
     * @param string $filePath  path to the txt that contains the product names
     * @return void
     */
    private function fetchProductsFromFile($filePath = '')
    {
        //read the given file
        $lines = null;
        if($filePath != '' && file_exists('config' . DIRECTORY_SEPARATOR . 'indexProductConfiguration.txt'))
        {
            $lines = file('config' . DIRECTORY_SEPARATOR . 'indexProductConfiguration.txt', FILE_IGNORE_NEW_LINES);
        }
        
        $db = $GLOBALS['database'];
        $products = array();
        //try to find all products with the corresponding product names
        if(is_array($lines) && count($lines) > 0)
        {
            foreach($lines as $line)
            {
                $currentProduct = Product::findOne('productName LIKE ' . $db->quote($line) . ' AND isHidden = 0');
                if($currentProduct === null)
                {
                    $currentProduct = Product::findOne('isHidden = 0', 'RAND()');
                }
                array_push($products, $currentProduct);
            }
        }
        //fallback if no products are listed within the file or the file is empty
        else
        {
            //read three random products
            $products = Product::findRange(0,3,'isHidden = 0', 'RAND()');
        }
        return $products;
    }

    /**
     * This action does just exist to provide an imprint-view
     *
     * @return void
     */
    public function actionImprint()
    {  
    }
    public function actionAboutus()
    {

    }

    public function actionLogin()
    {
        $this->setPositionIndicator(Controller::POSITION_LOGIN);
        
        //check if there are any success messages in the session
        if(isset($_SESSION['success']))
        {
            $successMessage = $_SESSION['success'];
            unset($_SESSION['success']);
            $this->setParam('successMessage', $successMessage);
        }

        if($this->isLoggedIn())
        {
            $this->redirect('index.php?c=pages&a=index');
        }

        //store error message
        $errorMessages = [];
        //database connection
        $db= $GLOBALS['database'];

        //check if form is submitted
        if(isset($_POST['submit']))
        {
            $email = trim($_POST["email"]);
            $password = $_POST["password"];
            // Check if email is empty
            if (empty(trim($_POST["email"]))) {
                $errorMessages['email'] = "Bitte gib eine Email an.";
            }

            $login = Login::findOne('email=' . $db->quote($email));
            //check if user exists
            if (Login::findOne('email LIKE' . $db->quote($email)) == null) 
            {
                $errorMessages['user'] = "Es existiert kein Benutzer mit dieser Email";
            } //check if user is enabled
            elseif ($login->enabled != 1) 
            {
                $errorMessages['user_disabled'] = "Dieser Nutzer ist gesperrt.";
            } 
            elseif ($login->validated != 1) 
            {
                $errorMessages['user_validated'] = "Dieser Nutzer ist nicht validiert";
            }
            // Check if password is empty
            if (empty(trim($password))) {
                $errorMessages['password'] = "Bitte gib ein Passwort ein.";
            }

            if(count($errorMessages) === 0)
            {
                if ($login->passwordResetHash == "")
                {
                    $hashed_password = $login->passwordHash;
                }
                else
                {
                    $hashed_password = $login->passwordResetHash;
                }


                //check if password hash is valid
                if (password_verify($password, $hashed_password))
                {
                    $_SESSION['currentLogin'] = serialize($login);
                    $_SESSION['isLoggedIn'] = true;
                    $_SESSION['userID'] = $login->usersID;
                    $login->passwordResetHash = "";
                    $login->failedLoginCount = 0;
                    $login->lastLogin = date('Y-m-d H:i:s');
                    $login->save();
                    $this->redirect('index.php?c=pages&a=index');
                }
                else
                {

                    $login->failedLoginCount++;
                    if ($login->failedLoginCount == 5) 
                    {
                        $login->enabled = 0;
                    }
                    $login->save();
                    $errorMessages['wrong_password'] = "Deine Logindaten stimmen nicht überein";
                }
            }
        }
        $this->setParam('errorMessages', $errorMessages);
    }

    public function actionLogout()
    {
        if($this->isLoggedIn())
        {
            $_SESSION['isLoggedIn'] = false;
            session_destroy();
        }
        else
        {
        $this->redirect('index.php?c=pages&a=index'); 
        }
    }


 }