<?php


namespace myf\controller;


use myf\models\Address;
use myf\models\User;
use myf\core\Controller;
use myf\models\Login;

class accountsController extends Controller
{


    public function actionRegister()
    {

        if(isset($_POST['submit']))
        {

            $firstName      = $_POST['firstName'] ?? "";
            $secondName     = $_POST['secondName']  ?? "";
            $lastName       = $_POST['lastName']  ?? "";
            $email          = $_POST['email'];
            $password       = password_hash($_POST['password'],PASSWORD_DEFAULT)  ?? "";
            $password2      = $_POST['password2']  ?? "";
            $gender         = $_POST['gender']  ?? "";
            $birthdate      = $_POST['birthdate']  ?? "";

            $street         = $_POST['street'] ?? "";
            $streetNumber   = str_replace(' ', '', $_POST['streetNumber'] ?? "");
            $city           = $_POST['city'] ?? "";
            $zipCode        = $_POST['zipCode'] ?? "";

            $db = $GLOBALS['database'];


            if(empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($password2) || empty($birthdate) )
            {
                $errorMessage = "Es wurden nicht alle nötigen Felder ausgeüllt!";
            }
            else
            {
                if(!password_verify($password2,$password)){
                    $errorMessage = "Schau mal Passwort";
                }
                else{
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errorMessage = "Ungültige Eingabe";
                    }
                    else{
                        if(Login::findOne('email LIKE'.$db->quote($email)) !== null)
                        {
                            $errorMessage = "Der Benutzer existiert bereits.";
                        }
                        else
                        {
                            $address = Address::findOne("street=".$db->quote($street)." AND streetnumber=".$db->quote($streetNumber).
                                " AND city=".$db->quote($city)." AND zipCode=".$db->quote($zipCode));

                            if($address !== null)
                            {
                                $adressID = $address->id;
                            }
                            else
                            {
                                $adressData=array(
                                    'street'=> $street,
                                    'streetNumber' => $streetNumber,
                                    'city' => $city,
                                    'zipCode' => $zipCode);
                                $adress = new Address($adressData);
                                $adress->save();
                                $adressID = $adress->id;
                            }


                            $userData = array(
                                                'firstName' => $firstName,
                                                'secondName' => $secondName,
                                                'lastName' => $lastName,
                                                'gender' => $gender,
                                                'birthDate' => $birthdate,
                                                'addressID' => $adressID);
                            $user = new User($userData);
                            $user->save();
                            $user->id;

                            $validated = true;
                            $enabled   = true;
                            $failedLoginCount = 0;

                            $loginData = array(
                                                'validated' => $validated,
                                                'enabled' => $enabled,
                                                'email' => $email,
                                                'failedLoginCount' => $failedLoginCount,
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

    public function actionAdminusermanagement()
    {
        $users = User::find();
        $this->setParam('users',$users);

        $logins = Login::find();
        $this->setParam('logins',$logins);

    }
}