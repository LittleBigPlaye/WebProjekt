

<div class="formWrapper">
    <form method="post" class="productForm" action="?c=accounts&a=changeaddress">
        <h1>Adresse ändern</h1>

        <?php if (isset($errorMessage) && !empty($errorMessage)) : ?>
            <input class="messageToggle" type="checkbox" id="errorToggle">
            <div class="message errorMessage">
                <label class="messageClose" for="errorToggle">&times</label>
                <p><?= htmlspecialchars($errorMessage) ?></p>
            </div>
        <?php endif ?>

        <div class="input">
            <label class="required" for="street">Strasse</label>
            <input type="text" id="street" name="street" maxlength="255" required
                value="<?= htmlspecialchars($_POST['street'] ?? $address->street) ?>">
            <span class="errorInfo">Wir benötigen die reale Straße in der Sie leben.</span>
        </div>

        <div class="input">
            <label class="required" for="streetNumber">Hausnummer</label>
            <input type="text" id="streetNumber" name="streetNumber" maxlength="10" required
                value="<?= htmlspecialchars($_POST['streetNumber'] ?? $address->streetNumber) ?>">
            <span class="errorInfo">Ohne oder mit falscher Hausnummer kommt die Lieferung nicht an.</span>
        </div>

        <div class="input">
            <label class="required" for="city">Ort</label>
            <input type="text" id="city" name="city" maxlength="60" required value="<?= htmlspecialchars($_POST['city'] ?? $address->city) ?>">
            <span class="errorInfo">Aus welchen schönen und existierenden Ort kommen Sie denn?</span>
        </div>

        <div class="input">
            <label class="required" for="zipCode">Postleitzahl</label>
            <input type="text" id="zipCode" name="zipCode" maxlength="5" minlength="5" required value="<?= htmlspecialchars($address->zipCode) ?>">
            <span class="errorInfo">Es sind nur 5 Zahlen, dennoch sind sie wichtig.</span>
        </div>

        <input id="submit" type="submit" name="submit" value="Speichern">
    </form>
</div>
<script src="<?= JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'validateAddress.js' ?>"></script>