<?php


namespace myf\controller;


use myf\models\User;
use myf\core\Controller;
use myf\models\Login;

class registrationController extends Controller
{

    public function actionRegistration()
    {
        $errorMessage = "Der Benutzer existiert bereits.";

        if(isset($_POST['submit']))
        {

            $firstName = $_POST['firstName'] ?? "";
            $secondName = $_POST['secondName']  ?? "";
            $lastName = $_POST['lastName']  ?? "";
            $email = $_POST['email'];
            //TODO Passworthash direkt berechnen lassen für die folgen 2 Variablen
            $password = password_hash($_POST['password'],PASSWORD_DEFAULT)  ?? "";
            $password2 = password_hash($_POST['password'],PASSWORD_DEFAULT)  ?? "";
            $gender = $_POST['gender']  ?? "";
            $birthdate = $_POST['birthdate']  ?? "";

            //TODO hier kommt noch das zeug aus der adresse

            if(empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($password2) || empty($birthdate) )
            {
                $errorMessage = "Es wurden nicht alle nötigen Felder ausgeüllt!";
            }
            else
            {
                if($password !== $password2){
                    $errorMessage = "Es wurden nicht alle nötigen Felder richtig ausgeüllt!";
                }
                else{
                    //TODO Email prüfen ob existend und richtige schreibweise (RegEx Email)
                    $emailResult = Login::findOne('email='.$email);
                    if(is_array($emailResult))
                    {
                        $errorMessage = "Der Benutzer existiert bereits.";
                    }
                    else
                    {
                        //TODO Vorher Adresse fertig machen
                        //$userData=array('firstName' => $firstName, der rest von oben);
                        //$user = new User($userData);
                        //$user->save();

                        //$user->id;
                    }
                    //TODO Adresse prüfen --> wenn noch nciht vergeben die neue anlegen
                }
            }


        }


        $this->setParam('errorMessage', $errorMessage);
    }
}