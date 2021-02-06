<?php

use myf\core\Controller;

$currentPosition = $currentPosition ?? '';
$cartCount = $this->getNumberOfCartItems();

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
        <li class="<?= ($currentPosition == Controller::POSITION_INDEX) ? 'active' : '' ?> homePage"><a href="?c=pages&a=index">
                <span>Startseite</span>
                <img class="smallLogo" src="assets/images/icons/myf_logo_scmall.svg" alt="Startseite">
            </a></li>

        <!-- Products -->
        <li <?= ($currentPosition == Controller::POSITION_PRODUCTS) ? 'class="active"' : '' ?>><label class="subNavTitle" for="dropToggle01"><a>Produkte
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
        <?php if ($this->isLoggedIn()) : ?>
            <li class="right"><a href="index.php?c=pages&a=logout">Logout</a></li>
        <?php else : ?>
            <li <?= ($currentPosition == Controller::POSITION_LOGIN) ? 'class="right active"' : 'class="right"' ?>><a href="index.php?c=pages&a=login">Login</a></li>
        <?php endif; ?>

        <!-- Administration -->
        <?php if ($this->isLoggedIn()) : ?>
            <?php if ($this->isAdmin()) : ?>
                <li class="<?= ($currentPosition == Controller::POSITION_ADMINISTRATION) ? 'active ' : '' ?>right"><label class="subNavTitle" for="dropToggle02"><a>Administration
                            <span class="dropIcon">▾</span>
                            <label title="toggle dropDown" class="dropIcon" for="dropToggle02">▾</label>
                        </a>
                    </label>
                    <input type="checkbox" id="dropToggle02" class="subNavToggle">
                    <ul class="subNav">
                        <li><a href="index.php?c=accounts&a=myspace">Mein Konto</a></li>
                        <li><a href="index.php?c=productManagement&a=new">Produkt anlegen</a>
                        <li><a href="index.php?c=accounts&a=adminusermanagement">Benutzer verwalten</a></li>
                    </ul>
                </li>
            <?php else : ?>
                <li class="<?= ($currentPosition == Controller::POSITION_ADMINISTRATION) ? 'active ' : '' ?>right">
                    <a href="index.php?c=accounts&a=myspace">Mein Konto</a>
                </li>
            <?php endif; ?>
        <?php endif; ?>



        <li <?= ($currentPosition == Controller::POSITION_CART) ? 'class="right active"' : 'class="right"' ?>>
            <a href="index.php?c=orders&a=shoppingcart">Warenkorb <img src="assets/images/icons/shopping_cart.svg" alt="">
                <span class="cartBadge <?= empty($cartCount) ? 'hidden' : '' ?>" id="cartBadge">
                    <p id="cartBadgeText"><?= $cartCount ?></p>
                </span>
            </a>
        </li>
    </ul>
</nav>
<script src="<?= JAVASCRIPTPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'navbar.js' ?>"></script>