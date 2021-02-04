<!-- @author Robin Beck -->

<?php $cartCount = isset($_SESSION['shoppingCart']) ? array_sum($_SESSION['shoppingCart']) : ''; ?>
<div class="shoppingCart">
    <h1>Warenkorb</h1>

    <?php if ($order !== null) : ?>
        <div class="cartListing">
            <div class="table shoppingCart">
                <div class="tableRow head">
                    <div class="tableCell">Produkte</div>
                    <div class="tableCell"></div>
                    <div class="tableCell"></div>
                    <div class="tableCell"></div>
                </div>

                <?php foreach ($order->orderItems as $index => $orderItem) : ?>
                    <div class="tableRow" id="product<?= $orderItem->product->id ?>">
                        <div class="tableCell">
                            <a href="index.php?c=products&a=view&pid=<?= $orderItem->product->id ?>">
                                <div class="imageWrapper">
                                    <?php if ($orderItem->product->images != NULL) : ?>
                                        <img src="<?= htmlspecialchars($orderItem->product->images[0]->thumbnailPath); ?>" alt="<?= htmlspecialchars($orderItem->product->productName) ?>">
                                    <?php else : ?>
                                        <img src="<?= htmlspecialchars(FALLBACK_IMAGE); ?>" alt="<?= htmlspecialchars($orderItem->product->productName) ?>">
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                        <div class="tableCell">
                            <label for="productName<?= $index ?>">Bezeichnung</label>
                            <span id="productName<?= $index ?>"><?= htmlspecialchars($orderItem->product->productName) ?></span><br>
                            <label for="productId<?= $index ?>">Produkt-Nr.</label>
                            <span id="productId<?= $index ?>"><?= htmlspecialchars(str_pad($orderItem->product->id, 12, '0', STR_PAD_LEFT)) ?></span>
                        </div>

                        <div class="tableCell">
                            <label for="price<?= $orderItem->product->id ?>">Preis</label>
                            <span id="price<?= $orderItem->product->id ?>"><?= htmlspecialchars(number_format($orderItem->actualPrice, 2, ',', '.')) ?> €</span>
                        </div>

                        <form class="tableCell" method="Post">
                            <label for="quantity<?= $index ?>">Menge</label>
                            <input id="quantity<?= $index ?>" class="quantitySelector" type="number" min="0" , step="1" name="quantity" value="<?= $orderItem->quantity ?>">
                            <input type="hidden" name="pid" value="<?= $orderItem->product->id ?>">
                            <button class="cartQuantitySubmit" type="submit" name="updateCart">Änderungen übernehmen</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="cartTotal">
            <form action="index.php?c=orders&a=confirmOrder" method="POST">
                <input type="submit" name="submit" value="Kaufen">
            </form>
            <div class="table">
                <div class="row">
                    <div class="cell left">Artikel(<span id="numberOfProducts"><?= $cartCount ?></span>)</div>
                    <div class="cell right">EUR <span id="priceSum"><?= $totalPrice ?></span></div>
                </div>

                <div class="row">
                    <!-- placeholder, might be replaced, if the shop starts to offer real products with real shipping costs -->
                    <div class="cell left">Versand</div>
                    <div class="cell right">kostenlos</div>
                </div>
            </div>

            <hr>
            <div class="table">
                <div class="row">
                    <div class="cell left"><b>Gesamt</b></div>
                    <div class="cell right">EUR <span id="totalPrice"><?= $totalPrice ?></span></div>
                </div>
            </div>
        </div>
        <script src="<?= JAVASCRIPTPATH . 'orders' . DIRECTORY_SEPARATOR . 'shoppingCart.js' ?>"></script>
    <?php else : ?>
        <p class="emptySearch">Sie haben bisher leider noch keine Produkte ihrem Warenkorb hinzugefügt</p>
    <?php endif; ?>
</div>