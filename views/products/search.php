<!-- @author Robin Beck -->

<div class="productBoxWrapper">
    <!-- form for search bar -->
    <div class="formWrapper search">
        <form id="searchForm" class="searchForm" method="Get">
            <input type="hidden" name="c" value="products" />
            <input type="hidden" name="a" value="search" />

            <!-- hidden inputs to preserve get parameters of filter form -->
            <?php foreach ($vendors as $vendor) : ?>
                <?php if (isset($_GET['ven' . $vendor->id])) : ?>
                    <input type="hidden" name="ven<?= $vendor->id ?>" value="<?= $vendor->id ?>" />
                <?php endif; ?>
            <?php endforeach; ?>

            <?php foreach ($categories as $category) : ?>
                <?php if (isset($_GET['cat' . $category->id])) : ?>
                    <input type="hidden" name="cat<?= $category->id ?>" value="<?= $category->id ?>" />
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if (isset($_GET['minPrice'])) : ?>
                <input type="hidden" name="minPrice" value="<?= $_GET['minPrice'] ?>">
            <?php endif; ?>

            <?php if (isset($_GET['maxPrice'])) : ?>
                <input type="hidden" name="maxPrice" value="<?= $_GET['maxPrice'] ?>">
            <?php endif; ?>

            <?php if (isset($_GET['sort'])) : ?>
                <input type="hidden" name="sort" value="<?= $_GET['sort'] ?>">
            <?php endif; ?>

            <?php if (isset($_GET['hidden'])) : ?>
                <input type="hidden" name="hidden" value="<?= $_GET['hidden'] ?>">
            <?php endif; ?>

            <input id="search" name="s" type="search" placeholder="Suchbegriff eingeben..." value="<?= htmlspecialchars($_GET['s'] ?? '') ?>" />
            <button id="searchSubmit" name="submit"><img src="assets/images/icons/search.svg" alt="Suche"></button>
            <!-- <input id="searchSubmit" type="submit" value="S"> -->
        </form>
    </div>

    <!-- form for filters -->
    <div class="formWrapper sideBar">

        <!-- checkbox to toggle visibility of the form in mobile mode -->
        <label for="filterToggle" class="filterToggleLabel">Filter<span class="dropIcon">&#9776;</span></label>
        <input type="checkbox" id="filterToggle" class="filterToggle">

        <form id="filterForm" class="filterForm" method="Get">
            <label class="desktopTitle">Filter</label>
            <input type="hidden" name="c" value="products" />
            <input type="hidden" name="a" value="search" />

            <input id="hiddenSearch" type="hidden" name="s" value="<?= $_GET['s'] ?? '' ?>">

            <fieldset>
                <legend>Marken</legend>
                <?php foreach ($vendors as $vendor) : ?>
                    <label class="checkBoxLabel" for="vendor<?= $vendor->id ?>"><?= $vendor->vendorName ?>
                        <span class="customCheckbox">
                            <input type="checkbox" name="ven<?= $vendor->id ?>" id="vendor<?= $vendor->id ?>" value="<?= $vendor->id ?>" <?= isset($_GET['ven' . $vendor->id]) ? 'checked' : '' ?> />
                            <div><img src="assets/images/icons/tick.svg" alt=""></div>
                        </span>
                    </label>
                <?php endforeach; ?>
            </fieldset>

            <fieldset id="categorySort">
                <legend>Kategorien</legend>
                <?php foreach ($categories as $category) : ?>
                    <label for="category<?= $category->id ?>"><?= $category->categoryName ?>
                        <span class="customCheckbox">
                            <input type="checkbox" name="cat<?= $category->id ?>" id="category<?= $category->id ?>" value="<?= $category->id ?>" <?= isset($_GET['cat' . $category->id]) ? 'checked' : '' ?> />
                            <div><img src="assets/images/icons/tick.svg" alt=""></div>
                        </span>
                    </label>
                <?php endforeach; ?>
            </fieldset>

            <fieldset>
                <legend>Preisspanne</legend>
                <label for="minPrice">Min</label>
                <input type="number" min="1" step="any" id="minPrice" name="minPrice" value="<?= $_GET['minPrice'] ?? '' ?>" />

                <label for="maxPrice">Max</label>
                <input type="number" min="1" step="any" id="maxPrice" name="maxPrice" value="<?= $_GET['maxPrice'] ?? '' ?>" />
            </fieldset>

            <?php if ($this->isAdmin()) : ?>
                <label for="hiddenProducts">Sichtbarkeit</label>
                <select name="hidden" id="hiddenProducts">
                    <option value="all" <?= (isset($_GET['hidden']) && $_GET['hidden'] == 'all') ? 'selected' : '' ?>>Alle Produkte</option>
                    <option value="hidden" <?= (isset($_GET['hidden']) && $_GET['hidden'] == 'hidden') ? 'selected' : '' ?>>Nur versteckte</option>
                    <option value="visible" <?= (isset($_GET['hidden']) && $_GET['hidden'] == 'visible') ? 'selected' : '' ?>>Nur sichtbare</option>
                </select>
            <?php endif; ?>


            <label for="sort">Sortieren</label>
            <select id="sort" name=sort>
                <option value="none" <?= (isset($_GET['sort']) && $_GET['sort'] == 'none')      ? ' selected' : '' ?>>Ohne Sortierung</option>

                <option value="nameASC" <?= (isset($_GET['sort']) && $_GET['sort'] == 'nameASC')   ? ' selected' : '' ?>>Name aufsteigend</option>
                <option value="nameDESC" <?= (isset($_GET['sort']) && $_GET['sort'] == 'nameDESC')  ? ' selected' : '' ?>>Name absteigend</option>

                <option value="priceASC" <?= (isset($_GET['sort']) && $_GET['sort'] == 'priceASC')  ? ' selected' : '' ?>>Preis aufsteigend</option>
                <option value="priceDESC" <?= (isset($_GET['sort']) && $_GET['sort'] == 'priceDESC') ? ' selected' : '' ?>>Preis absteigend</option>

                <option value="dateDESC" <?= (isset($_GET['sort']) && $_GET['sort'] == 'dateDESC')   ? ' selected' : '' ?>>Neueste zuerst</option>
                <option value="dateASC" <?= (isset($_GET['sort']) && $_GET['sort'] == 'dateASC')    ? ' selected' : '' ?>>Älteste zuerst</option>

            </select>

            <input type="submit" value="Filter anwenden">
        </form>
    </div>

    <div class="productContent">
        <?php if (empty($products)) : ?>
            <p class="emptySearch">Für Ihre Suche wurden leider keine Treffer erzielt!</p>
        <?php endif; ?>


        <section id="productsList" class="products">
            <?php foreach ($products as $product) : ?>
                <?php require(VIEWSPATH . DIRECTORY_SEPARATOR . 'viewAssets' . DIRECTORY_SEPARATOR . 'productCard.php') ?>
            <?php endforeach; ?>
        </section>
    </div>

    <!-- pager - only visible, if no javascript is active -->
    <div id="pagesList" class="pagesList">
        <!-- Button to return to first product list -->
        <a href="index.php?<?= $getString ?>&page=<?= 1 ?>">&laquo;</a>

        <!-- Buttons to go to specific product page within range -->
        <?php for ($i = $startIndex - 2; $i <= $startIndex + PRODUCT_LIST_RANGE; $i++) : ?>
            <?php if ($i > 0 && $i <= $numberOfPages) : ?>
                <a href="index.php?<?= $getString ?>&page=<?= $i ?>" <?= ($i == $currentPage) ? 'class="active"' : '' ?>><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <!-- Button to go to last product List -->
        <a href="index.php?<?= $getString ?>&page=<?= $numberOfPages ?>">&raquo;</a>
    </div>

    <!-- load more button - only visible, if javascript is active -->
    <form id="loadMoreForm" class="moreProducts">
        <input type="submit" name="submit" value="Mehr anzeigen">
    </form>
</div>

<script src="<?= JAVASCRIPTPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'addToCart.js' ?>"></script>
<script src="<?= JAVASCRIPTPATH . 'products' . DIRECTORY_SEPARATOR . 'listProducts.js' ?>"></script>

<!-- empty product card to use as prefab for ajax -->
<div class="productCardPrefab" id="productCardPrefab">
    <?php $isPrefab = true ?>
    <?= require(VIEWSPATH . DIRECTORY_SEPARATOR . 'viewAssets' . DIRECTORY_SEPARATOR . 'productCard.php') ?>
</div>