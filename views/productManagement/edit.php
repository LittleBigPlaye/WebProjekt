<?php
/**
 * @author Robin Beck
 */
?>

<?php if(isset($product)) : ?>
<div class="formWrapper">
    <form class="productForm" action="index.php?c=products&a=edit&pid=<?=$product->id?>" method="post" enctype="multipart/form-data">
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
        <label for="images">Bilder zu Produkt hinzufügen</label>
        <input type="file" id="images" name="productImages[]" multiple accept=".png, .jpg, .jpeg"/>

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

        <label for="vendors">Marke</label>
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

        <label for="vendors">Kategorie</label>
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


        <label for="isHidden">Produkt "verstecken"?</label>
        <input type="checkbox" id="isHidden" name="isHidden" <?= ($product->isHidden) ? 'checked' : '' ?>/>


        <input type="submit" name="submit" value="Änderung speichern"/>
    </form>
</div>
<?php endif ?>
<? include (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'upButton.php') ?>
