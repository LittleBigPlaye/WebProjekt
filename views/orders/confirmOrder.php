<!-- @author Robin Beck -->

<div class="formWrapper">
    <form class="orderConfirmationForm" method="POST">      
        <h1>Bestellung absenden</h1>

        <p>Bitte prüfen Sie vor dem Absenden der Bestellung, ob die nachfolgenden Angaben korrekt sind!</p>

        <h2>Zieladresse</h2>
        <p class="customerData">
            <?= htmlspecialchars($user->salutation . ' ' . $user->firstName . ' ' . $user->secondName . ' ' . $user->lastName)?><br>
            <?= htmlspecialchars($address->street . ' ' . $address->streetNumber)?><br>
            <?= htmlspecialchars($address->zipCode . ' ' . $address->city)?><br>
        </p>
        <!-- Hier Adresse anzeigen -->

        <h2>Kauf-Übersicht</h2>
        <div class="table orderConfirmation">
            <div class="tableRow head">
                <div class="tableCell">Bezeichnung</div>
                <div class="tableCell right">Artikelnummer</div>
                <div class="tableCell right">Anzahl</div>
                <div class="tableCell right">Preis</div>
            </div>


            <?php foreach ($order->orderItems as $orderItem):?>
                <div class="tableRow">
                    <div class="tableCell">
                        <label class="mobileLabel">Produktbezeichnung</label>
                        <?=htmlspecialchars($orderItem->product->productName)?>
                    </div>
                    <div class="tableCell right">
                        <label class="mobileLabel">Produkt-Nr.</label>
                        <?=htmlspecialchars(str_pad($orderItem->product->id, 12, '0', STR_PAD_LEFT))?>
                    </div>
                    <div class="tableCell right">
                        <label class="mobileLabel">Menge</label>
                        <?=htmlspecialchars($orderItem->quantity)?> Stück
                    </div>
                    <div class="tableCell right">
                        <label class="mobileLabel">Preis</label>
                        EUR <?=htmlspecialchars($orderItem->actualPrice)?>
                    </div>
                </div>
            <?php endforeach; ?>
        
            <div class="tableRow bottom">
                    <div class="tableCell"></div>
                    <div class="tableCell"></div>
                    <div class="tableCell right">Gesamtpreis</div>
                    <div class="tableCell right">EUR <?=htmlspecialchars($totalPrice)?></div>
            </div>
        </div>
        <input type="submit" name="submitOrder" value="Zahlungspflichtig bestellen">
    </form>
</div>