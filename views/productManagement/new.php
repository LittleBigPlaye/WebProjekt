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
            <label for="images" class="required">Produktbilder</label>
            <input type="file" id="images" name="productImages[]" multiple accept=".png, .jpg, .jpeg" required/>
            <span class="errorInfo">Bitte mindestens 1 Bild auswählen.<br>Unterstützte Dateitypen: .jpg, .jpeg, .png<br>Maximale Dateigröße: 3 MB</span>
        </div>

        <div class="input">
            <label for="productName" class="required">Produktbezeichnung</label>
            <input type="text" name="productName" id="productName" maxlength="120" placeholder="Hier Bezeichnung eingeben..."
                value="<?= $_POST['productName'] ?? '' ?>" required/>
            <span class="errorInfo">Bitte geben Sie einen Produktnamen an! (max. 120 Zeichen)</span>
        </div>

        <div class="input">
            <label for="catchPhrase" class="optional">Catchphrase</label>
            <input type="text" name="catchPhrase" id="catchPhrase" maxlength="150" placeholder="Hier Catchphrase eingeben..."
                value ="<?= $_POST['catchPhrase'] ?? '' ?>"/>
            <span class="errorInfo">Bitte geben Sie maximal 150 Zeichen an!</span>
        </div>
    

        <div class="input">
            <label for="productDescription" class="required">Produktbeschreibung</label>
            <textarea id="productDescription" name="productDescription" rows="10" maxlength="5000"><?= $_POST['productDescription'] ?? '' ?></textarea>
            <span class="errorInfo">Bitte geben Sie eine Beschreibung an! (max. 5000 Zeichen)</span>
        </div>

        <div class="input">
            <label for="productPrice" class="required">Produktpreis</label>
            <input type="number" max="99999.99" min="0" step="0.01" id="productPrice" name="productPrice" required
                value="<?= $_POST['productPrice'] ?? '' ?>"/>
            <span class="errorInfo">Bitte geben Sie einen Preis mit maximal zwei Nachkommastellen an!</span>
        </div>

        <div class="input">
            <label for="vendors" class="required">Marke</label>
            <select id="vendor" name="vendor" required>
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
            <label for="category" class="required"> Kategorie</label>
            <select id="category" name="category" required>
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
                <label for="visibility" class="required">Sichtbarkeit</label>
                <select name="visibility" id="visibility">
                    <option value="visible">Sichtbar</option>
                    <option value="hidden">Versteckt</option>
                </select>
        </div>

        <sup>
            <p>Mit<span class="required"></span> markierte Felder sind Pflichtfelder.</p>
        </sup>
        <input id="submit" type="submit" name="submit" value="Produkt anlegen"/>
    </form>
</div>
<script src="<?=JAVASCRIPTPATH . 'productManagement' . DIRECTORY_SEPARATOR . 'validateProduct.js'?>"></script>