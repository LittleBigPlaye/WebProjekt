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
        <h1>Wie ist denn die neue Adresse?</h1>
        <label for="Street">Straße</label>
        <input id="Street" name="Street" >
        <br>
        <label for="Hausnummer">Hausnummer</label>
        <input id="Hausnummer" name="Hausnummer">
        <br>
        <label for="Ort">Ort</label>
        <input id="Ort" name="Ort">
        <br>
        <label for="Postleitzahl">Postleitzahl</label>
        <input id="Postleitzahl" name="Postleitzahl">

        <button class="buttonForAll" type="submit" name="changeAddress">Speichern</button>
    </form>
</div>
<? include (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'upButton.php') ?>