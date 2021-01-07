<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up Form</title>
        <link rel="stylesheet" href="assets/styles/login-style.css">
    </head>
    <body>

    <div class="cardregister">
        <div class="containerregister">
      <form  action="index.html" method="post">

          <h1>Registrierung</h1>

          <div class="cardregister">
              <div class="containerregister">




                  <h2>Persönliche Daten</h2>
                  <br>
                  <label class="registerlabel" for="name">Vorname:</label>
                  <input class="input_register1" type="text" id="firstName" name="firstName">
                  <br>

                    <label class="registerlabel" for="name">Zweitname:</label>
                    <input class="input_register1" type="text" id="secondName" name="secondName">
                  <br>

                  <label class="registerlabel" for="name">Nachname:</label>
                  <input class="input_register1" type="text" id="lastName" name="lastName">
                  <br>

                  <label class="registerlabel" for="mail">Email:</label>
                  <input class="input_register1" type="email" id="email" name="email">
                  <br>

                  <label class="registerlabel" for="password">Passwort:</label>
                  <input class="input_register1" type="password" id="password" name="password">
                  <br>
                  <label class="registerlabel" for="password2">Passwort wiederholen:</label>
                  <input class="input_register1" type="password" id="password2" name="password2">
                  <br>

                  <label>Geschlecht:</label>
                  <input type="radio" id="female" value="female" name="gender"><label for="female" class="light">Female</label><br>
                  <input type="radio" id="male" value="male" name="gender"><label for="male" class="light">Male</label><br>
                  <input type="radio" id="divers" value="divers" name="gender"><label for="divers" class="light">Divers</label><br><br>
                  <br>
                  <label>Geburtstag:</label>
                  <input class="input_register1" type="date" id="date" name="birthdate">
                  <br>


              </div>
          </div>

          <div class="cardregister">
              <div class="containerregister">
                  <h2>Adresse</h2>
                  <br>

                  <label class="registerlabel">Strasse</label>
                  <input class="input_register1" type="text" id="street" name="street">
                  <br>
                  <label class="registerlabel">Hausnummer</label>
                  <input class="input_register1" type="text" id="streetnumer" name="streetnumber">
                  <br>
                  <label class="registerlabel" >Postleitzahl</label>
                  <input class="input_register1" type="text" id="zipcode" name="zipcode">
                  <br>
                  <label class="registerlabel">Stadt</label>
                  <input class="input_register1" type="text" id="town" name="town">
                  <br>


              </div>
          </div>
          <br>
          <button class="button_login" type="submit">Sign Up</button>
      </form>
        </div>
    </div>

    </body>
</html>