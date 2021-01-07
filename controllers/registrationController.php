<?php


namespace myf\controller;


use myf\core\Controller;

class registrationController extends Controller
{

    public function actionRegistration()
    {
        $errorMessage = "Der Benutzer existiert bereits.";

        if(isset($_POST['submit']))
        {
            $firstName = $_POST['firstName'];
            $secondName = $_POST['secondName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            //TODO Passworthash direkt berechnen lassen für die folgen 2 Variablen
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            $gender = $_POST['gender'];
            $birthdate = $_POST['birthdate'];

        }
    }
}