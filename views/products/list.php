<?php
/**
 * @author Robin Beck
 */
?>

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
                <a href="?c=products&a=view&prod=<?= $product->id ?>">Anzeigen</a>
        </div>
    </div>
<?php endforeach ?>


<br>
    <!-- Button to return to previoud product list -->
    <?php if($currentPage > 1) :?>
        <a href="?c=products&a=list&page=<?=$currentPage-1?>"><</a>
    <?php endif ?>
    
    <!-- Buttons to go to specific product page within range -->
    
    <?php for($i = $startIndex-2; $i < $startIndex+PRODUCT_LIST_RANGE; $i++) : ?>
        <?php if($i > 0 && $i < $numberOfPages) : ?>
            <a href="?c=products&a=list&page=<?=$i?>"><?=$i?></a>
        <? endif ?>
    <? endfor ?>


    <!-- Button to go to next product List -->
    <?php if($currentPage < $numberOfPages) : ?>
        <a href="?c=products&a=list&page=<?=$currentPage+1?>">></a>
    <?php endif ?>
</section>