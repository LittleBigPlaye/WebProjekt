<h1>
    party all the time
</h1>

<?php foreach ($products as $product):?>

    moin;
    <img src="<?= $product->images[0]->path?>" height="250"/>
    <br>
    <?= $product->productName?>
    <?= $product->standardPrice?>
    <br>

<?php endforeach; ?>