<?php
/**
 * @author Robin Beck
 */
?>


<h1>Bestehendes Produkt bearbeiten</h1>

<?php if(isset($errorMessage) && $errorMessage !== null) : ?>
    <div class="errorMessage">
        <?= $errorMessage ?>
    </div>
<?php endif ?>

<?php if(isset($product)) : ?>
<form action="index.php?c=products&a=edit&product=<?=$product->id?>" method="post" enctype="multipart/form-data">
    
    <label for="images"></label>
    <input type="file" id="images" name="productImages[]" multiple/>
    <br>

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
    <br>

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

    <br>
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
    <br>

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
    <br>

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
    <br>

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

    <br>
    <label for="isHidden">Produkt "verstecken"?</label>
    <input type="checkbox" id="isHidden" name="isHidden" <?= ($product->isHidden) ? 'checked' : '' ?>/>

    <br>
    <input type="submit" name="submit" value="Änderung speichern"/>
</form>
<?php endif ?>