<div class="topNavBackground">
    <nav class="topNavigation" id="myTopNavigation">
        <a <?=( $currentPosition=='index' ) ? 'class="active"' : '' ?> href="index.php">Startseite</a>
        <div class="dropdown">
            <button class="dropdownButton">Produkte ...</button>
            <div class="dropdownContent">
                <a href="#specialOffers">Angebote</a>
                <a href="#categories">Kategorien</a>
                <a href="#search">Suche</a>
            </div>
        </div>

        <a <?=( $currentPosition=='impressum' ) ? 'class="right active"' : 'class="right"' ?> class="right" href="index.php?c=pages&a=impressum">Impressum</a>

        <a class="icon" onclick="showNavBar()">&#9776;</a>
        <a class="right" href="#login">LogIn</a>
        <a class="right" href="#cart">Warenkorb</a>
        <div class="dropdown right">
            <button class="dropdownButton">Administration ...</button>
            <div class="dropdownContent">
                <a href="#specialOffers">Meine Daten</a>
                <a href="#categories">Nutzer verwalten</a>
                <a href="#search">Produkte verwalten</a>
            </div>
        </div>
        <script src="./assets/javascript/navbar.js"></script>
    </nav>
</div>