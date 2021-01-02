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
<?php  ?>
            
<section class="cards"> 
<?php foreach ($products as $product) : ?>
    <div class="card">
        <div class="container">
        <img src="
            <?php
                if($product->images != NULL && file_exists($product->images[0]->path))
                {
                    echo htmlspecialchars($product->images[0]->path);
                }
                else
                {
                    echo FALLBACK_IMAGE;
                }
            ?>" width="400px">
            <br>
            
            <i><?= $product->isHidden ? '[unsichtbar]' : ''?></i><br>
            <b><?= htmlspecialchars($product->productName) ?></b><br>
            <i><?= htmlspecialchars($product->catchPhrase) ?><br></i>
            <b><?= htmlspecialchars($product->standardPrice . ' €')?></b><br>
                <a href="?c=products&a=view&prod=<?= htmlspecialchars($product->id) ?>">Anzeigen</a>
            <br>
                <a href="?c=products&a=list&IDForCart=<?= htmlspecialchars($product->id) ?>">In den Wareknkorb</a>
        </div>
    </div>
<?php endforeach ?>
</section>

<br>
<?=$numberOfPages?>
<div class="pagesList">
    <!-- Button to return to previoud product list -->
    <?php if($currentPage > 1) :?>
        <a href="index.php?c=products&a=list&page=<?=$currentPage-1?>">&laquo;</a>
    <?php endif ?>
    
    <!-- Buttons to go to specific product page within range -->
    
    <?php for($i = $startIndex-2; $i <= $startIndex+PRODUCT_LIST_RANGE; $i++) : ?>
        <?php if($i > 0 && $i <= $numberOfPages) : ?>
            <a href="index.php?c=products&a=list&page=<?=$i?>" <?= ($i == $currentPage) ? 'class="active"' : ''?>><?=$i?></a>
        <? endif ?>
    <? endfor ?>


    <!-- Button to go to next product List -->
    <?php if($currentPage < $numberOfPages) : ?>
        <a href="index.php?c=products&a=list&page=<?=$currentPage+1?>">&raquo;</a>
    <?php endif ?>
</div>
