<?php if(isset($errorMessage) && !empty($errorMessage)) : ?>
    <div class="errorMessage">
        <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
        <p><?= $errorMessage ?></p>
    </div>
<?php endif ?>
<?php if(isset($succesMessage) && !empty($succesMessage)) : ?>
    <div class="successMessage">
        <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
        <p><?= $succesMessage ?></p>
    </div>
<?php endif ?>

<div class="formWrapper">
    <form method="post" class="productForm" action="?c=accounts&a=changepersonaldata">
        <h1>Na? Hat sich das Geschlecht geändert?</h1>
        <label for="firstName">Vorname</label>
        <input id="firstName" name="firstName" value="<?=htmlspecialchars($user->firstName)?>" >
        <br>
        <label for="secondName">Zweitname</label>
        <input id="secondName" name="secondName" value="<?=htmlspecialchars($user->secondName)?>">
        <br>
        <label for="lastName">Nachname</label>
        <input id="lastName" name="lastName" value="<?=htmlspecialchars($user->lastName)?>">
        <br>
        <label for="birthDate">Geburtstag</label>
        <input id="birthDate" name="birthDate" type="date" value="<?=$user->birthDate?>">
        <br>
        <label for="gender">Geschlecht</label>
        <input type="radio" id="female" value="f" name="gender"><label for="female" class="light">Frau</label><br>
        <input type="radio" id="male" value="m" name="gender"><label for="male" class="light">Mann</label><br>
        <input type="radio" id="divers" value="u" name="gender"><label for="divers" class="light">Irgendwas anderes</label>
        <br>
        <br>
        <label for="phone">Telefonnummer</label>
        <input id="phone" name="phone" value="<?=htmlspecialchars($user->phone)?>">
        <br>
        <button class="buttonForAll" type="submit" name="changePersona">Speichern</button>
    </form>
</div>
<? include (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'upButton.php') ?>