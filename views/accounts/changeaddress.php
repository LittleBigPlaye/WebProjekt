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

        <div class="input">
            <label class="required" for="street">Strasse</label>
            <input class="input_register1" id="street" name="street" value="<?=htmlspecialchars($address->street)?>">
            <span class="errorInfo">Wir benötigen die Straße in der Sie leben.</span>
        </div>
        <br>

        <div class="input">
            <label class="required" for="streetNumber">Hausnummer</label>
            <input class="input_register1" id="streetNumber" name="streetNumber" value="<?=htmlspecialchars($address->streetNumber)?>">
            <span class="errorInfo">Ohne Hausnummer kommt die Lieferung nicht an.</span>
        </div>
        <br>

        <div class="input">
            <label class="required" for="city">Ort</label>
            <input class="input_register1" id="city" name="city" value="<?=htmlspecialchars($address->city)?>">
            <span class="errorInfo">Aus welchen schönen Ort kommen Sie denn?</span>
        </div>
        <br>

        <div class="input">
            <label class="required" for="zipCode">Postleitzahl</label>
            <input class="input_register1" id="zipCode" name="zipCode" value="<?=htmlspecialchars($address->zipCode)?>">
            <span class="errorInfo">Es sind nur 5 Zahlen, dennoch sind sie wichtig.</span>
        </div>

        <input id="submit" type="submit" name="submit" value="Speichern">
    </form>
</div>
<script src="<?=JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'validateAddress.js'?>"></script>