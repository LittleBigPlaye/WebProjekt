<?php
    $products = $products ?? array();
    $categories = $categories ?? array();
    $vendors = $vendors ?? array();
?>


<form action="index.php?c=products&a=search" method="Get">
    
    <input type="hidden" name="c" value="products" />
    <input type="hidden" name="a" value="search" />

    <input id="s" name="s" type="search" placeholder="Suchbegriff eingeben..." value="<?= htmlspecialchars($_GET['s'] ?? '')?>"/><br>

    <label for="vendorSort">Nach Marke filtern</label>
    <fieldset id="vendorSort">
            <?php foreach($vendors as $vendor) : ?>
                <label for="vendor<?=$vendor->id?>"><?= $vendor->vendorName ?></label>
                <input type="checkbox" name="v<?=$vendor->id?>" id="vendor<?=$vendor->id?>" value="<?=$vendor->id?>" <?=isset($_GET['v' . $vendor->id]) ? 'checked' : ''?>/>
            <?php endforeach ?>
    </fieldset>

    </fieldset>
        <label for="categorySort">Nach Kategorie filtern</label>
        <fieldset id="categorySort">
            <?php foreach($categories as $category) : ?>
                <label for="category<?=$category->id?>"><?= $category->categoryName ?></label>
                <input type="checkbox" name="c<?=$category->id?>" id="category<?=$category->id?>" value="<?=$category->id?>" <?=isset($_GET['c' . $category->id]) ? 'checked' : ''?>/>
            <?php endforeach ?>
    </fieldset>

    

    <p>Preisspanne festlegen</p>
    <label for="minPrice">Min</label>
    <input type="number" min="1" step="any" id="minPrice" name="minPrice"
        value="<?= $_GET['minPrice'] ?? '' ?>"/>
        <label for="minPrice">Max</label>
    <input type="number" min="1" step="any" id="maxPrice" name="maxPrice"
        value="<?= $_GET['maxPrice'] ?? '' ?>"/>
    <br>



    <label for="sort"></label>
    <select id="sort" name=sort>
        <option value="none"      <?= (isset($_GET['sort']) && $_GET['sort'] == 'none') ? ' selected' : ''?>>Ohne Sortierung</option>

        <option value="nameASC"   <?= (isset($_GET['sort']) && $_GET['sort'] == 'nameASC') ? ' selected' : ''?>>Name aufsteigend</option>
        <option value="nameDESC"  <?= (isset($_GET['sort']) && $_GET['sort'] == 'nameDESC') ? ' selected' : ''?>>Name absteigend</option>

        <option value="priceASC"  <?= (isset($_GET['sort']) && $_GET['sort'] == 'priceASC') ? ' selected' : ''?>>Preis aufsteigend</option>
        <option value="priceDESC" <?= (isset($_GET['sort']) && $_GET['sort'] == 'priceDESC') ? ' selected' : ''?>>Preis absteigend</option>

        <option value="dateDESC" <?= (isset($_GET['sort']) && $_GET['sort'] == 'dateDESC') ? ' selected' : ''?>>Neueste zuerst</option>
        <option value="dateASC" <?= (isset($_GET['sort']) && $_GET['sort'] == 'dateASC') ? ' selected' : ''?>>Älteste zuerst</option>
    </select>
    <br>

    <button type="submit"><i>Suchen</i></button>
</form>

<?php if(empty($products)) :?>
    Für Ihre Suche wurden leider keine Treffer erzielt!
<?php endif ?>

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
        </div>
    </div>
<?php endforeach ?>
</section>

<br>
<?=$numberOfPages?>
<div class="pagesList">
    <!-- Button to return to previoud product list -->
    <?php if($currentPage > 1) :?>
        <a href="index.php?<?=$getString?>&page=<?=$currentPage-1?>">&laquo;</a>
    <?php endif ?>
    
    <!-- Buttons to go to specific product page within range -->
    
    <?php for($i = $startIndex-2; $i <= $startIndex+PRODUCT_LIST_RANGE; $i++) : ?>
        <?php if($i > 0 && $i <= $numberOfPages) : ?>
            <a href="index.php?<?=$getString?>&page=<?=$i?>" <?= ($i == $currentPage) ? 'class="active"' : ''?>><?=$i?></a>
        <? endif ?>
    <? endfor ?>

    <!-- Button to go to next product List -->
    <?php if($currentPage < $numberOfPages) : ?>
        <a href="index.php?<?=$getString?>&page=<?=$currentPage+1?>">&raquo;</a>
    <?php endif ?>
</div>