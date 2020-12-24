<h1>Produkte</h1>

<?php
if (isset($products) === false) 
{
    echo 'Es wurden keine Produkte gefunden';
}
?>

            
<section class="cards"> 
<?php foreach ($products as $product) : ?>
    <div class="card">
        <div class="container">
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
            ?>" width="400px">
            <br>
            
            <b><?= $product->productName ?></b><br>
                <i><?= $product->catchPhrase ?><br></i>
                <a href="?c=products&a=viewProduct&prod=<?= $product->id ?>">Anzeigen</a>
        </div>
    </div>
<?php endforeach ?>


<br>
    
    <?php if($currentPage > 1) :?>
    <a href="?c=products&a=listProducts&page=<?=$currentPage-1?>"><</a>
    <?php endif ?>
    
    <?php if($currentPage < $numberOfPages) : ?>
    <a href="?c=products&a=listProducts&page=<?=$currentPage+1?>">></a>
    <?php endif ?>
    </section>