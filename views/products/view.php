<?php
/**
 * @author Robin Beck
 */
?>

<h1><?= htmlspecialchars($product->productName ?? '') ?></h1>

<?php
    if($product->images != null)
    {
        foreach($product->images as $image)
        {
            echo '<img src="';
            if(file_exists($image->path))
            {
                echo htmlspecialchars($image->path);
            }
            else
            {
                echo htmlspecialchars(FALLBACK_IMAGE);
            }
            echo '" width="250px" title="' . $image->name .'">';
        }
    }
    else
    {
        echo '<img src="';
        echo htmlspecialchars(FALLBACK_IMAGE);
        echo '" width="250px">';
    }
    
?> 

<p><?=htmlspecialchars($product->catchPhrase) ?></p>
<p><?=htmlspecialchars($product->productDescription) ?></p>
<p><b>Preis:</b> <?=htmlspecialchars($product->standardPrice)?></p>
<p><b>Marke: </b><?=htmlspecialchars($product->vendor->vendorName) ?></p>
<p><b>Typ: </b><?=htmlspecialchars($product->category->categoryName) ?></p>
<a href="?c=products&a=edit&product=<?= htmlspecialchars($product->id)?>">Produkt bearbeiten</a>
<br>
<a href="?c=products&a=view&IDForCart=<?= htmlspecialchars($product->id) ?>">In den Wareknkorb</a>
