<?php

/**
 * 
 */

 namespace myf\controller;

 use myf\models\Login;

 class PagesController extends \myf\core\controller
 {
    public function actionIndex()
    {
        $this->setParam('currentPosition', 'index');

        //check if products should be added to cart
        if(isset($_POST['addToCart']) && is_numeric($_POST['addToCart']))
        {
            $this->addToCart($_POST['addToCart']);
            
        }

        //fetch products for product spotlight
        $spotlightProducts = \myf\models\Product::findRange(0,4,'isHidden = 0', 'createdAt DESC');

        //open file and read products from file
        $lines = null;
        //check if file is available
        
        $cardProductsFirstRow = $this->fetchProductsFromFile('config' . DIRECTORY_SEPARATOR . 'indexProductConfiguration.txt');
        $cardProductsSecondRow = $this->fetchProductsFromFile();
        
        $this->setParam('cardProductsFirstRow', $cardProductsFirstRow);
        $this->setParam('cardProductsSecondRow', $cardProductsSecondRow);
        $this->setParam('spotlightProducts', $spotlightProducts);
    }

    private function fetchProductsFromFile($filePath = '')
    {
        $lines = null;
        if($filePath != '' && file_exists('config' . DIRECTORY_SEPARATOR . 'indexProductConfiguration.txt'))
        {
            $lines = file('config' . DIRECTORY_SEPARATOR . 'indexProductConfiguration.txt', FILE_IGNORE_NEW_LINES);
        }
        $products = array();
        $db = $GLOBALS['database'];
        
        if(is_array($lines) && count($lines) > 0)
        {
            foreach($lines as $line)
            {
                $currentProduct = \myf\models\Product::findOne('productName LIKE ' . $db->quote($line) . ' AND isHidden = 0');
                if($currentProduct === null)
                {
                    $currentProduct = \myf\models\Product::findOne('isHidden = 0', 'RAND()');
                }
                array_push($products, $currentProduct);
            }
        }
        //fallback if no products are listed within the file or the file is empty
        else
        {
            //read three random products
            $products = \myf\models\Product::findRange(0,3,'isHidden = 0', 'RAND()');
        }
        return $products;
    }

     public function actionImpressum()
     {  
        $this->setParam('currentPosition', 'impressum');
     }

     public function actionLogin()
     {

         if($this->isLoggedIn())
         {
             header('Location: index.php?c=pages&a=index');
         }

        $this->setParam('currentPosition', 'login');
         //store error message
         $errorMessages = [];
         //database connection
         $db= $GLOBALS['database'];

         //check if form is submitted
        if(isset($_POST['submit']))
        {
            $email = trim($_POST["email"]);
            $password = $_POST["user_password"];
            // Check if email is empty
            if (empty(trim($_POST["email"]))) {
                $errorMessages['email'] = "Bitte gib eine Email an.";
            }

            $login = \myf\models\Login::findOne('email=' . $db->quote($email));
            //check if user exists
            if (Login::findOne('email LIKE' . $db->quote($email)) == null) {
                $errorMessages['user'] = "Es existiert kein Benutzer mit dieser Email";
            } //check if user is enabled
            elseif ($login->enabled != 1) {
                $errorMessages['user_disabled'] = "Dieser Nutzer ist gesperrt.";
            } elseif ($login->validated != 1) {
                $errorMessages['user_validated'] = "Dieser Nutzer ist nicht validiert";
            }
            // Check if password is empty
            if (empty(trim($_POST["user_password"]))) {
                $errorMessages['password'] = "Bitte gib ein Passwort ein.";
            }

            if(count($errorMessages) === 0)
            {
                if ($login->passwordResetHash == "")
                {
                    $hashed_password = $login->passwordHash;
                }else {
                    $hashed_password = $login->passwordResetHash;
                }


                //check if password hash is valid
            if
                (password_verify($password, $hashed_password))
                {
                $_SESSION['currentLogin'] = serialize($login);
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['userID'] = $login->userID;
                header('Location: index.php?c=pages&a=index');
                $login->passwordResetHash = "";
                $login->failedLoginCount = 0;
                $login->lastLogin = date('Y-m-d H:i:s');
                $login->save();
            }
            else
                {

                    $login->failedLoginCount++;
                    if ($login->failedLoginCount == 5) {
                        $login->enabled = 0;
                    }
                    $login->save();
                    $errorMessages['wrong_password'] = "Deine Logindaten stimmen nicht überein";
                }
            }
        }
         $this->setParam('errorMessages', $errorMessages);
         //TODO: set param to prefill input fields

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
             header('Location: index.php?c=pages&a=index');
         }
     }


 }