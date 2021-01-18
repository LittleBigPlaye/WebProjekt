

<div class="formWrapper">
    <form class="formWrapperRegister"  action="?c=accounts&a=register" method="post">

              <h1>Registrierung</h1>

                    <?php if(isset($errorMessage) && !empty($errorMessage)) : ?>
                        <div class="errorMessage">
                            <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
                            <p><?= $errorMessage ?></p>
                        </div>
                    <?php endif ?>




                      <h2>Persönliche Daten</h2>

                      <label for="firstName">Vorname:</label>
                      <input class="input_register1" type="text" id="firstName" name="firstName" placeholder="Vorname" value="<?=htmlspecialchars($_POST['firstName'] ?? '')?>">


                        <label  for="secondName">Zweitname:</label>
                        <input class="input_register1" type="text" id="secondName" name="secondName" placeholder="zweiter Vorname" value="<?=htmlspecialchars($_POST['secondName'] ?? '')?>">

                      <label for="lastName">Nachname:</label>
                      <input class="input_register1" type="text" id="lastName" name="lastName" placeholder="Nachname" value="<?=htmlspecialchars($_POST['lastName'] ?? '')?>">


                      <label for="email">Email:</label>
                      <input class="input_register1" type="email" id="email" name="email" placeholder="E-Mail" value="<?=htmlspecialchars($_POST['email'] ?? '')?>">


                      <label for="password">Passwort:</label>
                      <input class="input_register1" type="password" id="password" name="password" placeholder="Passwort">

                      <label for="password2">Passwort wiederholen:</label>
                      <input class="input_register1" type="password" id="password2" name="password2" placeholder="Passwort wiederholen">


                      <label>Geschlecht:</label>
                      <input type="radio" id="female" value="f" name="gender"><label for="female" class="light">Frau</label><br>
                      <input type="radio" id="male" value="m" name="gender"><label for="male" class="light">Mann</label><br>
                      <input type="radio" id="divers" value="u" name="gender"><label for="divers" class="light">Das was ich sein möchte</label><br><br>


                      <label>Geburtstag:</label>
                      <input class="input_register1" type="date" id="birthdate" name="birthdate" placeholder="Geburtstag" value="<?=htmlspecialchars($_POST['birthdate'] ?? '')?>">
                      <br>





                      <h2>Adresse</h2>


                      <label for="street">Strasse</label>
                      <input class="input_register1" type="text" id="street" name="street" placeholder="Strasse" value="<?=htmlspecialchars($_POST['street'] ?? '')?>">

                      <label for="streetNumber">Hausnummer</label>
                      <input class="input_register1" type="text" id="streetNumber" name="streetNumber" placeholder="Hausnummer" value="<?=htmlspecialchars($_POST['streetNumber'] ?? '')?>">

                      <label for="zipCode">Postleitzahl</label>
                      <input class="input_register1" type="text" id="zipCode" name="zipCode" placeholder="Postleitzahl" value="<?=htmlspecialchars($_POST['zipCode'] ?? '')?>">

                      <label for="city">Stadt</label>
                      <input class="input_register1" type="text" id="city" name="city" placeholder="Stadt" value="<?=htmlspecialchars($_POST['city'] ?? '')?>">


              <br>
              <input type="submit" value="Registrieren" name="submit" >
    </form>
</div>