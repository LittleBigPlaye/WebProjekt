<?php
/**
 * @author Robin Beck
 */
?>

<h1>Produkte</h1>

<?php
if (!isset($products) || count($products) === 0) 
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
            <ul>
                <li>
                    <a href="?c=products&a=view&pid=<?= htmlspecialchars($product->id) ?>">Anzeigen</a>

                    <a href="?c=products&a=list&IDForCart=<?= htmlspecialchars($product->id) ?>">
                        <img src="assets/images/AddCartButton.png" alt="Zum Warenkorb hinzufügen" width="35px"/>
                    </a>
                </li>
            </ul>
        </div>
    </div>
<?php endforeach ?>
</section>

<br>
<div class="pagesList">
        <a href="index.php?c=products&a=list&page=1">&laquo;</a>

    
    <!-- Buttons to go to specific product page within range -->
    
    <?php for($i = $startIndex-2; $i <= $startIndex+PRODUCT_LIST_RANGE; $i++) : ?>
        <?php if($i > 0 && $i <= $numberOfPages) : ?>
            <a href="index.php?c=products&a=list&page=<?=$i?>" <?= ($i == $currentPage) ? 'class="active"' : ''?>><?=$i?></a>
        <? endif ?>
    <? endfor ?>


    <!-- Button to go to next product List -->
        <a href="index.php?c=products&a=list&page=<?=$numberOfPages?>">&raquo;</a>
</div>
