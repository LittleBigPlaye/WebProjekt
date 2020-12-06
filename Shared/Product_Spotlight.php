<?php $numberOfSlides = 4 ?>

<h2>Beliebte Produkte</h2>
<div class="productSpotlight">
    <?php for($i = 0; $i < $numberOfSlides; $i++) : ?>
        <div class="spotlightElement">
            <img class="spotlightPreview fade" src="./Static/assets/Mask/mask_preview.png">
            <div class="spotlightText fade">
                <h3 class="spotlightTitle">Maske <?=$i?></h3>
                <p class="spotlightDescription">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aut et, cum ea ab beatae vero, aperiam
                    voluptatibus reiciendis sint atque veniam earum sapiente dignissimos excepturi? Maiores numquam
                    consequuntur officia eaque?
                </p>
            </div>
        </div>
    <?php endfor ?>

    <!-- Next and previous Buttons -->
    <a class="previousSlide" onclick="plusSlides(-1)">&#10094;</a>
    <a class="nextSlide" onclick="plusSlides(1)">&#10095;</a>

    <!-- Slide Dots -->
    <div class="slideDots">
        <?php for($i = 1; $i <= $numberOfSlides; $i++) : ?>
            <span class="dot" onclick="currentSlide(<?=$i?>)"></span>
        <?php endfor ?>
    </div>
    <script src="slideshow.js"></script>
</div>