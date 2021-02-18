<!-- @author Robin Beck -->

<div class="productViewWrapper">
    <h1><?= htmlspecialchars($product->productName ?? '') ?></h1>
    <noscript>
        <input class="messageToggle" type="checkbox" id="infoToggle">
        <div class="message warningMessage">
            <label class="messageClose" for="infoToggle">&times</label>
            <p>Bitte beachten Sie, dass Sie Javascript aktivieren müssen, um von allen komfortfunktionen dieser Seite profitieren zu können!</p>
        </div>
    </noscript>

    <?php if (isset($successMessage)) : ?>
        <input class="messageToggle" type="checkbox" id="successToggle">
        <div class="message successMessage">
            <label class="messageClose" for="successToggle">&times</label>
            <p><?= $successMessage ?></p>
        </div>
    <?php endif; ?>

    <!-- image gallery -->
    <div class="imageGallery <?= ($product->isHidden) ? 'isHidden' : '' ?>">
        <?php if ($product->images != null) : ?>

            <!-- images -->
            <div class="imageContainer">
                <?php foreach ($product->images as $key => $image) : ?>
                    <div class="gallerySlide">
                        <div class="imageWrapper">
                            <img src="<?= htmlspecialchars($image->path) ?>" alt="<?= htmlspecialchars($image->name) ?>">
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- edit button -->
                <?php if ($this->isAdmin()) : ?>
                    <div class="badge edit">
                        <a class="iconButton" title="Artikel bearbeiten" href="?c=productManagement&a=edit&pid=<?= htmlspecialchars($product->id) ?>"><img src="assets/images/icons/edit_icon.svg" /></a>
                    </div>
                <?php endif; ?>

                <?php if (!$product->isHidden) : ?>
                    <!-- add to cart button -->
                    <form class="badge" method="POST" action="#prod<?= $product->id ?>">
                        <button class="iconButton cartButton" type="submit" name="addToCart" title="Dem Warenkorb hinzufügen" value="<?= $product->id ?>">
                            <img src="assets/images/icons/shopping_cart.svg" />
                            <span><img src="assets/images/icons/tick.svg" alt=""></span>
                        </button>
                    </form>
                <?php else : ?>
                    <!-- hidden notification icon -->
                    <div class="badge">
                        
                        <div class="hiddenIcon"><img src="assets/images/icons/hidden_icon.svg" alt="Unsichtbar" title="Unsichtbar"></div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- thumbnails -->
            <div class="row">
                <?php foreach ($product->images as $key => $image) : ?>
                    <div class="galleryThumbnail">
                        <div class="imageWrapper">
                            <img src="<?= htmlspecialchars($image->thumbnailPath) ?>" alt="<?= htmlspecialchars($image->name) ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else : ?>
            <div class=gallerySlide>
                <img src="<?= htmlspecialchars(FALLBACK_IMAGE) ?>">
            </div>
        <?php endif; ?>

        <script src="<?= JAVASCRIPTPATH . 'products' . DIRECTORY_SEPARATOR . 'imageGallery.js' ?>"></script>
    </div>

    <!-- product text -->
    <div class="productInformation">
        <p><?= htmlspecialchars($product->catchPhrase) ?></p>
        <p class="price"><b>Preis:</b> <?= htmlspecialchars($product->formattedPrice) ?> €</p>
        <p><b>Marke: </b><?= htmlspecialchars($product->vendor->vendorName) ?></p>
        <p><b>Typ: </b><?= htmlspecialchars($product->category->categoryName) ?></p>
        <hr>
        <label>Produktbeschreibung</label>

        <div id="collapsible" class="collapsibleContainer">
            <p class="description"><?= nl2br(htmlspecialchars($product->productDescription)) ?></p>
            <div id="collapsibleFadeout" class="collapsibleFadeout">
                <label for="collapsibleToggle"><input class="collapsibleToggle" id="collapsibleToggle" type="checkbox"><img src="assets/images/icons/more_arrow.svg" alt="More Arrow"></label>
            </div>
        </div>
        <script src="<?= JAVASCRIPTPATH . 'products' . DIRECTORY_SEPARATOR . 'viewCollapsible.js' ?>"></script>
    </div>
</div>
<script src="<?= JAVASCRIPTPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'addToCart.js' ?>"></script>