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
 }