<?php
/**
 * @author John Klippstein
 */
?>

<div class="formWrapper">
    <form class="registerForm"  id="registerForm" action="?c=accounts&a=register" method="post">

        <h1>Registrierung</h1>

        <?php foreach($errorMessages as $key => $message) : ?>
            <input class="messageToggle" type="checkbox" id="errorToggle<?=$key?>">
            <div class="message errorMessage">
                <label class="messageClose" for="errorToggle<?=$key?>">&times</label>
                <p><?= htmlspecialchars($message) ?></p>
            </div>
        <?php endforeach; ?>

        <?php if(isset($successMessage) && !empty($successMessage)) : ?>
            <input class="messageToggle" type="checkbox" id="successToggle">
            <div class="message successMessages">
                <label class="messageClose" for="successToggle">&times</label>
                <p><?= $successMessage ?></p>
            </div>
        <?php endif; ?>


        <h2>Persönliche Daten</h2>

        <div class="input">
            <label class="required" for="firstName"> Vorname:</label>
            <input type="text" id="firstName" name="firstName" placeholder="Vorname" maxlength="50" required value="<?=htmlspecialchars($_POST['firstName'] ?? '')?>">
            <span class="errorInfo">Bitte geben Sie ihren Vornamen an!</span>
        </div>

        <div class="input">
            <label class="optional" for="secondName">Zweitname:</label>
            <input  type="text" id="secondName" name="secondName" placeholder="zweiter Vorname" maxlength="50" value="<?=htmlspecialchars($_POST['secondName'] ?? '')?>">
            <span class="errorInfo">Der Zweitname ist zu lang</span>
        </div>

        <div class="input">
            <label class="required" for="lastName">Nachname:</label>
            <input  type="text" id="lastName" name="lastName" placeholder="Nachname" maxlength="50" required value="<?=htmlspecialchars($_POST['lastName'] ?? '')?>">
            <span class="errorInfo">Bitte geben Sie ihren Nachnamen an!</span>
        </div>

        <div class="input">
            <label class="required" for="email">Email:</label>
            <input  type="email" id="email" name="email" placeholder="E-Mail" maxlength="320" required value="<?=htmlspecialchars($_POST['email'] ?? '')?>">
            <span class="errorInfo">Bitte geben Sie ihre E-Mail an!</span>
        </div>

        <div class="input">
            <label class="required" for="password">Passwort:</label>
            <input  type="password" id="password" name="password" required placeholder="Passwort">
            <span class="errorInfo">Bitte geben Sie ein Passwort ein, mit mindestens 8 Zeichen, davon ein Großbuchstabe, eine Zahl und ein Sonderzeichen.</span>
        </div>

        <div class="input">
            <label class="required" for="password2">Passwort wiederholen:</label>
            <input  type="password" id="password2" name="password2" required placeholder="Passwort wiederholen">
            <span class="errorInfo">Bitte wiederholen Sie ihr Passwort</span>
        </div>


        <label class="optional">Geschlecht:</label>
        <select name="gender">
            <option value="">keine Angabe</option>
            <option value="m">männlich</option>
            <option value="f">weiblich</option>
            <option value="u">divers</option>
        </select>


        <div class="input">
            <label class="required">Geburtstag:</label>
            <input  type="date" id="birthdate" name="birthdate" placeholder="Geburtstag" required value="<?=htmlspecialchars($_POST['birthdate'] ?? '')?>">
            <span class="errorInfo">Nach dem Alter fragt man nicht, jedoch brauchen wir Trotzdem ihr Geburtsdatum von Ihnen.</span>
        </div>

        <br>
        <hr>


        <h2>Adresse</h2>

        <div class="input">
            <label class="required" for="street">Strasse</label>
            <input type="text" id="street" name="street" placeholder="Strasse" maxlength="255"  required value="<?=htmlspecialchars($_POST['street'] ?? '')?>">
            <span class="errorInfo">Wir benötigen die Straße in der Sie leben.</span>
        </div>

        <div class="input">
            <label class="required" for="streetNumber">Hausnummer</label>
            <input type="text" id="streetNumber" name="streetNumber" placeholder="Hausnummer" maxlength="10" required value="<?=htmlspecialchars($_POST['streetNumber'] ?? '')?>">
            <span class="errorInfo">Ohne Hausnummer kommt die Lieferung nicht an.</span>
        </div>

        <div class="input">
            <label class="required" for="zipCode">Postleitzahl</label>
            <input type="text" id="zipCode" name="zipCode" placeholder="Postleitzahl" maxlength="5" minlength="5" required value="<?=htmlspecialchars($_POST['zipCode'] ?? '')?>">
            <span class="errorInfo">Es sind nur 5 Zahlen, dennoch sind sie wichtig.</span>
        </div>

        <div class="input">
            <label class="required" for="city">Stadt</label>
            <input type="text" id="city" name="city" placeholder="Stadt" maxlength="60" required value="<?=htmlspecialchars($_POST['city'] ?? '')?>">
            <span class="errorInfo">Aus welchen schönen Ort kommen Sie denn?</span>
        </div>

        <br>
        <input type="submit" value="Registrieren" id="submitForm" name="submitForm" >
    </form>
</div>
<script src="<?=JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'validateRegister.js'?>"></script>
<script src="<?=JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'validateAddress.js'?>"></script>
<script src="<?=JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'validatePassword.js'?>"></script>