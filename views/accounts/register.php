    <div class="cardregister">
        <div class="containerregister">


            <form clas="loginForm"  action="?c=accounts&a=register" method="post">

          <h1>Registrierung</h1>

                <?php if(isset($errorMessage) && !empty($errorMessage)) : ?>
                    <div class="errorMessage">
                        <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
                        <p><?= $errorMessage ?></p>
                    </div>
                <?php endif ?>

          <div class="cardregister">
              <div class="containerregister">




                  <h2>Persönliche Daten</h2>
                  <br>
                  <label class="registerlabel" for="name">Vorname:</label>
                  <input class="input_register1" type="text" id="firstName" name="firstName" placeholder="Vorname" value="<?=htmlspecialchars($_POST['firstName'] ?? '')?>">
                  <br>

                    <label class="registerlabel" for="name">Zweitname:</label>
                    <input class="input_register1" type="text" id="secondName" name="secondName" placeholder="zweiter Vorname" value="<?=htmlspecialchars($_POST['secondName'] ?? '')?>">
                  <br>

                  <label class="registerlabel" for="name">Nachname:</label>
                  <input class="input_register1" type="text" id="lastName" name="lastName" placeholder="Nachname" value="<?=htmlspecialchars($_POST['lastName'] ?? '')?>">
                  <br>

                  <label class="registerlabel" for="mail">Email:</label>
                  <input class="input_register1" type="email" id="email" name="email" placeholder="E-Mail" value="<?=htmlspecialchars($_POST['email'] ?? '')?>">
                  <br>

                  <label class="registerlabel" for="password">Passwort:</label>
                  <input class="input_register1" type="password" id="password" name="password" placeholder="Passwort">
                  <br>
                  <label class="registerlabel" for="password2">Passwort wiederholen:</label>
                  <input class="input_register1" type="password" id="password2" name="password2" placeholder="Passwort wiederholen">
                  <br>

                  <label>Geschlecht:</label>
                  <input type="radio" id="female" value="f" name="gender"><label for="female" class="light">Female</label><br>
                  <input type="radio" id="male" value="m" name="gender"><label for="male" class="light">Male</label><br>
                  <input type="radio" id="divers" value="u" name="gender"><label for="divers" class="light">Divers</label><br><br>
                  <br>
                  <label>Geburtstag:</label>
                  <input class="input_register1" type="date" id="birthdate" name="birthdate" placeholder="Geburtstag" value="<?=htmlspecialchars($_POST['birthdate'] ?? '')?>">
                  <br>


              </div>
          </div>

          <div class="cardregister">
              <div class="containerregister">
                  <h2>Adresse</h2>
                  <br>

                  <label class="registerlabel">Strasse</label>
                  <input class="input_register1" type="text" id="street" name="street" placeholder="Strasse" value="<?=htmlspecialchars($_POST['street'] ?? '')?>">
                  <br>
                  <label class="registerlabel">Hausnummer</label>
                  <input class="input_register1" type="text" id="streetNumber" name="streetNumber" placeholder="Hausnummer" value="<?=htmlspecialchars($_POST['streetNumber'] ?? '')?>">
                  <br>
                  <label class="registerlabel" >Postleitzahl</label>
                  <input class="input_register1" type="text" id="zipCode" name="zipCode" placeholder="Postleitzahl" value="<?=htmlspecialchars($_POST['zipCode'] ?? '')?>">
                  <br>
                  <label class="registerlabel">Stadt</label>
                  <input class="input_register1" type="text" id="city" name="city" placeholder="Stadt" value="<?=htmlspecialchars($_POST['city'] ?? '')?>">
                  <br>


              </div>
          </div>
          <br>
          <input type="submit" value="Registrieren" name="submit" >
      </form>
        </div>
    </div>
