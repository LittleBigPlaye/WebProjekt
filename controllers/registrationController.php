<?php


namespace myf\controller;


use myf\models\Address;
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

            $password = password_hash($_POST['password'],PASSWORD_DEFAULT)  ?? "";
            $password2 = password_hash($_POST['password'],PASSWORD_DEFAULT)  ?? "";
            $gender = $_POST['gender']  ?? "";
            $birthdate = $_POST['birthdate']  ?? "";

            $street = $_POST['street'] ?? "";
            $streetNumber = $_POST['streetNumber'] ?? "";
            $city = $_POST['city'] ?? "";
            $zipCode = $_POST['zipCode'] ?? "";


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
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errorMessage = "Ungültige Eingabe";
                    }
                    else{
                        $emailResult = Login::findOne('email='.$email);
                        if(is_array($emailResult))
                        {
                            $errorMessage = "Der Benutzer existiert bereits.";
                        }
                        else
                        {
                            $adressResult=Address::find("street=".$street." AND streetnumber=".$streetNumber.
                                " AND city=".$city." AND zipCode=".$zipCode);

                            if(is_array($adressResult))
                            {
                                $adressID = $adressResult->id;
                            }
                            else
                            {
                                $adressData=array('street'=> $street,
                                    'streetNumber' => $streetNumber,
                                    'city' => $city,
                                    'zipCode' => $zipCode);
                                $adress = new Address($adressData);
                                $adress->save();
                                $adressID = $adress->id;
                            }


                            $userData=array('firstName' => $firstName,
                                'secondName' => $secondName,
                                'lastName' => $lastName,
                                'gender' => $gender,
                                'birthdate' => $birthdate,
                                'addressID' => $adressID);
                            $user = new User($userData);
                            $user->save();
                            $user->id;

                            $validated = true;
                            $enabled = true;
                            $failedLoginCount = 0;

                            $loginData = array('validated' => $validated,
                                                'enabled' => $enabled,
                                                'email' => $email,
                                                'failedLoginCoun' => $failedLoginCount,
                                                'passwordHash' => $password,
                                                'userID' => $user->id);
                            $login = new Login($loginData);
                            $login->save();
                        }
                    }


                }
            }


        }


        $this->setParam('errorMessage', $errorMessage);
    }
}