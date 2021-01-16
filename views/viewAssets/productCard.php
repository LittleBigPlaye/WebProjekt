<div class="productCard" id="prod<?=$product->id?>">
    <p><?= htmlspecialchars($product->productName) ?></p>
    <div class="productPreview">
        <img class="productImage<?= $product->isHidden ? ' hidden' : '' ?>" src="
            <?php
                if($product->images != NULL)
                {
                    echo htmlspecialchars($product->images[0]->path);
                }
                else
                {
                    echo FALLBACK_IMAGE;
                }
            ?>">

            <?php if(!$product->isHidden) : ?>
                <!-- add to cart button -->
                <form class="badge" method="POST" action="#prod<?=$product->id?>">
                    <button class="iconButton" type="submit" name="addToCart" value="<?=$product->id?>"><img src="assets\images\icons\shopping_cart.svg"/></button>
                </form>

            <?php else : ?>
                <!-- hidden notification icon -->
                <div class="badge">
                    <div class="hiddenIcon"><img src="assets\images\icons\hidden_icon.svg" alt="Unsichtbar" title="Unsichtbar"></div>
                </div>
            <?php endif ?>
    </div>
    
    <p class="price"><?= htmlspecialchars($product->standardPrice . ' €')?></p>
    <p class="catchPhrase"><?= htmlspecialchars($product->catchPhrase) ?></p>
</div>