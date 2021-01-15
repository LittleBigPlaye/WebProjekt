<?php
/**
 * @author John Klippstein
 */

namespace myf\controller;


use myf\models\Address;
use myf\models\Order;
use myf\models\OrderItem;
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
            $password       = $_POST['password']  ?? "";
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
                if(preg_match('/[A-Za-z\d$!^(){}?\[\]<>~%@#&*+=_-]{8,40}$/', $password))
                {
                    $savePassword=password_hash($password,PASSWORD_DEFAULT);
                    if(!password_verify($password2,$savePassword)){
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
                else
                {
                    $errorMessage = 'Das Passwort entspricht nicht den Anforderungen. Mindestens 8 Zeichen, Groß-, Kleinbuchstaben, Ziffern und Sonderzeichen';
                }

            }


        }


        $this->setParam('errorMessage', $errorMessage);
    }

    public function actionAdminusermanagement()
    {
        if($this->isAdmin())
        {
            if(isset($_POST['saveChanges']))
            {
                $enabled =$_POST['enabled']; //select
                $validated = $_POST['validated']; //select
                $passwordReset = isset($_POST['passwordReset']); //checkbox
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
        else
        {
            header('location: index.php?c=pages&a=login');
        }



    }

    public function actionMySpace ()
    {
        $errormsg = '';

        $myOwnID = $_SESSION['userID'];

        if($myOwnID != '')
        {
            $userData = User::findOne('id='.$myOwnID);
            $addressData = Address::findOne('id='.$userData->addressID);
            $this->setParam('user',$userData);
            $this->setParam('address',$addressData);

            $loginData = Login::findOne('userID='.$myOwnID);
            $orderData = Order::find('loginID='.$loginData->id);


            $this->setParam('orders',$orderData);

        }
        else
        {
            header('location: index.php?c=pages&a=login');
        }
    }

    public function actionChangeSecrets()
    {
        $errorMessage = "";

        $userID = $_SESSION['userID'];

        if(isset($_POST['changePassword']))
        {
            $newPassword1 = $_POST['newPassword1'] ?? "";
            $newPassword2 = $_POST['newPassword2'] ?? "";

            if (preg_match('/[A-Za-z\d$!^(){}?\[\]<>~%@#&*+=_-]{8,40}$/', $newPassword1))
            {
                $savePassword=password_hash($newPassword1,PASSWORD_DEFAULT);
                if(password_verify($newPassword2,$savePassword))
                {
                    $updateLogin=Login::findOne('userID='.$userID);

                    $updateLogin->passwordHash = $savePassword;

                    /*echo '<pre>';
                    var_dump($newPassword1);
                    echo '</pre>';*/
                   $updateLogin->save();
                    $succesMessage = "Das war super!";
                }
                else
                {
                    $errorMessage = 'Die Passwörter stimmen nicht überein';
                }
            }
            else
            {
                $errorMessage = 'Das Passwort entspricht nicht den Anforderungen. Mindestens 8 Zeichen, Groß-, Kleinbuchstaben, Ziffern und Sonderzeichen';
            }
        }




        $this->setParam('errorMessage', $errorMessage);
        $this->setParam('succesMessage', $succesMessage);
    }

    public function actionChangePersonalData()
    {
        $errorMessage = '';
        $succesMessage = '';

        $userID = $_SESSION['userID'];

        $firstName = $_POST['firstName'] ?? '';
        $secondName = $_POST['secondName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $birthDate = $_POST['birthDate'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $phone = $_POST['phone'] ?? '';

        $userData = User::findOne('id='.$userID);

        $this->setParam('user',$userData);

        if(isset($_POST['changePersona']))
        {
            if(empty($firstName) || empty($lastName) || empty($birthDate) )
            {

                $errorMessage = 'Nicht alle nötigen Felder sind ausgefüllt';

            }
            else
            {

                $userData->firstName = $firstName;
                $userData->secondName = $secondName;
                $userData->lastName = $lastName;
                $userData->birthDate = $birthDate;
                $userData->gender = $gender;
                $userData->phone = $phone;

                $userData->save();
                $succesMessage = "Änderungen sind gespeichert!";
            }
        }

        $this->setParam('errorMessage', $errorMessage);
        $this->setParam('succesMessage', $succesMessage);

    }

    public function actionChangeAddress()
    {
        $errorMessage = '';
        $succesMessage = '';

        $db = $GLOBALS['database'];

        $userID = $_SESSION['userID'];

        $street = $_POST['street'] ?? '';
        $streetNumber = $_POST['streetNumber'] ?? '';
        $city = $_POST['city'] ?? '';
        $zipCode = $_POST['zipCode'] ?? '';

        $userData=User::findOne('id='.$userID);
        $addressAtStart=$userData->addresses;
        $this->setParam('address',$addressAtStart);
        
        if(isset($_POST['changeAddress'])){

            if(empty($street) || empty($streetNumber) || empty($city) || empty($zipCode) ) {
                $errorMessage = 'Nicht alle nötigen Felder sind ausgefüllt';
            }
            else{
                
                $address = Address::findOne("street=".$db->quote($street)." AND streetnumber=".$db->quote($streetNumber).
                    " AND city=".$db->quote($city)." AND zipCode=".$db->quote($zipCode));

                if($address !== null)
                {
                    $adressID = $address->id;
                    $succesMessage = 'Keine Änderungen nötig';
                    
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
                    
                    
                    $userData->addressID = $adressID;
                    $userData->save();
                    $this->setParam('address',$adress);
                    $succesMessage = 'Änderungen erfolgreich gespeichert';
                }
            }
            
            
        }
        

        $this->setParam('errorMessage', $errorMessage);
        $this->setParam('succesMessage', $succesMessage);
    }

}