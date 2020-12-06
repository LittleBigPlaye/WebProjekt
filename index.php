<?php $numberOfSlides = 4 ?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>MaskYourFace</title>
    <link rel="stylesheet" href="./assets/styles/main.css">
    <link rel="stylesheet" href="./assets/styles/slide_show.css" />
</head>
<body>
<header>
    <?include ("./views/header.php");?>
</header>
<section>
   <div>
       <?include ("./views/nav_bar.php");?>
   </div>


<div>
    <h2>Unsere Dauerbrenner - Die halten alles auf!</h2>
</div>
        <div>
            <!-- Product Spotlight -->
            
            <?php include './views/product_spotlight.php' ?>
        </div>

</section>
<section class="cards">
    <div>
        <div>
            <h2>Masken, Masken, Masken</h2>
            <p>
                Unsere Masken sind ein bewertes Produkt, was Milliarden Kindern Arbeit liefert. <br>
                Nur Kinderhände sind in der Lage so feine Lagen zu legen und solch zierliche Stiche zu setzen
            </p>
            <br>
        </div>
        <div class="card">
            <div class="container">
            <img src="./assets/images/masks/mask01.png" width="400">
                <a href="">Maske 1</a>
            </div>
        </div>
        <div class="card">
            <div class="container">
            <img src="./assets/images/masks/mask01.png" width="400">
                <a href="">Maske 2</a>
            </div>
        </div>
        <div class="card">
            <div class="container">
            <img src="./assets/images/masks/mask01.png" width="400">
                <a href="">Maske 3</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="container">
        <img src="./assets/images/masks/mask01.png" width="400">
            M<a href="">Maske 4</a>
        </div>
    </div>
    <div class="card">
        <div class="container">
        <img src="./assets/images/masks/mask01.png" width="400">
            <a href="">Maske 5</a>
        </div>
    </div>
    <div class="card">
        <div class="container">
        <img src="./assets/images/masks/mask01.png" width="400">
            <a href="">Maske 6</a>
        </div>
    </div>
    </div>



</section>
<br>
<section class="cards">

    <div>
        <h2>Schöner können Sie ihr Gesicht nicht verstecken. Die Götter wissen, dass sie es brauchen</h2>
    </div>
    <p>
        Unsere geklauten Motive werden ihr Leben bereichern <br>
        Mit unseren Masken wird es Ihnen so unendlich leicht gemacht Ihre menschenverachtenden Gesichtszüge zu verdecken.
        Nutzen Sie diese Möglichkeit!!!!
    </p>
    <br>
    </div>
    <div class="card">
        <div class="container">
        <img src="./assets/images/masks/mask01.png" width="400">
            <a href="">Maske 7</a>
        </div>
    </div>
    <div class="card">
        <div class="container">
        <img src="./assets/images/masks/mask01.png" width="400">
            <a href="">Maske 8</a>
        </div>
    </div>
    <div class="card">
        <div class="container">
        <img src="./assets/images/masks/mask01.png" width="400">
            <a href="">Maske 9</a>
        </div>
    </div>
    </div>
    <div class="card">
        <div class="container">
        <img src="./assets/images/masks/mask01.png" width="400">
            M<a href="">Maske 10</a>
        </div>
    </div>
    <div class="card">
        <div class="container">
        <img src="./assets/images/masks/mask01.png" width="400">
            <a href="">Maske 12</a>
        </div>
    </div>
    <div class="card">
        <div class="container">
        <img src="./assets/images/masks/mask01.png" width="400">
            <a href="">Maske 13</a>
        </div>

</section>

<footer>
    <div class="footer">
    <?include ("./views/footer.php");?>
    </div>
</footer>

    <? include ("./views/up_button.php") ?>
</body>
</html>