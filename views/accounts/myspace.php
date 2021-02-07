<div class="formWrapper">
    <form class="productForm">
        <h1>
            Das ist dein Konto <?= htmlspecialchars($user->firstName) ?>
        </h1>

        <?php if (isset($successMessage)) : ?>
        <input class="messageToggle" type="checkbox" id="successToggle">
        <div class="message successMessage">
            <label class="messageClose" for="successToggle">&times</label>
            <p><?= $successMessage ?></p>
        </div>
        <?php endif ?>

        <h2>Persönliche Daten</h2>

        <section class="formWrapper mySpace">
            <label>Vorname: <span><?= htmlspecialchars($user->firstName) ?> </span> </label>
            <label>zweiter Vorname: <span><?= htmlspecialchars($user->secondName) ?></span></label>
            <label>Nachname: <span> <?= htmlspecialchars($user->lastName) ?></span></label>
            <label>Geburtstag: <span><?= htmlspecialchars(date('d.m.Y', strtotime($user->birthDate))) ?></span></label>
            <label>Telefonnummer: <span><?= htmlspecialchars($user->phone) ?></span></label>
            <label>Geschlecht: <span><?= htmlspecialchars($user->gender) ?></span></label>
            <h2>Adresse</h2>
            <label>Strasse: <span><?= htmlspecialchars($address->street) ?></span></label>
            <label>Hausnummer: <span><?= htmlspecialchars($address->streetNumber) ?></span></label>
            <label>Postleitzahl: <span><?= htmlspecialchars($address->zipCode) ?></span></label>
            <label>Stadt: <span><?= htmlspecialchars($address->city) ?></span></label>
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
        <section class="formWrapper jsRelevant">
            Machen Sie etwas sinnvolles während Sie auf Ihre Bestellung/en warten (Tastatur notwendig)<br>
            <a href="index.php?c=accounts&a=waitingArea">Etwas sinnvolles</a>
            <br>
        </section>

        <section class="formWrapper">
            <?php foreach ($orders as $order) : ?>

            <h3>Bestellung <?= htmlspecialchars($order->id) ?></h3>

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
                        <?= $orderItem->product->productName ?>
                    </div>
                    <div class="tableCell center">
                        <?= htmlspecialchars(str_pad($orderItem->product->id, 12, '0', STR_PAD_LEFT)) ?>
                    </div>
                    <div class="tableCell center">
                        <?= $orderItem->quantity ?> Stück
                    </div>
                    <div class="tableCell center">
                        <?= $orderItem->formattedActualPrice ?> €
                    </div>
                </div>
                <?php endforeach ?>
            </div>
            <hr>
            <?php endforeach ?>
        </section>
</div>
</form>
</div>
<script src="<?= JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'jsDisplayer.js' ?>"></script>