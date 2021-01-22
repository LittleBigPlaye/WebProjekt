<?php
/**
 * @author John Klippstein
 */
?>

<div class="formWrapper">
    <form class="formWrapperRegister"  action="?c=accounts&a=register" method="post">

        <h1>Registrierung</h1>

        <?php foreach($errorMessages as $message) : ?>
            <div class="errorMessage">
                <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
                <?= $message ?>
            </div>
        <?php endforeach; ?>

        <?php if(isset($succesMessage) && !empty($succesMessage)) : ?>
            <div class="successMessage">
                <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
                <p><?= $succesMessage ?></p>
            </div>
        <?php endif; ?>


        <h2>Persönliche Daten</h2>

        <div class="input">
            <label class="required" for="firstName"> Vorname:</label>
            <input class="input_register1" type="text" id="firstName" name="firstName" placeholder="Vorname" value="<?=htmlspecialchars($_POST['firstName'] ?? '')?>">
            <span class="errorInfo">Bitte geben Sie ihren Vornamen an!</span>
        </div>


            <label class="optional" for="secondName">Zweitname:</label>
            <input class="input_register1" type="text" id="secondName" name="secondName" placeholder="zweiter Vorname" value="<?=htmlspecialchars($_POST['secondName'] ?? '')?>">


        <div class="input">
            <label class="required" for="lastName">Nachname:</label>
            <input class="input_register1" type="text" id="lastName" name="lastName" placeholder="Nachname" value="<?=htmlspecialchars($_POST['lastName'] ?? '')?>">
            <span class="errorInfo">Bitte geben Sie ihren Nachnamen an!</span>
        </div>

        <div class="input">
            <label class="required" for="email">Email:</label>
            <input class="input_register1" type="email" id="email" name="email" placeholder="E-Mail" value="<?=htmlspecialchars($_POST['email'] ?? '')?>">
            <span class="errorInfo">Bitte geben Sie ihre E-Mail an!</span>
        </div>

        <div class="input">
            <label class="required" for="password">Passwort:</label>
            <input class="input_register1" type="password" id="password" name="password" placeholder="Passwort">
            <span class="errorInfo">Bitte geben Sie ein Passwort ein, mit mindestens 8 Zeichen, davon ein Großbuchstabe, eine Zahl und ein Sonderzeichen.</span>
        </div>

        <div class="input">
            <label class="required" for="password2">Passwort wiederholen:</label>
            <input class="input_register1" type="password" id="password2" name="password2" placeholder="Passwort wiederholen">
            <span class="errorInfo">Bitte wiederholen Sie ihr Passwort</span>
        </div>


        <label class="optional">Geschlecht:</label>
        <input type="radio" id="female" value="f" name="gender"><label for="female" class="light">Frau</label><br>
        <input type="radio" id="male" value="m" name="gender"><label for="male" class="light">Mann</label><br>
        <input type="radio" id="divers" value="u" name="gender"><label for="divers" class="light">Das was ich sein möchte</label><br><br>

        <div class="input">
            <label class="required">Geburtstag:</label>
            <input class="input_register1" type="date" id="birthdate" name="birthdate" placeholder="Geburtstag" value="<?=htmlspecialchars($_POST['birthdate'] ?? '')?>">
            <span class="errorInfo">Nach dem Alter fragt man nicht, jedoch brauchen wir Trotzdem ihr Geburtsdatum von Ihnen.</span>
        </div>

        <br>
        <hr>


        <h2>Adresse</h2>

        <div class="input">
            <label class="required" for="street">Strasse</label>
            <input class="input_register1" type="text" id="street" name="street" placeholder="Strasse" value="<?=htmlspecialchars($_POST['street'] ?? '')?>">
            <span class="errorInfo">Wir benötigen die Straße in der Sie leben.</span>
        </div>

        <div class="input">
            <label class="required" for="streetNumber">Hausnummer</label>
            <input class="input_register1" type="text" id="streetNumber" name="streetNumber" placeholder="Hausnummer" value="<?=htmlspecialchars($_POST['streetNumber'] ?? '')?>">
            <span class="errorInfo">Ohne Hausnummer kommt die Lieferung nicht an.</span>
        </div>

        <div class="input">
            <label class="required" for="zipCode">Postleitzahl</label>
            <input class="input_register1" type="text" id="zipCode" name="zipCode" placeholder="Postleitzahl" value="<?=htmlspecialchars($_POST['zipCode'] ?? '')?>">
            <span class="errorInfo">Es sind nur 5 Zahlen, dennoch sind sie wichtig.</span>
        </div>

        <div class="input">
            <label class="required" for="city">Stadt</label>
            <input class="input_register1" type="text" id="city" name="city" placeholder="Stadt" value="<?=htmlspecialchars($_POST['city'] ?? '')?>">
            <span class="errorInfo">Aus welchen schönen Ort kommen Sie denn?</span>
        </div>

        <br>
        <input type="submit" value="Registrieren" id="submit" name="submit" >
    </form>
</div>
<script src="<?=JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'validateRegister.js'?>"></script>
<script src="<?=JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'validateAddress.js'?>"></script>
<script src="<?=JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'validatePassword.js'?>"></script>