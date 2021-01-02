<?php
/**
 * @author Robin Beck
 */
?>

<h1><?= htmlspecialchars($product->productName ?? '') ?></h1>
<noscript>
<div class="warningMessage">
    <p>Bitte beachten Sie, dass sie Javascript aktivieren müssen, um von allen komfortfunktionen dieser Seite profitieren zu können!</p>
</div>
</noscript>

<div class="imageGallery">
    <?php
        if($product->images != null)
        {
            foreach($product->images as $key => $image)
            {
                echo '<div class=gallerySlide>';
                // image slide
                echo '<img src="';
                if(file_exists($image->path))
                {
                    echo htmlspecialchars($image->path);
                }
                else
                {
                    echo htmlspecialchars(FALLBACK_IMAGE);
                }
                echo '"title="' . $image->name .'">';
                echo '</div>';
            }

            echo '<div class="row">';
            foreach($product->images as $key => $image)
            {
                // image thumbnail
                echo '<div class=galleryThumbnail>';
                echo '<img src="';
                if(file_exists($image->path))
                {
                    echo htmlspecialchars($image->path);
                }
                else
                {
                    echo htmlspecialchars(FALLBACK_IMAGE);
                }
                echo '"title="' . $image->name .'" onclick="setGalleryPosition('. $key .')">';
                echo '</div>';
            }
            echo '</div>';
        }
        else
        {
            echo '<div class=gallerySlide>';
            echo '<img src="';
            echo htmlspecialchars(FALLBACK_IMAGE);
            echo '">';
            echo '</div>';
        }
        
    ?> 
<script src="assets/javascript/imageGallery.js"></script>
</div>
<p><?=htmlspecialchars($product->catchPhrase) ?></p>
<p><?=htmlspecialchars($product->productDescription) ?></p>
<p><b>Preis:</b> <?=htmlspecialchars($product->standardPrice)?></p>
<p><b>Marke: </b><?=htmlspecialchars($product->vendor->vendorName) ?></p>
<p><b>Typ: </b><?=htmlspecialchars($product->category->categoryName) ?></p>
<a href="?c=products&a=edit&pid=<?= htmlspecialchars($product->id)?>">Produkt bearbeiten</a>
<br>
<a href="?c=products&a=view&IDForCart=<?= htmlspecialchars($product->id) ?>">In den Wareknkorb</a>
