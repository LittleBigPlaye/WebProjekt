<?php
$currentPosition = $currentPosition ?? '';
$cartCount = isset($_SESSION['shoppingCart']) ? array_sum($_SESSION['shoppingCart']) : '';

//make sure to hide card count, if there is no item inside the cart
if ($cartCount < 1) {
    $cartCount = '';
}
//prevent displaying too long numbers
else if ($cartCount > 99) {
    $cartCount = '+99';
}
?>

<nav>
    <label for="navToggle" id="navToggleLabel">Navigation<span class="dropIcon">&#9776;</span></label>
    <input type="checkbox" id="navToggle">

    <ul class="mainNav clearfix">
        <li <?= ($currentPosition == 'index') ? 'class="active"' : '' ?>><a href="?c=pages&a=index">Startseite</a></li>

        <!-- Products -->
        <li <?= ($currentPosition == 'products') ? 'class="active"' : '' ?>><label for="dropToggle01"><a>Produkte
                    <span class="dropIcon">▾</span>
                    <label title="toggle dropDown" class="dropIcon" for="dropToggle01">▾</label>
                </a>
            </label>
            <input type="checkbox" id="dropToggle01" class="subNavToggle">
            <ul class="subNav">
                <li><a href="index.php?c=products&a=search">Alle Artikel</a></li>
                <li><a href="index.php?c=products&a=vendors">Unsere Marken</a>
                <li><a href="index.php?c=products&a=view&pid=random">Zufälliger Artikel</a></li>
            </ul>
        </li>

        <!-- Login / Logout -->
        <?php if(isset($_SESSION['isLoggedIn']) && ($_SESSION['isLoggedIn'] === true)) : ?>
            <li class="right"><a href="index.php?c=pages&a=logout">Logout</a></li>
        <?php else : ?>
            <li <?= ($currentPosition == 'login') ? 'class="right active"' : 'class="right"' ?>><a
                href="index.php?c=pages&a=login">Login</a></li>
        <?php endif; ?>

        <!-- Administration -->
        <?php if(isset($_SESSION['isLoggedIn']) && ($_SESSION['isLoggedIn'] === true)) : ?>
            <?php if($this->isAdmin()) : ?>
            <li class="<?= ($currentPosition == 'administration') ? 'active ' : '' ?>right"><label for="dropToggle02"><a>Administration
                        <span class="dropIcon">▾</span>
                        <label title="toggle dropDown" class="dropIcon" for="dropToggle02">▾</label>
                    </a>
                </label>
                <input type="checkbox" id="dropToggle02" class="subNavToggle">
                <ul class="subNav">
                    <li><a href="index.php?c=accounts&a=myspace">Mein Konto</a></li>
                    <li><a href="index.php?c=productManagement&a=new">Neues Produkt anlegen</a>
                    <li><a href="index.php?c=accounts&a=adminusermanagement">Benutzer verwalten</a></li>
                </ul>
            </li>
            <?php else : ?>
            <li class="right">
                <a href="index.php?c=accounts&a=myspace">Mein Konto</a>
            </li>
            <?php endif ?>
        <?php endif ?>

        

        <li <?= ($currentPosition == 'shoppingcart') ? 'class="right active"' : 'class="right"' ?>><a
                href="index.php?c=orders&a=shoppingcart">Warenkorb <img src="assets\images\icons\shopping_cart.svg" alt="">
        <?php if(!empty($cartCount)) : ?>
            <span class="cartBadge"><p><?= $cartCount ?></p></span>
        <?php endif ?></a></li>
        
        <li <?= ($currentPosition == 'impressum') ? 'class="right active"' : 'class="right"' ?>><a
        href="index.php?c=pages&a=impressum">Impressum</a></li>
    </ul>
</nav>
<script src="<?=JAVASCRIPTPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'navbar.js'?>"></script>