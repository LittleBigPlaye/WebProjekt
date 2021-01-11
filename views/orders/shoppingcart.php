<h1>
    Ihr Warenkorb
</h1>
<?php if($order !== null) : ?>
<div class="cartListing">
    <?php foreach ($order->orderItems as $orderItem):?>
        <div class="cartEntry">
            <img src="
                    <?php
                        if($orderItem->product->images != NULL)
                        {
                            echo htmlspecialchars($orderItem->product->images[0]->path);
                        }
                        else
                        {
                            echo FALLBACK_IMAGE;
                        }
                    ?>">
            <br>
            <form method="Post">
                Bezeichnung: <?=$orderItem->product->productName?><br>
                Artikelnummer: <?=$orderItem->product->id?><br>
                Anzahl: <input type="number" min="0", step="1" name="quantity" value="<?=$orderItem->quantity?>"> Stück<br>
                Preis: <?=$orderItem->actualPrice?> €<br>
                <input type="hidden" name="pid" value="<?=$orderItem->product->id?>">
                <button type="submit" name="updateCart">Änderungen übernehmen</button>
            </form>

        </div>
    <?php endforeach; ?>
</div>

<div class="cartTotal">
    <b>Gesamtpreis:</b> <?= $totalPrice ?> €
    <form action="index.php?c=orders&a=confirmOrder" method="POST">
        <input type="submit" name="submit" value="Kaufen">
    </form>
</div>

<?php else : ?>
    <p>Sie haben bisher leider noch keine Produkte ihrem Warenkorb hinzugefügt</p>
<?php endif ?>