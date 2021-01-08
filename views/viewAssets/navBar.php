<?php
$currentPosition = $currentPosition ?? '';
$cartCount = isset($_SESSION['cartInfos']) ? count($_SESSION['cartInfos']) : '';
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
            <input type="checkbox" id="dropToggle01">
            <ul class="subNav">
                <li><a href="index.php?c=products&a=search">Alle Artikel</a></li>
                <li><a href="#">Kategorien</a>
                <li><a href="index.php?c=products&a=view&pid=random">Zufälliger Artikel</a></li>
            </ul>
        </li>

        <li <?= ($currentPosition == 'impressum') ? 'class="right active"' : 'class="right"' ?>><a
                href="?c=pages&a=impressum">Impressum</a></li>

        <li <?= ($currentPosition == 'shoppingcart') ? 'class="right active"' : 'class="right"' ?>><a
                href="?c=orders&a=shoppingcart">Warenkorb <img src="assets\images\icons\shopping_cart.svg" alt="">
                <?php if(!empty($cartCount)) : ?>
                <span
                class="cartBadge"><p><?= $cartCount ?></p></span>
                <?php endif ?></a></li>
        
        <li <?= ($currentPosition == 'login') ? 'class="right active"' : 'class="right"' ?>><a
                href="?c=pages&a=login">Login</a></li>

        <!-- Administration -->
        <li class="right"><label for="dropToggle02"><a>Administration
                    <span class="dropIcon">▾</span>
                    <label title="toggle dropDown" class="dropIcon" for="dropToggle02">▾</label>
                </a>
            </label>
            <input type="checkbox" id="dropToggle02">
            <ul class="subNav">
                <li><a href="#">Mein Konto</a></li>
                <li><a href="?c=products&a=new">Neues Produkt anlegen</a>
                <li><a href="?c=accounts&a=adminusermanagement">Benutzer verwalten</a></li>
            </ul>
        </li>
    </ul>
</nav>