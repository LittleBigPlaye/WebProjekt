<?php
/**
 * @author Robin Beck
 */
?>

<div class="productViewWrapper">
    <h1><?= htmlspecialchars($product->productName ?? '') ?></h1>
    <noscript>
        <div class="warningMessage">
            <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
            <p>Bitte beachten Sie, dass sie Javascript aktivieren müssen, um von allen komfortfunktionen dieser Seite profitieren zu können!</p>
        </div>
    </noscript>

    <?php if(isset($successMessage)) :?>
        <div class="successMessage">
            <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
            <p><?=$successMessage?></p>
        </div>
    <?php endif ?>

    <div class="imageGallery">
        <?php if($product->images != null) : ?>
            
            <!-- images -->
            <?php foreach($product->images as $key => $image) :?>
                <div class=gallerySlide>
                    <img src="<?=htmlspecialchars($image->path)?>" alt="<?=htmlspecialchars($image->name)?>">
                </div>
            <?php endforeach ?>

            <!-- thumbnails -->
            <div class="row">
                <?php foreach($product->images as $key => $image) :?>
                    <div class=galleryThumbnail>
                        <img src="<?=htmlspecialchars($image->path)?>" alt="<?=htmlspecialchars($image->name)?>" >
                    </div>
                <?php endforeach ?>
            </div>

        <?php else :?>
            <div class=gallerySlide>
            <img src="<?=htmlspecialchars(FALLBACK_IMAGE)?>">
            </div>
        <?php endif ?>
        
        <script src="<?=JAVASCRIPTPATH . 'products' . DIRECTORY_SEPARATOR . 'imageGallery.js'?>"></script>
        
        <?php if(!$product->isHidden) : ?>
            <form class="badge" method="POST">
                    <button class="iconButton" type="submit" name="addToCart" value="<?=$product->id?>"><img src="assets\images\icons\shopping_cart.svg"/></button>
            </form>
        <?php endif; ?>
    </div>

    <!-- product text -->
    <div class="productInformation">
        <p><?=htmlspecialchars($product->catchPhrase) ?></p>
        <p class="description"><?=nl2br(htmlspecialchars($product->productDescription)) ?></p>
        <p><b>Preis:</b> <?=htmlspecialchars($product->standardPrice)?></p>
        <p><b>Marke: </b><?=htmlspecialchars($product->vendor->vendorName) ?></p>
        <p><b>Typ: </b><?=htmlspecialchars($product->category->categoryName) ?></p>
        <a href="?c=productManagement&a=edit&pid=<?= htmlspecialchars($product->id)?>">Produkt bearbeiten</a>
    </div>
</div>