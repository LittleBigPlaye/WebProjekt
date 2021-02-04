<!-- @author Robin Beck -->

<?php if(isset($product)) : ?>
    <div class="formWrapper">
        <form id="productForm" class="productForm"  method="post" enctype="multipart/form-data">
            <h1>Bestehendes Produkt bearbeiten</h1>
            
            <?php foreach($errorMessages as $key => $message) : ?>
                <input class="messageToggle" type="checkbox" id="errorToggle<?=$key?>">
                <div class="message errorMessage">
                    <label class="messageClose" for="errorToggle<?=$key?>">&times</label>
                    <p><?= htmlspecialchars($message) ?></p>
                </div>
            <?php endforeach; ?>

            <!-- delete or change current images -->
            <?php if($product->images !== null) : ?>
                <label>Bilder bearbeiten</label>
                <div class="imageContainer">
                    <?php foreach($product->images as $productImage) : ?>
                        <img src="
                        <?php
                            if(file_exists($productImage->thumbnailPath))
                            {
                                echo $productImage->thumbnailPath;
                            }
                            else
                            {
                                echo FALLBACK_IMAGE;
                            }
                        ?>
                        "/>
                        <label for="imageName<?=$productImage->id?>" class="optional">Bildtitel</label>
                        <input type="text" placeHolder="Bildtitel" name="imageName<?=$productImage->id?>" id="imageName<?=htmlspecialchars($productImage->id)?>" value="<?=htmlspecialchars($productImage->name)?>">

                        <label for="deleteImage<?=$productImage->id?>">Bild "<?= htmlspecialchars($productImage->name)?>" löschen?
                        <input type="checkbox" id="deleteImage<?=$productImage->id?>" name="deleteImage<?=$productImage->id?>"></label>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Add new images -->
            <div class="input">
                <label for="images" class="optional">Bilder zu Produkt hinzufügen</label>
                <input type="file" id="images" name="productImages[]" multiple accept=".png, .jpg, .jpeg"/>
                <span class="errorInfo">Unterstützte Dateitypen: .jpg, .jpeg, .png<br>Maximale Dateigröße: 3 MB</span>
            </div>

            <div class="input">
                <label for="productName" class="required">Produktbezeichnung</label>
                <input type="text" name="productName" id="productName" placeholder="Bezeichnung eingeben..."
                    value="<?php
                        if(!isset($_POST['productName']) || empty($_POST['productName']))
                        {
                            echo htmlspecialchars($product->productName);
                        }
                        else
                        {
                            echo htmlspecialchars($_POST['productName']);
                        }?>">
                <span class="errorInfo">Bitte geben Sie einen Produktnamen an! (max. 120 Zeichen)</span>
            </div>

            <div class="input">
                <label for="catchPhrase" class="optional">Catchphrase</label>
                <input type="text" name="catchPhrase" id="catchPhrase"
                    value ="<?php
                        if(!isset($_POST['catchPhrase']) || empty($_POST['catchPhrase']))
                        {
                            echo htmlspecialchars($product->catchPhrase);
                        }
                        else
                        {
                            echo htmlspecialchars($_POST['catchPhrase']);
                        }?>">  
                    <span class="errorInfo">Bitte geben Sie maximal 150 Zeichen an!</span>
            </div>

            <div class="input">
                <label for="productDescription" class="required">Produktbeschreibung</label>
                <textarea id="productDescription" name="productDescription"><?php
                        if(!isset($_POST['productDescription']) || empty($_POST['productDescription']))
                        {
                            echo htmlspecialchars($product->productDescription);
                        }
                        else
                        {
                            echo htmlspecialchars($_POST['productDescription']);
                        }?></textarea>
                <span class="errorInfo">Bitte geben Sie eine Beschreibung an! (max. 5000 Zeichen)</span>
            </div>

            <div class="input">
                <label for="productPrice" class="required">Produktpreis</label>
                <input type="number" min="1" step="any" id="productPrice" name="productPrice"
                    value="<?php
                        if(!isset($_POST['productPrice']) || empty($_POST['productPrice']))
                        {
                            echo htmlspecialchars($product->standardPrice);
                        }
                        else
                        {
                            echo htmlspecialchars($_POST['productPrice']);
                        }?>">
                <span class="errorInfo">Bitte geben Sie einen Preis mit maximal zwei Nachkommastellen an!</span>
            </div>

            <div class="input">
                <label for="vendor" class="required">Marke</label>
                <select id="vendor" name="vendor">
                    <?php foreach ($vendors as $vendor) : ?>
                        <option value="<?= $vendor->id ?>" 
                        <?php 
                            if((isset($_POST['vendor']) && $_POST['vendor'] == $vendor->id) || ($product->vendorsID == $vendor->id))
                            {
                                echo ' selected';
                            }
                            
                        ?>
                        ><?= $vendor->vendorName ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="errorInfo">Bitte wählen Sie eine Marke aus!</span>
            </div>

            <div class="input">
                <label for="category" class="required">Kategorie</label>
                <select id="category" name="category">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category->id ?>" 
                            <?php 
                                if((isset($_POST['category']) && $_POST['category'] == $category->id) || ($product->categoriesID == $category->id))
                                {
                                    echo ' selected';
                                }
                            ?>
                        ><?= $category->categoryName ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="errorInfo">Bitte wählen Sie eine Kategorie aus!</span>
            </div>

            <div class="input">
                    <label for="visibility" class="required">Sichtbarkeit</label>
                    <select name="visibility" id="visibility">
                        <option value="visible">Sichtbar</option>
                        <option value="hidden" 
                                <?php
                                    if((isset($_POST['visibility']) && $_POST['visibility'] == 'hidden' || $product->isHidden))
                                    {
                                        echo ' selected';
                                    }
                                ?>
                        >Versteckt</option>
                    </select>
            </div>
            <sup>
                <p>Mit<span class="required"></span> markierte Felder sind Pflichtfelder.</p>
            </sup>
            <input type="submit" id="submitForm" name="submitForm" value="Änderung speichern"/>
        </form>
    </div>
<?php endif; ?>

<script src="<?=JAVASCRIPTPATH . 'productManagement' . DIRECTORY_SEPARATOR . 'validateProduct.js'?>"></script>