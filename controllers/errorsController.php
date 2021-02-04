<?php
/**
 * @author Robin Beck
 */

namespace myf\controller;

class ErrorsController extends \myf\core\Controller
{
    public function action404() 
    {
        $error = $_GET['err'] ?? '';
        $errorMessage = '';
        switch($error)
        {
            case 'view':
                $errorMessage = 'Die View ';
                break;
            case 'controller':
                $errorMessage = 'Der Controller ';
                break;
            default :
                $errorMessage = 'Die gewünschte Seite';
        }
        $errorMessage .= ' konnte leider nicht gefunden werden';
        $this->setParam('errorMessage', $errorMessage);
    }

    /**
     * This action just exists to provide a 403 error view
     *
     * @return void
     */
    public function action403()
    {

    }

    /**
     * This action just exists to provide a 418 error view
     *
     * @return void
     */
    public function action418()
    {

    }

}