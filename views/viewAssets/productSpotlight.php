<?php $numberOfSlides = 4 ?>

<h2>Neue Produkte</h2>
<div class="productSpotlight">
    <?php foreach($spotlightProducts as $product) : ?>
        <a class="productLink" href="index.php?c=products&a=view&pid=<?=$product->id?>" title="Zur Produktansicht">
        <div class="spotlightElement">
            <img class="spotlightPreview fade" src="
            <?php
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
        </div></a>
    <?php endforeach ?>

    <!-- Next and previous Buttons -->
    <a class="previousSlide" title="zurück" onclick="plusSlides(-1)">&#10094;</a>
    <a class="nextSlide" title="weiter" onclick="plusSlides(1)">&#10095;</a>

    <!-- Slide Dots -->
    <div class="slideDots">
        <?php for($i = count($spotlightProducts)+1; $i <= $numberOfSlides; $i++) : ?>
        <span class="dot" onclick="currentSlide(<?=$i?>)"></span>
        <?php endfor ?>
    </div>
    <script src="./assets/javascript/slideshow.js"></script>
</div>