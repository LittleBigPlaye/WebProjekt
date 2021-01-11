<h1>Bestellung absenden</h1>

<p>Bitte prüfen Sie vor dem Absenden der Bestellung, ob die nachfolgenden Angaben korrekt sind!</p>

<h2>Empfänger</h2>
<!-- Hier Adresse anzeigen -->

<?php foreach ($order->orderItems as $orderItem):?>
    Bezeichnung: <?=$orderItem->product->productName?><br>
    Artikelnummer: <?=$orderItem->product->id?><br>
    Anzahl: <?=$orderItem->quantity?> Stück<br>
    Preis: <?=$orderItem->actualPrice?> €<br>
    <hr>
<?php endforeach; ?>

Gesamtpreis: <?=$totalPrice ?>

<form action method="POST">
    <input type="submit" name="submitOrder" value="Zahlungspflichtig bestellen">
</form>