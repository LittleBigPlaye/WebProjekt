<?php
/**
 * @author Robin Beck
 */
?>

<?php if(isset($product)) : ?>
<div class="formWrapper">
    <form id="productForm" class="productForm"  method="post" enctype="multipart/form-data">
    <h1>Bestehendes Produkt bearbeiten</h1>
        <?php foreach($errorMessages as $message) : ?>
            <div class="errorMessage">
                <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
                <?= $message ?>
            </div>
        <? endforeach; ?>

        <!-- delete or change current images -->
        <?php foreach($product->images as $productImage) : ?>
            <img src="
            <?php
                if(file_exists($productImage->path))
                {
                    echo $productImage->path;
                }
                else
                {
                    echo FALLBACK_IMAGE;
                }
            ?>
            " width="400px"/><br>
            <label for="imageName<?=$productImage->id?>">Bildtitel</label>
            <input type="input" placeHolder="Bildtitel" name="imageName<?=$productImage->id?>" id="imageName<?=$productImage->id?>" value="<?=$productImage->name?>">

            <label for="deleteImage<?=$productImage->id?>">Bild "<?= $productImage->name?>" löschen?
            <input type="checkbox" id="deleteImage<?=$productImage->id?>" name="deleteImage<?=$productImage->id?>"></label>
        <?php endforeach ?>

        <!-- Add new images -->
        <div class="input">
            <label for="images">Bilder zu Produkt hinzufügen</label>
            <input type="file" id="images" name="productImages[]" multiple accept=".png, .jpg, .jpeg"/>
            <span class="errorInfo">Unterstützte Dateitypen: .jpg, .jpeg, .png<br>Maximale Dateigröße: 3 MB</span>
        </div>

        <div class="input">
            <label for="productName">Produktbezeichnung</label>
            <input type="text" name="productName" id="productName" placeholder="Bezeichnung eingeben..."
                value="<?php
                    if(!isset($_POST['productName']) || empty($_POST['productName']))
                    {
                        echo $product->productName;
                    }
                    else
                    {
                        echo $_POST['productName'];
                    }?>">
            <span class="errorInfo">Bitte geben Sie einen Produktnamen an!</span>
        </div>

        <div class="input">
            <label for="catchPhrase">Catchphrase</label>
            <input type="text" name="catchPhrase" id="catchPhrase"
                value ="<?php
                    if(!isset($_POST['catchPhrase']) || empty($_POST['catchPhrase']))
                    {
                        echo $product->catchPhrase;
                    }
                    else
                    {
                        echo $_POST['catchPhrase'];
                    }?>">  
        </div>

        <div class="input">
            <label for="productDescription">Produktbeschreibung</label>
            <textarea id="productDescription" name="productDescription"><?php
                    if(!isset($_POST['productDescription']) || empty($_POST['productDescription']))
                    {
                        echo $product->productDescription;
                    }
                    else
                    {
                        echo $_POST['productDescription'];
                    }?></textarea>
            <span class="errorInfo">Bitte geben Sie eine Beschreibung an!</span>
        </div>

        <div class="input">
            <label for="productPrice">Produktpreis</label>
            <input type="number" min="1" step="any" id="productPrice" name="productPrice"
                value="<?php
                    if(!isset($_POST['productPrice']) || empty($_POST['productPrice']))
                    {
                        echo $product->standardPrice;
                    }
                    else
                    {
                        echo $_POST['productPrice'];
                    }?>">
            <span class="errorInfo">Bitte geben Sie einen Preis mit maximal zwei Nachkommastellen an!</span>
        </div>

        <div class="input">
            <label for="vendor">Marke</label>
            <select id="vendor" name="vendor">
                <?php foreach ($vendors as $vendor) : ?>
                    <option value="<?= $vendor->id ?>" 
                    <?php 
                        if((isset($_POST['vendor']) && $_POST['vendor'] == $vendor->id) || ($product->vendorID == $vendor->id))
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
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category->id ?>" 
                        <?php 
                            if((isset($_POST['category']) && $_POST['category'] == $category->id) || ($product->categoryID == $category->id))
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
            <label for="isHidden">Produkt "verstecken"?</label>
            <input type="checkbox" id="isHidden" name="isHidden" <?= ($product->isHidden) ? 'checked' : '' ?>/>
        </div>

        <input type="submit" id="submit" name="submit" value="Änderung speichern"/>
    </form>
</div>
<?php endif; ?>
<? include (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'upButton.php') ?>
<script src="<?=JAVASCRIPTPATH . 'productManagement' . DIRECTORY_SEPARATOR . 'validateProduct.js'?>"></script>
