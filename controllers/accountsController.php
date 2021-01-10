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

        if(isset($_POST['saveChanges']))
        {
            $enabled =$_POST['enabled']; //select
            $validated = $_POST['validated']; //select
            $passwordReset = isset($_POST['validated']); //checkbox
            $loginID = $_POST['user'];
            $userRole = $_POST['role'];

            $loginUpdate = Login::findOne('userID='.$loginID);

            if($enabled === '1')
            {
                $loginUpdate->enabled = 1;
            }
            else
            {
                $loginUpdate->enabled = 0;
            }

            if($validated === '1')
            {
                $loginUpdate->validated = 1;
            }
            else
            {
                $loginUpdate->validated = 0;
            }

            if($passwordReset === true)
            {
                $loginUpdate->passwordResetHash = password_hash('P@ssw0rd01', PASSWORD_DEFAULT);
            }

            if($userRole === 'admin')
            {
                $loginUpdate->user->role = 'admin';
            }
            else
            {
                $loginUpdate->user->role = 'user';
            }

            $loginUpdate->save();
            $loginUpdate->user->save();

        }

            $users = User::find();
            $logins = Login::find();

            $this->setParam('users',$users);
            $this->setParam('logins',$logins);

    }


}