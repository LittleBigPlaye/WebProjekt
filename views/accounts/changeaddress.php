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
    <form method="post" class="productForm" action="?c=accounts&a=changeaddress">
        <h1>Wie ist denn die neue Adresse?</h1>
        <label for="street">Straße</label>
        <input id="street" name="street" value="<?=htmlspecialchars($address->street)?>">
        <br>
        <label for="streetNumber">Hausnummer</label>
        <input id="streetNumber" name="streetNumber" value="<?=htmlspecialchars($address->streetNumber)?>">
        <br>
        <label for="city">Ort</label>
        <input id="city" name="city" value="<?=htmlspecialchars($address->city)?>">
        <br>
        <label for="zipCode">Postleitzahl</label>
        <input id="zipCode" name="zipCode" value="<?=htmlspecialchars($address->zipCode)?>">

        <button class="buttonForAll" type="submit" name="changeAddress">Speichern</button>
    </form>
</div>