<div class="formWrapper">
    <form class="loginForm" action="index.php?c=pages&a=login" method="post">
        <h1>Login</h1>
        <?php foreach($errorMessages as $key => $message) : ?>
            <input class="messageToggle" type="checkbox" id="errorToggle<?=$key?>">
            <div class="message errorMessage">
                <label class="messageClose" for="errorToggle<?=$key?>">&times</label>
                <p><?= htmlspecialchars($message) ?></p>
            </div>
        <?php endforeach; ?>
        <div class="input"><label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            <span class="errorInfo">Bitte geben Sie eine korrekte E-Mail an!</span>
        </div>
        <div class="input">
        <label for="password">Passwort:</label>
        <input type="password" id="password" name="password">
        <span class="errorInfo">Bitte geben Sie ein korrektes Passwort an!</span>
        </div>

        <input type="submit" name="submit" id="submit" value="Anmelden"/>
        <p>Sie haben noch keinen Account? <br><a href="index.php?c=accounts&a=register">Hier registrieren!</a></p>
    </form>
</div>
<script src="<?=JAVASCRIPTPATH . 'pages' . DIRECTORY_SEPARATOR . 'validateLogin.js'?>"></script>