<?php
/**
 * @author Robin Beck
 */
?>

<div class="formWrapper">
    <form id="productForm" class="productForm new" method="post" enctype="multipart/form-data">

        <h1>Neues Produkt anlegen</h1>

        <?php foreach($errorMessages as $message) : ?>
            <div class="errorMessage">
                <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
                <?= $message ?>
            </div>
        <? endforeach; ?>


        <div class="input">
            <label for="images">Produktbilder</label>
            <input type="file" id="images" name="productImages[]" multiple accept=".png, .jpg, .jpeg"/>
            <span class="errorInfo">Bitte mindestens 1 Bild auswählen.<br>Unterstützte Dateitypen: .jpg, .jpeg, .png<br>Maximale Dateigröße: 3 MB</span>
        </div>

        <div class="input">
            <label for="productName">Produktbezeichnung</label>
            <input type="text" name="productName" id="productName" placeholder="Hier Bezeichnung eingeben..."
                value="<?= $_POST['productName'] ?? '' ?>"/>
            <span class="errorInfo">Bitte geben Sie einen Produktnamen an!</span>
        </div>

        <div class="input">
        <label for="catchPhrase">Catchphrase</label>
        <input type="text" name="catchPhrase" id="catchPhrase" placeholder="Hier Catchphrase eingeben..."
            value ="<?= $_POST['catchPhrase'] ?? '' ?>"/>
        </div>
    

        <div class="input">
            <label for="productDescription">Produktbeschreibung</label>
            <textarea id="productDescription" name="productDescription" rows="10"><?= $_POST['productDescription'] ?? '' ?></textarea>
            <span class="errorInfo">Bitte geben Sie eine Beschreibung an!</span>
        </div>

        <div class="input">
            <label for="productPrice">Produktpreis</label>
            <input type="number" min="0" step="0.01" id="productPrice" name="productPrice"
                value="<?= $_POST['productPrice'] ?? '' ?>"/>
            <span class="errorInfo">Bitte geben Sie einen Preis mit maximal zwei Nachkommastellen an!</span>
        </div>

        <div class="input">
            <label for="vendors">Marke</label>
            <select id="vendor" name="vendor">
                <option value="-1" <?= !isset($_POST['vendor']) ? 'selected' : ''?>  hidden="hidden" >Marke auswählen</option>
                <?php foreach ($vendors as $vendor) : ?>
                    <option value="<?= $vendor->id ?>" 
                    <?php 
                        if(isset($_POST['vendor']) && $_POST['vendor'] == $vendor->id)
                        {
                            echo ' selected';
                        }
                    ?>
                    ><?= $vendor->vendorName ?></option>
                <?php endforeach ?>
            </select>
            <span class="errorInfo">Bitte wählen Sie eine Marke aus!</span>
        </div>

        <div class="input">
            <label for="category">Kategorie</label>
            <select id="category" name="category">
                <option value="-1" <?= !isset($_POST['category']) ? 'selected' : ''?>  hidden="hidden" >Kategorie auswählen</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category->id ?>" 
                        <?php 
                            if(isset($_POST['category']) && $_POST['category'] == $category->id)
                            {
                                echo ' selected';
                            }
                        ?>
                    ><?= $category->categoryName ?></option>
                <?php endforeach ?>
            </select>
            <span class="errorInfo">Bitte wählen Sie eine Kategorie aus!</span>
        </div>

        <div class="input">
            <label for="isHidden">Produkt "versteckt" anlegen?
            <input type="checkbox" id="isHidden" name="isHidden"/></label>  
        </div>      

        <input id="submit" type="submit" name="submit" value="Produkt anlegen"/>
    </form>
</div>
<? include (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'upButton.php') ?>
<script src="<?=JAVASCRIPTPATH . 'productManagement' . DIRECTORY_SEPARATOR . 'validateProduct.js'?>"></script>