
<div class="formWrapper">
    <form class="productForm">
        <h1>
            Das ist dein Konto <?=htmlspecialchars($user->firstName)?>
        </h1>

        <h2>Persönliche Daten</h2>

        <section>
            <label>Vorname: <?=htmlspecialchars($user->firstName)?>  </label>
            <label>zweiter Vorname: <?=htmlspecialchars($user->secondName)?></label>
            <label>Nachname: <?=htmlspecialchars($user->lastName)?></label>
            <label>Geburtstag: <?=htmlspecialchars($user->birthDate)?></label>
            <label>Telefonnummer: <?=htmlspecialchars($user->phone)?></label>
            <label>Geschlecht: <?=htmlspecialchars($user->gender)?></label>
            <h2>Adresse</h2>
            <label>Strasse: <?=htmlspecialchars($address->street)?></label>
            <label>Hausnummer: <?=htmlspecialchars($address->streetNumber)?></label>
            <label>Postleitzahl: <?=htmlspecialchars($address->zipCode)?></label>
            <label>Stadt: <?=htmlspecialchars($address->city)?></label>
        </section>



    </form>
    <form class="productForm">
        <h2>Meine Bestellungen</h2>
        <section>
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

    </form>
</div>
