<?php $cartCount = isset($_SESSION['shoppingCart']) ? array_sum($_SESSION['shoppingCart']) : '';?>
<h1>Warenkorb</h1>

<?php if($order !== null) : ?>
    <div class="cartListing">
        <div class="table shoppingCart"> 
                <div class="tableRow head">
                    <div class="tableCell">Produkte</div>
                    <div class="tableCell"></div>
                    <div class="tableCell"></div>
                    <div class="tableCell"></div>
                </div>

            <?php foreach ($order->orderItems as $index => $orderItem):?>
                <div class="tableRow">
                    <div class="tableCell">    
                        <a href="index.php?c=products&a=view&pid=<?=$orderItem->product->id?>">
                            <img class="productPreview" src="
                                <?php
                                    if($orderItem->product->images != NULL)
                                    {
                                        echo htmlspecialchars($orderItem->product->images[0]->thumbnailPath);
                                    }
                                    else
                                    {
                                        echo FALLBACK_IMAGE;
                                    }
                                ?>">
                        </a>
                    </div>
                    <div class="tableCell">
                        <label for="productName<?=$index?>">Bezeichnung</label>
                        <span id="productName<?=$index?>"><?=htmlspecialchars($orderItem->product->productName)?></span><br>
                        <label for="productId<?=$index?>">Produkt-Nr.</label>
                        <span id="productId<?=$index?>"><?=htmlspecialchars(str_pad($orderItem->product->id, 12, '0', STR_PAD_LEFT))?></span>
                    </div>

                    <div class="tableCell">
                        <label for="price<?=$index?>">Preis</label>
                        <span id="price<?=$index?>"><?=htmlspecialchars($orderItem->actualPrice)?> €</span>
                    </div>
                    
                    <form class="tableCell" method="Post">
                        <label for="quantity<?=$index?>">Menge</label>
                        <input id="quantity<?=$index?>" class="quantitySelector" type="number" min="0", step="1" name="quantity" value="<?=$orderItem->quantity?>">
                        <button class="cartQuantitySubmit" type="submit" name="updateCart">Änderungen übernehmen</button>
                        <input type="hidden" name="pid" value="<?=$orderItem->product->id?>">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="cartTotal">
        <b>Produkte:</b> <?=$cartCount?><br>
        <b>Gesamtpreis:</b> <?= $totalPrice ?> €
        <form action="index.php?c=orders&a=confirmOrder" method="POST">
            <input type="submit" name="submit" value="Kaufen">
        </form>
    </div>
    <script src="<?=JAVASCRIPTPATH . 'orders' . DIRECTORY_SEPARATOR . 'shoppingCart.js'?>"></script>
<?php else : ?>
    <p>Sie haben bisher leider noch keine Produkte ihrem Warenkorb hinzugefügt</p>
<?php endif ?>