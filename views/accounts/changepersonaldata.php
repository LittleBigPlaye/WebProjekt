<?php if (isset($errorMessage) && !empty($errorMessage)) : ?>
<input class="messageToggle" type="checkbox" id="errorToggle">
<div class="message errorMessage">
    <label class="messageClose" for="errorToggle">&times</label>
    <p><?= htmlspecialchars($errorMessage) ?></p>
</div>
<?php endif ?>

<?php if (isset($succesMessage) && !empty($succesMessage)) : ?>
<input class="messageToggle" type="checkbox" id="successToggle">
<div class="message successMessage">
    <label class="messageClose" for="successToggle">&times</label>
    <p><?= $successMessage ?></p>
</div>
<?php endif ?>

<div class="formWrapper">
    <form method="post" class="productForm" action="?c=accounts&a=changepersonaldata">
        <h1>Na? Hat sich das Geschlecht geändert?</h1>

        <div class="input">
            <label class="required" for="firstName">Vorname</label>
            <input type="text" id="firstName" name="firstName" maxlength="50" required value="<?= htmlspecialchars($user->firstName) ?>">
            <span class="errorInfo">Bitte geben Sie ihren Vornamen an!</span>
        </div>

        <div class="input">
            <label class="optional" for="secondName">Zweitname</label>
            <input type="text" id="secondName" name="secondName" maxlength="50" value="<?= htmlspecialchars($user->secondName) ?>">
            <span class="errorInfo">Die Eingabe ist zu lang</span>
        </div>

        <div class="input">
            <label class="required" for="lastName">Nachname</label>
            <input type="text" id="lastName" name="lastName" maxlength="50" required value="<?= htmlspecialchars($user->lastName) ?>">
            <span class="errorInfo">Bitte geben Sie ihren realen Nachnamen an!</span>
        </div>

        <div class="input">
            <label class="required" for="birthDate">Geburtstag</label>
            <input id="birthDate" name="birthDate" type="date" required value="<?= $user->birthDate ?>">
            <span class="errorInfo">Nach dem Alter fragt man nicht, jedoch brauchen wir Trotzdem ihr Geburtsdatum von
                Ihnen.</span>
        </div>

        <label class="optional" for="gender">Geschlecht</label>
        <select name="gender">
            <option value="m" <?= ($user->gender === "m") ? 'selected' : '' ?>>männlich</option>
            <option value="f" <?= ($user->gender === "f") ? 'selected' : '' ?>>weiblich</option>
            <option value="u" <?= ($user->gender === "u") ? 'selected' : '' ?>>divers</option>
            <option value="" <?= ($user->gender === "") ? 'selected' : '' ?>>keine Angabe</option>
        </select>

        <label class="optional" for="phone">Telefonnummer</label>
        <input type="text" id="phone" name="phone" maxlength="26" value="<?= htmlspecialchars($user->phone) ?>">

        <input id="submit" type="submit" name="submit" value="Speichern">
    </form>
</div>
<script src="<?= JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'validatePersonas.js' ?>"></script>