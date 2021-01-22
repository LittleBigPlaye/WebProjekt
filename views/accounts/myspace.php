
<div class="formWrapper">
    <form class="productForm">
        <h1>
            Das ist dein Konto <?=htmlspecialchars($user->firstName)?>
        </h1>

        <?php if(isset($successMessage)) :?>
            <div class="successMessage">
                <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
                <p><?=$successMessage?></p>
            </div>
        <?php endif ?>

        <h2>Persönliche Daten</h2>

        <section class="formWrapper">
            <label>Vorname: <?=htmlspecialchars($user->firstName)?>  </label>
            <label>zweiter Vorname: <?=htmlspecialchars($user->secondName)?></label>
            <label>Nachname: <?=htmlspecialchars($user->lastName)?></label>
            <label>Geburtstag: <?=htmlspecialchars(date('d.m.Y' ,strtotime($user->birthDate)))?></label>
            <label>Telefonnummer: <?=htmlspecialchars($user->phone)?></label>
            <label>Geschlecht: <?=htmlspecialchars($user->gender)?></label>
            <h2>Adresse</h2>
            <label>Strasse: <?=htmlspecialchars($address->street)?></label>
            <label>Hausnummer: <?=htmlspecialchars($address->streetNumber)?></label>
            <label>Postleitzahl: <?=htmlspecialchars($address->zipCode)?></label>
            <label>Stadt: <?=htmlspecialchars($address->city)?></label>
        </section>
        <br>
        <hr>


        <h2>Änderungen stehen bevor</h2>
        <section class="formWrapper">

            <a href="index.php?c=accounts&a=changesecrets">Passwort ändern</a>
            <a href="index.php?c=accounts&a=changepersonaldata">Personas ändern</a>
            <a href="index.php?c=accounts&a=changeaddress">Adresse ändern</a>

        </section>


        <hr>
        <br>

        <h2>Meine Bestellungen</h2>
        <section class="formWrapper">
            Machen Sie etwas sinnvolles während Sie auf Ihre Bestellung/en warten (JavaScript muss aktiviert sein!)<br>
            <a href="index.php?c=accounts&a=waitingarea">Etwas sinnvolles</a>
        </section>
        <br>

        <section class="formWrapper">
            <?php foreach($orders as $order) :?>

                <h3>Bestellung <?=htmlspecialchars($order->id)?></h3>

                <?php foreach ($order->orderItems as $orderItem) : ?>
                    Bezeichnung: <?=$orderItem->product->productName?><br>
                    Artikelnummer: <?=$orderItem->product->id?><br>
                    Anzahl: <?=$orderItem->quantity?> Stück<br>
                    Preis: <?=$orderItem->actualPrice*$orderItem->quantity?> €<br>
                <hr>
                <?php endforeach ?>

            <?php endforeach?>
        </section>
        </div>
    </form>
</div>