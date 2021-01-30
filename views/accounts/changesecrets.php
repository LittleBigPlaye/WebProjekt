<?php if(isset($errorMessage) && !empty($errorMessage)) : ?>
    <div class="errorMessage">
        <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
        <p><?= $errorMessage ?></p>
    </div>
<?php endif ?>
<?php if(isset($successMessage) && !empty($successMessage)) : ?>
    <div class="successMessage">
        <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
        <p><?= $successMessage ?></p>
    </div>
<?php endif ?>

<div class="formWrapper">
    <form method="post" class="productForm" action="?c=accounts&a=changesecrets">
        <h1>Passwort ändern</h1>

        <div class="input">
            <label for="newPassword1">Neues Passwort eingeben</label>
            <input id="password" name="password" type="password" placeholder="Neues Passwort">
            <span class="errorInfo">Bitte geben Sie ein Passwort ein, mit mindestens 8 Zeichen, davon ein Großbuchstabe, eine Zahl und ein Sonderzeichen.</span>
        </div>
        <br>
        <div class="input">
            <label for="newPassword2">Neues Passwort wiederholen</label>
            <input id="password2" name="password2" type="password" placeholder="Neues Passwort wiederholen">
            <span class="errorInfo">Bitte wiederholen Sie ihr Passwort</span>
        </div>
        <input id="submit" type="submit" name="changePassword" value="Speichern">
    </form>
</div>
<script src="<?=JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'validatePassword.js'?>"></script>