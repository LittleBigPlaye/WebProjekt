<h1>
    Ihr Warenkorb
</h1>
<?php if($order !== null) : ?>
<div class="cartListing">
    <div class="table"> 
            <div class="tableRow head">
                <div class="tableCell"></div>
                <div class="tableCell"></div>
                <div class="tableCell"></div>
                <div class="tableCell"></div>
                <div class="tableCell">Anzahl</div>
            </div>

            <?php foreach ($order->orderItems as $orderItem):?>
                <div class="tableRow">
                    <div class="tableCell">    
                        <img class="productPreview" src="
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
                    </div>
                    <div class="tableCell"> Bezeichnung: <?=$orderItem->product->productName?></div>
                    <div class="tableCell">Artikelnummer: <?=$orderItem->product->id?></div>
                    <div class="tableCell">Preis: <?=$orderItem->actualPrice?> €</div>
                    <form class="tableCell" method="Post">
                        <input type="number" min="0", step="1" name="quantity" value="<?=$orderItem->quantity?>">
                        <input type="hidden" name="pid" value="<?=$orderItem->product->id?>">
                        <button type="submit" name="updateCart">Änderungen übernehmen</button>
                    </form>
                </div>
        <?php endforeach; ?>
    </div>
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