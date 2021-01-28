
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

            <div class="table">
                <div class="tableRow head">
                    <div class="tableCell center">
                        Bezeichnung
                    </div>
                    <div class="tableCell center">
                        Artikelnummer
                    </div>
                    <div class="tableCell center">
                        Anzahl
                    </div>
                    <div class="tableCell center">
                        Preis
                    </div>
                </div>
                <?php foreach ($order->orderItems as $orderItem) : ?>

                <div class="tableRow">
                    <div class="tableCell center">
                        <?=$orderItem->product->productName?>
                    </div>
                    <div class="tableCell center">
                        <?=htmlspecialchars(str_pad($orderItem->product->id, 12, '0', STR_PAD_LEFT))?>
                    </div>
                    <div class="tableCell center">
                        <?=$orderItem->quantity?> Stück
                    </div>
                    <div class="tableCell center">
                        <?=$orderItem->actualPrice*$orderItem->quantity?> €
                    </div>
                </div>
                <?php endforeach ?>
            </div>
                <hr>
            <?php endforeach?>
        </section>
        </div>
    </form>
</div>