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

        /**
         * In this function we manage the registration
         */

        $errorMessages = [];
        $successMessage = '';


        // the following "if" check if the the submit was send
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

            /**
             * the following "if´s" if one the variables are empty or not. If one of the fields are empty, it will send an error
             */

            //Check firstName
            if(empty($firstName))
            {
                $errorMessages['firstName'] = 'Es muss ein Vorname angegeben werden.';
            }

            //check lastName
            if(empty($lastName))
            {
                $errorMessages['lastName'] = 'Es muss ein Nachname angegeben werden.';
            }

            //check email
            if(empty($email))
            {
                $errorMessages['email'] = 'Es muss eine EMail angegeben werden.';
            }

            //check password
            if(empty($password))
            {
                $errorMessages['password'] = 'Es muss ein Passwort angegeben werden.';
            }

            //check password2
            if(empty($password2))
            {
                $errorMessages['password2'] = 'Das Passwort muss wiederholt werden';
            }

            //check birthdate
            if(empty($birthdate))
            {
                $errorMessages['birthDate'] = 'Es muss das Geburtsdatum angegeben werden.';
            }

            //check if password match the regex
            if(preg_match('/^(?=.*?[A-Z])(?=.*?[a-z].*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/m', $password))
            {
                $savePassword=password_hash($password,PASSWORD_DEFAULT);

                //check if password and password2 the same
                if(!password_verify($password2,$savePassword)){
                    $errorMessages['ComparePassword'] = "Schau mal Passwort";
                }
            }
            else
            {
                $errorMessages['PasswordRegex'] = 'Das Passwort entspricht nicht den Anforderungen. Mindestens 8 Zeichen, Groß-, Kleinbuchstaben, Ziffern und Sonderzeichen!';
            }

            //validate Email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $errorMessages['EmailValidation'] = "Ungültige Eingabe der Email";
            }

            //check if user exists
            if(Login::findOne('email LIKE'.$db->quote($email)) !== null)
            {
                $errorMessages['User'] = "Der Benutzer existiert bereits.";
            }

            //check street
            if(empty($street))
            {
                $errorMessages['street'] = 'Es muss eine Strasse angegeben werden';
            }

            //check streetNumber
            if(empty($streetNumber))
            {
                $errorMessages['streetNumber'] = 'Es muss eine Hausnummer angegeben werden';
            }

            //check zipCode
            if(empty($zipCode))
            {
                $errorMessages['zipCode'] = 'Es muss eine Postleitzahl angegeben werden';
            }

            //check city
            if(empty($city))
            {
                $errorMessages['city'] = 'Es muss eine Stadt angegeben werden';
            }

            //check if no errors exist
            if(count($errorMessages) === 0)
            {
                //get an address with the dates frim the post
                $address = Address::findOne("street=".$db->quote($street)." AND streetnumber=".$db->quote($streetNumber).
                    " AND city=".$db->quote($city)." AND zipCode=".$db->quote($zipCode));

                //check if the address is null
                if($address !== null)
                {
                    // if address is not null, address still exists and get the id from existing address
                    $adressID = $address->id;
                }
                else
                {
                    //if address is null we create a new one. for this we save the data in an array
                    $adressData=array(
                        'street'=> $street,
                        'streetNumber' => $streetNumber,
                        'city' => $city,
                        'zipCode' => $zipCode);

                    //create new address and save
                    $adress = new Address($adressData);
                    $adress->save();
                    $adressID = $adress->id;
                }

                //set array for new user
                $userData = array(
                    'firstName' => $firstName,
                    'secondName' => $secondName,
                    'lastName' => $lastName,
                    'gender' => $gender,
                    'birthDate' => $birthdate,
                    'addressID' => $adressID);

                //create new user and save
                $user = new User($userData);
                $user->save();
                $user->id;

                //at this status of complitation of the website, enabled and validated will set on true
                //failedLoginCount is 0
                $validated = true;
                $enabled   = true;
                $failedLoginCount = 0;

                //set array for the new login
                $loginData = array(
                    'validated' => $validated,
                    'enabled' => $enabled,
                    'email' => $email,
                    'failedLoginCount' => $failedLoginCount,
                    'passwordHash' => $savePassword,
                    'userID' => $user->id);

                //create new login and save
                $login = new Login($loginData);
                $login->save();

                $successMessage = 'Der neue Nutzer wurde angelegt';
            }
        }
        $this->setParam('errorMessages', $errorMessages);
        $this->setParam('succesMessage', $successMessage);
    }

    public function actionAdminusermanagement()
    {

        /**
         * In this function we managed the administration of the users
         */

        // check if the user have the role admin
        if($this->isAdmin())
        {
            // the following "if" check if the the submit was send
            if(isset($_POST['saveChanges']))
            {
                $enabled =$_POST['enabled']; //select
                $validated = $_POST['validated']; //select
                $passwordReset = isset($_POST['passwordReset']); //checkbox
                $loginID = $_POST['user'];
                $userRole = $_POST['role'];

                //get the login from a special user
                $loginUpdate = Login::findOne('userID='.$loginID);

                //set enabled or disabled
                if($enabled === '1')
                {
                    $loginUpdate->enabled = 1;
                }
                else
                {
                    $loginUpdate->enabled = 0;
                }

                //set validation
                if($validated === '1')
                {
                    $loginUpdate->validated = 1;
                }
                else
                {
                    $loginUpdate->validated = 0;
                }

                //reset password the default value
                if($passwordReset === true)
                {
                    $loginUpdate->passwordResetHash = password_hash('P@ssw0rd01', PASSWORD_DEFAULT);
                }

                //set the role
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

            //get all users with login
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
        /**
         * with this function we managed the view "mySpace"
         */

        //check if there are any success messages in the session
        if(isset($_SESSION['success']))
        {
            $successMessage = $_SESSION['success'];
            unset($_SESSION['success']);
            $this->setParam('successMessage', $successMessage);
        }

        //get own userid from the session
        $myOwnID = $_SESSION['userID'];

        //check if own userid is null
        if($myOwnID != '')
        {
            //get own data
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
            //if own userid is null, the user will redirect to the login
            header('location: index.php?c=pages&a=login');
        }
    }

    public function actionChangeSecrets()
    {
        /**
         * with this function we manage the passwordchange
         */

        $errorMessage = "";

        $userID = $_SESSION['userID'];

        // the following "if" check if the the submit was send
        if(isset($_POST['changePassword']))
        {
            $newPassword1 = $_POST['password'] ?? "";
            $newPassword2 = $_POST['password2'] ?? "";

            //check if the password match the regex
            if (preg_match('/^(?=.*?[A-Z])(?=.*?[a-z].*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/m', $newPassword1))
            {
                $savePassword=password_hash($newPassword1,PASSWORD_DEFAULT);
                //compare password with password2
                if(password_verify($newPassword2,$savePassword))
                {
                    //set new password and save
                    $updateLogin=Login::findOne('userID='.$userID);
                    $updateLogin->passwordHash = $savePassword;
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
                $errorMessage = 'Das Passwort entspricht nicht den Anforderungen. Mindestens 8 Zeichen, Groß-, Kleinbuchstaben, 2 Ziffern und 2 Sonderzeichen';
            }
        }

        $this->setParam('errorMessage', $errorMessage);
        $this->setParam('succesMessage', $succesMessage);
    }

    public function actionChangePersonalData()
    {
        /**
         * with this function we will manage the change of personal data
         */

        $errorMessage = '';
        $succesMessage = '';

        //get necessary data´s
        $userID = $_SESSION['userID'];

        $firstName = $_POST['firstName'] ?? '';
        $secondName = $_POST['secondName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $birthDate = $_POST['birthDate'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $phone = $_POST['phone'] ?? '';

        $userData = User::findOne('id='.$userID);

        $this->setParam('user',$userData);

        //check if submit was send
        if(isset($_POST['submit']))
        {

            //proof if all important fields are not empty
            if(empty($firstName) || empty($lastName) || empty($birthDate) )
            {
                $errorMessage = 'Nicht alle nötigen Felder sind ausgefüllt';
            }
            else
            {

                //set data´s for the user and save them
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

        /**
         * with this function we manage the change of the address
         */
        $errorMessage = '';
        $succesMessage = '';

        $db = $GLOBALS['database'];

        $userID = $_SESSION['userID'];

        //get all paramaters
        $street = $_POST['street'] ?? '';
        $streetNumber = $_POST['streetNumber'] ?? '';
        $city = $_POST['city'] ?? '';
        $zipCode = $_POST['zipCode'] ?? '';

        //get the user
        $userData=User::findOne('id='.$userID);
        $addressAtStart=$userData->addresses;
        $this->setParam('address',$addressAtStart);

        //check if submit was send
        if(isset($_POST['submit']))
        {

            //proof if all important fields are not empty
            if(empty($street) || empty($streetNumber) || empty($city) || empty($zipCode))
            {
                $errorMessage = 'Nicht alle nötigen Felder sind ausgefüllt';
            }
            else{
                //check if the address still exists
                $address = Address::findOne("street=".$db->quote($street)." AND streetnumber=".$db->quote($streetNumber).
                    " AND city=".$db->quote($city)." AND zipCode=".$db->quote($zipCode));
                if($address !== null)
                {
                    $adressID = $address->id;
                    $succesMessage = 'Keine Änderungen nötig';
                }
                else
                {
                    //set array for the address
                    $adressData=array(
                        'street'=> $street,
                        'streetNumber' => $streetNumber,
                        'city' => $city,
                        'zipCode' => $zipCode);

                    //create new address and save
                    $adress = new Address($adressData);
                    $adress->save();
                    $adressID = $adress->id;

                    //set address and save
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

    public function actionWaitingArea(){
        /**
         * no functions are needed at this moment
         */
    }

}