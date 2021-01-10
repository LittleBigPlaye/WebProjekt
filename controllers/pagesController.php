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
        $this->setParam('currentPosition', 'login');
        //TODO: store error message

         $db= $GLOBALS['database'];
        $errorMessage = null;
         //check if form is submitted
         if(isset($_POST['submit'])) {
             // Check if email is empty
             if (empty(trim($_POST["user_email"]))) {
                 $errorMessage = "Bitte gib eine Email an.";
             } else {
                 $email = trim($_POST["user_email"]);
             }

             // Check if password is empty
             if (empty(trim($_POST["user_password"]))) {
                 $errorMessage = "Bitte gib ein Passwort ein.";
             } else {
                 $password = trim($_POST["user_password"]);
             }
             //check if user exists
             if (Login::findOne('email LIKE' . $db->quote($email)) == null) {
                 $errorMessage = "Es existiert kein Benutzer mit dieser Email";
             }
             $login =\myf\models\Login::findOne('email='. $db->quote($email));
             $hashed_password = $login-> passwordHash;

             //TODO prüfen ob der passwordResetHash leer ist. Wenn dieser gefüllt sein sollte muss der für die PW abfrage genutzt werden
             // --> nach der Anmeldung über den Reset muss der wieder null werden und es muss ein neues Passwort gesetzt werden

             //check if password hash is valid
             if(password_verify($password, $hashed_password)){
                 //TODO: Die Session wird bereits in der index.php gestartet, hier muss eine Session Variable gesetzt werden
                 //session_start();
                 //TODO: Bitte anschauen, was die Funktion loggedIn im Controller macht und korrigieren
                 $this->loggedIn();
             };
         }

                
                    //TODO: get current user from Database
            
                    //TODO: set values in current user

                    //TODO: store useful information (user and is logged in in session)
                    //$_SESSION['login'] = serialize($currentLogin); 
                    //TODO: redirect to previous page
                    //header('Location: index.php?c=pages&a=index');

                //TODO: increase failed login count, if password is wrong


            //TODO: set param to prefill input fields
            //$this->setParam('ParamName', $parameter);
     }



     //TODO: logout action
 }