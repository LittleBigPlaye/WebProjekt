<h1>Produkte</h1>

<?php
if (isset($products) === false) 
{
    echo 'Es wurden keine Produkte gefunden';
}
?>

<?php foreach ($products as $product) : ?>
    <div class="productTile">
    <img src="
    <?php
        if($product->images != NULL && file_exists($product->images[0]->path))
        {
            echo $product->images[0]->path;
        }
        else
        {
            echo FALLBACK_IMAGE;
        }
    ?>" width="150px">
    <br>
    
    <b><?= $product->productName ?></b><br>
        <?= $product->catchPhrase ?><br>
        <a href="?c=products&a=viewProduct&prod=<?= $product->id ?>">Anzeigen</a><br>
        
    </div>
<?php endforeach ?>