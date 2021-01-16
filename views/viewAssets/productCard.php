<div class="card" id="prod<?=$product->id?>">
    <div class="container">
        <div class="productPreview">
            <img <?= $product->isHidden ? 'class="hidden"' : '' ?>src="
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
                    <form method="POST" action="#prod<?=$product->id?>">
                        <button class="iconButton" type="submit" name="addToCart" value="<?=$product->id?>"><img src="assets\images\icons\shopping_cart.svg"/></button>
                    </form>
                <?php else : ?>
                    <div class="hiddenIcon"><img src="assets\images\icons\hidden_icon.svg" alt="Unsichtbar" title="Unsichtbar"></div>
                <?php endif ?>
        </div>
        
            <i><?= $product->isHidden ? '[unsichtbar]' : ''?></i><br>
            <b><?= htmlspecialchars($product->productName) ?></b><br>
            <i><?= htmlspecialchars($product->catchPhrase) ?><br></i>
            <b><?= htmlspecialchars($product->standardPrice . ' €')?></b><br>
            <a href="index.php?c=products&a=view&pid=<?= htmlspecialchars($product->id) ?>">Anzeigen</a>
    </div>
</div>