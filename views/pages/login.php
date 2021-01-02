<div class="formWrapper">
  <form class="loginForm" action="index.php?c=pages&a=login" method="post">
    <h1>Login</h1>
    <label for="mail">Email:</label>
    <input type="email" id="mail" name="user_email">

    <label for="password">Passwort:</label>
    <input type="password" id="password" name="user_password">

    <input type="submit" name="submit" value="Anmelden"/>
    <p>Sie haben noch keinen Account? <br><a href="index.php?c=pages&a=register">Hier registrieren!</a></p>
  </form>
</div>