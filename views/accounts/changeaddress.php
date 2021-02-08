<?php if (isset($errorMessage) && !empty($errorMessage)) : ?>
<input class="messageToggle" type="checkbox" id="errorToggle">
<div class="message errorMessage">
    <label class="messageClose" for="errorToggle">&times</label>
    <p><?= htmlspecialchars($message) ?></p>
</div>
<?php endif ?>

<?php if (isset($successMessage) && !empty($succesMessage)) : ?>
<input class="messageToggle" type="checkbox" id="successToggle">
<div class="message successMessage">
    <label class="messageClose" for="successToggle">&times</label>
    <p><?= htmlspecialchars($successMessage) ?></p>
</div>
<?php endif ?>

<div class="formWrapper">
    <form method="post" class="productForm" action="?c=accounts&a=changeaddress">
        <h1>Wie ist denn die neue Adresse?</h1>

        <div class="input">
            <label class="required" for="street">Strasse</label>
            <input type="text" id="street" name="street"
                value="<?= htmlspecialchars($_POST['street'] ?? $address->street) ?>">
            <span class="errorInfo">Wir benötigen die Straße in der Sie leben.</span>
        </div>

        <div class="input">
            <label class="required" for="streetNumber">Hausnummer</label>
            <input type="text" id="streetNumber" name="streetNumber"
                value="<?= htmlspecialchars($_POST['streetNumber'] ?? $address->streetNumber) ?>">
            <span class="errorInfo">Ohne Hausnummer kommt die Lieferung nicht an.</span>
        </div>

        <div class="input">
            <label class="required" for="city">Ort</label>
            <input type="text" id="city" name="city" value="<?= htmlspecialchars($_POST['city'] ?? $address->city) ?>">
            <span class="errorInfo">Aus welchen schönen Ort kommen Sie denn?</span>
        </div>

        <div class="input">
            <label class="required" for="zipCode">Postleitzahl</label>
            <input type="text" id="zipCode" name="zipCode" value="<?= htmlspecialchars($address->zipCode) ?>">
            <span class="errorInfo">Es sind nur 5 Zahlen, dennoch sind sie wichtig.</span>
        </div>

        <input id="submit" type="submit" name="submit" value="Speichern">
    </form>
</div>
<script src="<?= JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'validateAddress.js' ?>"></script>