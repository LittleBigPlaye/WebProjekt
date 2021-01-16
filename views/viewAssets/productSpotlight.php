<?php $numberOfSlides = 4 ?>

<h2>Neue Produkte</h2>
<div class="productSpotlight">
    <?php foreach($spotlightProducts as $product) : ?>
        <div class="spotlightElement">
            <a class="productLink" href="index.php?c=products&a=view&pid=<?=$product->id?>" title="Zur Produktansicht">
                <img src="
                    <?php
                        // To make sure that there is at least the fallback image
                        if($product->images != null)
                        {
                            echo htmlspecialchars($product->images[0]->path);
                        }
                        else
                        {
                            echo htmlspecialchars(FALLBACK_IMAGE);
                        }
                    ?>">
                <div class="text">
                    <span class="title"><?= htmlspecialchars($product->productName)?></span>
                    <span class="phrase"><i><?= htmlspecialchars($product->catchPhrase)?></i></span>
                </div>
            </a>
        </div>
    <?php endforeach ?>

    <!-- Next and previous Buttons -->
    <a id="previousSlide" class="previousSlide" title="zurück">&#10094;</a>
    <a id="nextSlide" class="nextSlide" title="weiter">&#10095;</a>

    <script src="<?=JAVASCRIPTPATH . 'pages' . DIRECTORY_SEPARATOR . 'index.js'?>"></script>
</div>