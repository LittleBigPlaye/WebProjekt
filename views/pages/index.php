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
            Unsere Masken sind ein bewertes Produkt, was Milliarden Kindern Arbeit liefert. <br>
            Nur Kinderhände sind in der Lage so feine Lagen zu legen und solch zierliche Stiche zu setzen
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
    Unsere geklauten Motive werden ihr Leben bereichern <br>
    Mit unseren Masken wird es Ihnen so unendlich leicht gemacht Ihre menschenverachtenden Gesichtszüge zu
    verdecken.<br>
    Nutzen Sie diese Möglichkeit!
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