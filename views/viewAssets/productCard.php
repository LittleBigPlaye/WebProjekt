
<?php
    //create an empty product card for ajax purposes
    if(isset($isPrefab))
    {
        $product = new \myf\models\Product(array(
            'id' => -1
        ));
    }
?>

<div class="productCard" id="prod<?=$product->id?>">
    <a href="index.php?c=products&a=view&pid=<?= htmlspecialchars($product->id) ?>">    
        <p class="title"><?= htmlspecialchars($product->productName) ?></p>
        
        <div class="productPreview<?= $product->isHidden ? ' hidden' : '' ?>">
            <img class="productImage" src="
            <?php
                if($product->images != NULL)
                {
                    echo htmlspecialchars($product->images[0]->thumbnailPath);
                }
                else
                {
                    echo FALLBACK_IMAGE;
                }
            ?>">

            <?php if( isset($isPrefab) || !$product->isHidden) : ?>
                <!-- add to cart button -->
                <form class="badge" method="POST" action="#prod<?=$product->id?>">
                    <button class="iconButton cartButton" type="submit" name="addToCart" value="<?=$product->id?>"><img src="assets/images/icons/shopping_cart.svg"/></button>
                </form>
            <?php endif; ?>

            <?php if(isset($isPrefab) || $product->isHidden): ?>
                <!-- hidden notification icon -->
                <div class="badge">
                    <div class="hiddenIcon"><img src="assets/images/icons/hidden_icon.svg" alt="Unsichtbar" title="Unsichtbar"></div>
                </div>
            <?php endif; ?>
        </div>

        <p class="price"><?= htmlspecialchars($product->standardPrice . ' €')?></p>
        <p class="catchPhrase"><?= htmlspecialchars($product->catchPhrase) ?></p>
    </a>
</div>
