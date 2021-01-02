<?php
/**
 * @author Robin Beck
 */
?>

<div class="formWrapper">
    <form class="productForm" action="index.php?c=products&a=new" method="post" enctype="multipart/form-data">

        <h1>Neues Produkt anlegen</h1>

        <?php if(isset($errorMessage) && !empty($errorMessage)) : ?>
            <div class="errorMessage">
                <span class="messageClose" onclick="this.parentElement.style.display='none';">&times</span>
                <p><?= $errorMessage ?></p>
            </div>
        <?php endif ?>


        <label for="images">Produktbilder</label>
        <input type="file" id="images" name="productImages[]" multiple/>
        <br>

        <label for="productName">Produktbezeichnung</label>
        <input type="text" name="productName" id="productName" placeholder="Hier Bezeichnung eingeben..."
            value="<?= $_POST['productName'] ?? '' ?>"/>
        <br>

        <label for="catchPhrase">Catchphrase</label>
        <input type="text" name="catchPhrase" id="catchPhrase" placeholder="Hier Catchphrase eingeben..."
            value ="<?= $_POST['catchPhrase'] ?? '' ?>"/>
    

        <br>
        <label for="productDescription">Produktbeschreibung</label>
        <textarea id="productDescription" name="productDescription" rows="10"><?= $_POST['productDescription'] ?? '' ?></textarea>
        <br>

        <label for="productPrice">Produktpreis</label>
        <input type="number" min="1" step="any" id="productPrice" name="productPrice"
            value="<?= $_POST['productPrice'] ?? '' ?>"/>
        <br>

        <label for="vendors">Marke</label>
        <select id="vendor" name="vendor">
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
        <br>

        <label for="vendors">Kategorie</label>
        <select id="category" name="category">
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
        <br>
        <label for="isHidden">Produkt "versteckt" anlegen?</label>
        <input type="checkbox" id="isHidden" name="isHidden"/>
        

        <br>
        <input type="submit" name="submit" value="Produkt anlegen"/>
    </form>
</div>