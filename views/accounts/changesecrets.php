<?php if(isset($errorMessage) && !empty($errorMessage)) : ?>
    <div class="errorMessage">
        <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
        <p><?= $errorMessage ?></p>
    </div>
<?php endif ?>
<?php if(isset($succesMessage) && !empty($succesMessage)) : ?>
    <div class="errorMessage">
        <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
        <p><?= $succesMessage ?></p>
    </div>
<?php endif ?>

<div class="formWrapper">
    <form method="post" class="productForm" action="?c=accounts&a=changesecrets">
        <h1>Passwort ändern</h1>
        <label for="newPassword1">Neues Passwort eingeben</label>
        <input id="newPassword1" name="newPassword1" placeholder="Neues Passwort">
        <br>
        <label for="newPassword2">Neues Passwort wiederholen</label>
        <input id="newPassword2" name="newPassword2" placeholder="Neues Passwort wiederholen">

        <button class="buttonForAll" type="submit" name="changePaddword">Speichern</button>
    </form>
</div>
<? include (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'upButton.php') ?>