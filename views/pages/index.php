<?php $numberOfSlides = 4 ?>

<section>
    <div>
        <h2>Unsere Dauerbrenner - Die halten alles auf!</h2>
    </div>
    <div>
        <?php include(VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'productSpotlight.php') ?>
    </div>
</section>


<div>
    <div>
        <h2>Masken, Masken, Masken</h2>
        <p>
            Unsere Masken sind ein bewertes Produkt, was Milliarden Kindern Arbeit liefert. <br>
            Nur Kinderhände sind in der Lage so feine Lagen zu legen und solch zierliche Stiche zu setzen
        </p>
        <br>
    </div>
    
    <section class="products">
    <?php foreach($cardProductsFirstRow as $product)
    {
        if($product !== null)
        {
            include(VIEWSPATH . DIRECTORY_SEPARATOR . 'viewAssets' . DIRECTORY_SEPARATOR . 'productCard.php');
        }
    }
    ?>
    </section>
</div>

<br>


<div>
    <h2>Schöner können Sie ihr Gesicht nicht verstecken. Die Götter wissen, dass sie es brauchen</h2>
</div>
<p>
    Unsere geklauten Motive werden ihr Leben bereichern <br>
    Mit unseren Masken wird es Ihnen so unendlich leicht gemacht Ihre menschenverachtenden Gesichtszüge zu
    verdecken.
    Nutzen Sie diese Möglichkeit!!!!
</p>
<br>
<div>
    <section class="products">
        <?php foreach($cardProductsSecondRow as $product)
        {
            if($product !== null)
            {
                include(VIEWSPATH . DIRECTORY_SEPARATOR . 'viewAssets' . DIRECTORY_SEPARATOR . 'productCard.php');
            }
        }
        ?>
    </section>
</div>

<script src="<?=JAVASCRIPTPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'shoppingCart.js'?>"></script>
