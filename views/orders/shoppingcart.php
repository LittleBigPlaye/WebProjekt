<h1>
    Sie wollen das wirklich kaufen?
</h1>

<?php foreach ($products as $product):?>

    <img src="<?= $product->images[0]->path?>" height="250"/>
    <br>
    <?= $product->productName?>
    <?= $product->standardPrice?>
    <br>

<?php endforeach; ?>