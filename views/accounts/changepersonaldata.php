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

        <div class="input">
            <label class="required" for="firstName">Vorname</label>
            <input type="text" id="firstName" name="firstName" value="<?=htmlspecialchars($user->firstName)?>" >
            <span class="errorInfo">Bitte geben Sie ihren Vornamen an!</span>
        </div>
        <br>

        <div class="input">
            <label class="optional" for="secondName">Zweitname</label>
            <input type="text" id="secondName" name="secondName" value="<?=htmlspecialchars($user->secondName)?>">

        </div>
        <br>

        <div class="input">
            <label class="required" for="lastName">Nachname</label>
            <input type="text" id="lastName" name="lastName" value="<?=htmlspecialchars($user->lastName)?>">
            <span class="errorInfo">Bitte geben Sie ihren Nachnamen an!</span>
        </div>
        <br>

        <div class="input">
            <label class="required" for="birthDate">Geburtstag</label>
            <input id="birthDate" name="birthDate" type="date" value="<?=$user->birthDate?>">
            <span class="errorInfo">Nach dem Alter fragt man nicht, jedoch brauchen wir Trotzdem ihr Geburtsdatum von Ihnen.</span>
        </div>
        <br>


        <label class="optional" for="gender">Geschlecht</label>
        <select name="gender">
            <option value="m"
                <?= ($user->gender === "m") ? 'selected' : '' ?>
            >männlich</option>
            <option value="f"
                <?= ($user->gender === "f") ? 'selected' : '' ?>
            >weiblich</option>
            <option value="u"
                <?= ($user->gender === "u") ? 'selected' : '' ?>
            >divers</option>
        </select>
        <br>
        <br>
        <label class="optional" for="phone">Telefonnummer</label>
        <input type="text" id="phone" name="phone" value="<?=htmlspecialchars($user->phone)?>">
        <br>
        <input id="submit" type="submit" name="submit" value="Speichern">
    </form>
</div>
<script src="<?=JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'validatePersonas.js'?>"></script>