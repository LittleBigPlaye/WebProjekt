<!-- @author John Klippstein, Robin Beck -->
<div>
    <div>
        <h2>Unsere Dauerbrenner - Die halten alles auf!</h2>
    </div>
    <div>
        <?php include(VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'productSpotlight.php') ?>
    </div>
</div>


<div>
    <div>
        <h2>Schöner können Sie ihr Gesicht nicht verstecken.</h2>
        <p>
            <!-- Neu -->
            Unsere Masken sind bewährte Produkte aus handverlesenen Stoffen.<br>
            Haptik und Tragegefühl sind unvergleichlich.
        </p>
        <br>
    </div>

    <div class="products frontPage">
        <?php
            foreach ($cardProductsFirstRow as $product) 
            {
                if ($product !== null) 
                {
                    include(VIEWSPATH . DIRECTORY_SEPARATOR . 'viewAssets' . DIRECTORY_SEPARATOR . 'productCard.php');
                }
            }
        ?>
    </div>
</div>

<br>


<div>
    <h2>Die Götter wissen, dass sie sie brauchen</h2>
</div>
<p>
    <!-- Neu -->
    Unsere Motive werden Ihr Leben bereichern.<br>
    Sie werden die Masken in Ihrem Alltag nicht mehr missen wollen.
</p>
<br>

<div>
    <div class="products frontPage">
        <?php 
            foreach ($cardProductsSecondRow as $product) 
            {
                if ($product !== null) {
                    include(VIEWSPATH . DIRECTORY_SEPARATOR . 'viewAssets' . DIRECTORY_SEPARATOR . 'productCard.php');
                }
            }
        ?>
    </div>
</div>

<script src="<?= JAVASCRIPTPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'addToCart.js' ?>"></script>