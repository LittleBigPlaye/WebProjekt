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
     }
     public function actionRegister()
     {
         $this->setParam('currentPosition', 'register');
     }

     public function actionShoppingCart()
     {
         $this->setParam('currentPosition', 'shoppingcart');
     }
 }