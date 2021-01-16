<div class="formWrapper">
    <form action method="POST">      
        <h1>Bestellung absenden</h1>

        <p>Bitte prüfen Sie vor dem Absenden der Bestellung, ob die nachfolgenden Angaben korrekt sind!</p>

        <h2>Empfänger</h2>
        <?= htmlspecialchars($user->salutation . ' ' . $user->firstName . ' ' . $user->secondName . ' ' . $user->lastName)?><br>
        <?= htmlspecialchars($address->street . ' ' . $address->streetNumber)?><br>
        <?= htmlspecialchars($address->zipCode . ' ' . $address->city)?><br>
        <!-- Hier Adresse anzeigen -->

        <h2>Positionen</h2>
        <div class="table orderConfirmation">
            <div class="tableRow head">
                <div class="tableCell">Bezeichnung</div>
                <div class="tableCell right">Artikelnummer</div>
                <div class="tableCell right">Anzahl</div>
                <div class="tableCell right">Preis</div>
            </div>


            <?php foreach ($order->orderItems as $orderItem):?>
                <div class="tableRow">
                    <div class="tableCell"><?=htmlspecialchars($orderItem->product->productName)?></div>
                    <div class="tableCell right"><?=htmlspecialchars(str_pad($orderItem->product->id, 12, '0', STR_PAD_LEFT))?></div>
                    <div class="tableCell right"><?=htmlspecialchars($orderItem->quantity)?> Stück</div>
                    <div class="tableCell right"><?=htmlspecialchars($orderItem->actualPrice)?> €</div>
                </div>
            <?php endforeach; ?>
        
            <div class="tableRow head">
                    <div class="tableCell"></div>
                    <div class="tableCell"></div>
                    <div class="tableCell right">Gesamtpreis</div>
                    <div class="tableCell right"><?=htmlspecialchars($totalPrice)?> €</div>
            </div>
        </div>
        <input type="submit" name="submitOrder" value="Zahlungspflichtig bestellen">
    </form>
</div>