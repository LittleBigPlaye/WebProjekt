<h1>Unsere Marken</h1>


    <?php foreach($vendorProducts as $key => $currentVendorProducts) :?>
        <div class="vendorsWrapper">
            <label for="vendorToggle<?=htmlspecialchars($vendors[$key]->vendorName)?>"><?=htmlspecialchars($vendors[$key]->vendorName)?></label>
            <input type="checkbox" id="vendorToggle<?=htmlspecialchars($vendors[$key]->vendorName)?>" class="vendorToggle">
            <div class=vendorContainer>
                <p><?=htmlspecialchars($vendors[$key]->vendorName)?></p>
                <section class="products">
                    <?php foreach($currentVendorProducts as $product) 
                    {
                        if($product !== null)
                        {
                            include(VIEWSPATH . DIRECTORY_SEPARATOR . 'viewAssets' . DIRECTORY_SEPARATOR . 'productCard.php');
                        }
                    }
                    ?>
                </section>
                <form action="index.php" method="Get">
                    <input type="hidden" name="c" value="products">
                    <input type="hidden" name="a" value="search">
                    <input type="hidden" name="ven<?=$vendors[$key]->id?>" value="<?=$vendors[$key]->id?>">
                    <button class="customSubmit">Weitere Produkte anzeigen</button>
                </form>
            </div>
        </div>
    <?php endforeach ?>
    <script src="<?=JAVASCRIPTPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'shopping_cart.js'?>"></script>