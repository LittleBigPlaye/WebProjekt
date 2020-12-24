<?php
/**
 * @author Robin Beck
 */
?>

<h1><?= $product->productName ?></h1>
<img src=
<?php
    echo '"';
    if($product->images != null)
    {
        foreach($product->images as $image)
        {
            
            if(file_exists($image->path))
            {
                echo $image->path;
            }
            else
            {
                echo FALLBACK_IMAGE;
            }
        }
    }
    else
    {
        echo FALLBACK_IMAGE;
    }
    echo '"';
?> width="250px">

<p><?=$product->catchPhrase ?></p>
<p><?=$product->productDescription ?></p>
<p><b>Preis:</b> <?=$product->standardPrice?></p>
<p><b>Marke: </b><?=$product->vendor->vendorName ?></p>
<p><b>Typ: </b><?=$product->category->categoryName ?></p>
<a href="?c=products&a=editProduct&product=<?= $product->id?>">Produkt bearbeiten</a>