<div class="card">
        <div class="container">
        <div class="productPreview">
        <img src="
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
            <br>
            <form method="POST">
                <button class="iconButton" type="submit" name="addToCart" value="<?=$product->id?>"><img src="assets\images\icons\shopping_cart.svg"/></button>
            </form>
        </div>
            <i><?= $product->isHidden ? '[unsichtbar]' : ''?></i><br>
            <b><?= htmlspecialchars($product->productName) ?></b><br>
            <i><?= htmlspecialchars($product->catchPhrase) ?><br></i>
            <b><?= htmlspecialchars($product->standardPrice . ' €')?></b><br>
            <a href="?c=products&a=view&pid=<?= htmlspecialchars($product->id) ?>">Anzeigen</a>
            
        </div>
    </div>