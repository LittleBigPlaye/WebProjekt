<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up Form</title>
    </head>
    <body>
        <div class="containerlogin">
          <form class="cardlogin"  action="index.html" method="post">

            <h1>Login</h1>
              <br>

                <div class="loginlabelinput">
              <label for="mail">Email:</label>

                <br>
              <input class="input_login" type="email" id="mail" name="user_email">
                </div>
                <br>
              <div class="loginlabelinput">
              <label for="password">Password:</label>
                <br>
              <input class="input_login" type="password" id="password" name="user_password">
              </div>
              <br>
            <button class="button_login" type="submit">Sign In</button>
              <br>
              <p>Sie haben noch keinen Account? <a href="?c=pages&a=register">Hier registrieren!</a></p>
          </form>
        </div>

    </body>
