<?php

/**
 * 
 */

 namespace myf\controller;

 class PagesController extends \myf\core\controller
 {
     public function actionIndex()
     {
         $this->setParam('currentPosition', 'index');
     }

     public function actionImpressum()
     {  
        $this->setParam('currentPosition', 'impressum');
     }

     public function actionLogin()
     {
        $this->setParam('currentPosition', 'login');
        //TODO: store error message
        $errorMessage = null;

        //TODO: check if form is submitted
        
            //TODO: retrieve input

            //TODO: validate values

                //TODO: check if user exists

                //TODO: check if password hash is valid
                
                    //TODO: get current user from Database
            
                    //TODO: set values in current user

                    //TODO: store useful information (user and is logged in in session)
                    //$_SESSION['login'] = serialize($currentLogin); 
                    //TODO: redirect to previous page
                    //header('Location: index.php?c=pages&a=index');

                //TODO: increase failed login count, if password is wrong

            //TODO: set error Message, if values are empty

            //TODO: set param to prefill input fields
            //$this->setParam('ParamName', $parameter);
     }



     //TODO: logout action


     public function actionShoppingCart()
     {
         $this->setParam('currentPosition', 'shoppingcart');
     }
 }