<?php if (isset($errorMessage) && !empty($errorMessage)) : ?>
<input class="messageToggle" type="checkbox" id="errorToggle">
<div class="message errorMessage">
    <label class="messageClose" for="errorToggle">&times</label>
    <p><?= htmlspecialchars($errorMessage) ?></p>
</div>
<?php endif ?>

<?php if (isset($successMessage) && !empty($successMessage)) : ?>
<input class="messageToggle" type="checkbox" id="successToggle">
<div class="message successMessage">
    <label class="messageClose" for="successToggle">&times</label>
    <p><?= $successMessage ?></p>
</div>
<?php endif ?>

<div class="formWrapper">
    <form method="post" class="productForm" action="?c=accounts&a=changesecrets">
        <h1>Passwort ändern</h1>

        <div class="input">
            <label for="newPassword1">Neues Passwort eingeben</label>
            <input id="password" name="password" type="password" required placeholder="Neues Passwort">
            <span class="errorInfo">Bitte geben Sie ein Passwort ein, mit mindestens 8 Zeichen, davon ein Großbuchstabe,
                eine Zahl und ein Sonderzeichen.</span>
        </div>
        <div class="input">
            <label for="newPassword2">Neues Passwort wiederholen</label>
            <input id="password2" name="password2" type="password" required placeholder="Neues Passwort wiederholen">
            <span class="errorInfo">Bitte wiederholen Sie ihr Passwort</span>
        </div>
        <input id="submit" type="submit" name="changePassword" value="Speichern">
    </form>
</div>
<script src="<?= JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'validatePassword.js' ?>"></script>