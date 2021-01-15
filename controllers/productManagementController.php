<?php
/**
 * @author Robin Beck
 */

namespace myf\controller;

use myf\models\Login;

class ProductManagementController extends \myf\core\controller
{
    public function actionNew()
    {
       $this->setParam('currentPosition', 'administration');
       $errorMessages = [];
       if(!$this->isLoggedIn())
       {
            header('Location: index.php?c=pages&a=login');
       }

       if(!$this->isAdmin())
       {
            header('Location: index.php?c=errors&a=403');
       }
       
       
        //obtain vendors from database
        $this->setParam('vendors', \myf\models\Vendor::find());

        //obtain categories from database
        $this->setParam('categories', \myf\models\Category::find());

        //check, if form has been submitted
        if(isset($_POST['submit']))
        {
            //get inputs from form
            $name        = $_POST['productName'] ?? '';
            $catchPhrase = $_POST['catchPhrase'] ?? '';
            $description = $_POST['productDescription'] ?? '';
            $price       = $_POST['productPrice'] ?? '';
            $vendor      = $_POST['vendor'] ?? '';
            $category    = $_POST['category'] ?? '';
            $isHidden    = isset($_POST['isHidden']);

            $db = $GLOBALS['database'];

            //check if name exists
            if(empty($name))
            {
                $errorMessages['productName'] = 'Es muss ein Produktname angegeben werden.';
            }

            //check if description exists
            if(empty($description))
            {
                $errorMessages['description'] = 'Geben Sie eine Produktbezeichnung an.';
            }

            //check if price is valid
            if(!\myf\core\validateNumberInput($price, 2))
            {
                $errorMessages['price'] = 'Geben Sie einen Preis größer 0 € und mit maximal zwei Nachkommastellen an.';
            }

            //check if vendor exists
            if(empty($vendor) || \myf\models\Vendor::findOne('id=' . $db->quote($vendor)) == null)
            {
                $errorMessages['vendor'] = 'Wählen Sie eine gültige Marke aus.';
            }

            //check if category exists
            if(empty($category) || \myf\models\Category::findOne('id=' . $db->quote($category)) == null)
            {
                $errorMessages['category'] = 'Wählen Sie eine gültige Kategorie aus.';
            }

            //check if productname is not new
            if(!empty($name) && \myf\models\Product::findOne('productName LIKE ' . $db->quote($name)) !== null)
            {
                $errorMessages['productFound'] = 'Es existiert bereits ein Produkt mit dem von Ihnen gewünschten Namen!';
            }

            //check if there is at least one picture selected
            $fileNames = array_filter($_FILES['productImages']['name']);
            if(count($fileNames) == 0)
            {
                $errorMessages['noImages'] = 'Wählen Sie mindestens ein Bild zum Upload aus!';
            }
            //validate the images
            else
            {
                $this->validateImages('productImages', $errorMessages);
            }                

            if(count($errorMessages) === 0)
            {
                //build new product
                $product = new \myf\models\Product(array());
                $product->productName        = $name;
                $product->catchPhrase        = $catchPhrase;
                $product->productDescription = $description;
                $product->vendorID           = $vendor;
                $product->categoryID         = $category;
                $product->standardPrice      = $price;
                $product->isHidden           = $isHidden;

                //add images
                $this->addImagesToProduct($product, 'productImages');

                //insert product into database
                $product->save();
                //save success message to session to display in on product view
                $_SESSION['productSuccess'] = 'Das Produkt "' . $name . '" wurde ergolgreich angelegt!';

                $this->updateLastActiveTime();
                //redirect to product page
                header('Location: ?c=products&a=view&pid=' . $product->id);
            }
        }
        $this->setParam('errorMessages', $errorMessages);
   }

    
    public function actionEdit()
   {
       $this->setParam('currentPosition', 'products');
       $errorMessages = [];
       
       //check if the user is logged in
       if(!$this->isLoggedIn())
       {
        header('Location: index.php?c=pages&a=login');
       }
       
       //check if the logged in user is admin
       if(!$this->isAdmin())
       {
           header('Location: index.php?c=errors&a=403');
       }

       //check if product exists
       $productID = $_GET['pid'] ?? null;
       $product = null;

       //check if the product that has to be edited exists
       if($productID == null || !is_numeric($productID) || \myf\models\Product::findOne('id=' . $productID) == null)
       {
           header('Location: index.php?c=errors&a=404');
       }

       $product = \myf\models\Product::findOne('id=' . $productID);

       //obtain vendors from database
       $this->setParam('vendors', \myf\models\Vendor::find());
       
       //obtain categories from database
       $this->setParam('categories', \myf\models\Category::find());
       $this->setParam('product', $product);   
       
       //get inputs from from
       if(isset($_POST['submit']))
       {
           //retrieve inputs from form
           $name        = $_POST['productName'] ?? '';
           $catchPhrase = $_POST['catchPhrase'] ?? '';
           $description = $_POST['productDescription'] ?? '';
           $price       = $_POST['productPrice'] ?? '';
           $vendor      = $_POST['vendor'] ?? '';
           $category    = $_POST['category'] ?? '';
           $isHidden    = isset($_POST['isHidden']);

           //check if name is empty
           if(empty($name))
           {
               $errorMessages['productName'] = 'Bitte geben Sie einen Produktnamen an!';
           }

           //check if description is empty
           if(empty($description))
           {
               $errorMessages['description'] = 'Bitte geben Sie eine Produktbeschreibung an!';
           }

           //check if price is valid
           if(!\myf\core\validateNumberInput($price, 2))
           {
               $errorMessages['price'] = 'Geben Sie einen Preis größer 0 € und mit maximal zwei Nachkommastellen an.';
           }

           $db = $GLOBALS['database'];

           //check if vendor exists
           if(empty($vendor) || \myf\models\Vendor::findOne('id=' . $db->quote($vendor)) == null)
           {
               $errorMessages['vendor'] = 'Wählen Sie eine gültige Marke aus.';
           }

           //check if category exists
           if(empty($category) || \myf\models\Category::findOne('id=' . $db->quote($category)) == null)
           {
               $errorMessages['category'] = 'Wählen Sie eine gültige Kategorie aus.';
           }

           //check if productname is not new
           if(!empty($name) && ($name != $product->productName) && \myf\models\Product::findOne('productName LIKE ' . $db->quote($name)) !== null)
           {
               $errorMessages['productFound'] = 'Es existiert bereits ein Produkt mit dem von Ihnen gewünschten Namen!';
           }

           //check if there are files to be uploaded
           $fileNames = array_filter($_FILES['productImages']['name']);
           if(!empty($fileNames))
           {
               //check if all images are okay
               $this->validateImages('productImages', $errorMessages);
           }
           
           if(count($errorMessages) === 0)    
           {
               //go through all images of the current product
               foreach($product->images as $productImage)
               {
                   $deleteImage = isset($_POST['deleteImage' . $productImage->id]) ? true : false;
                   if($deleteImage)
                   {
                       $productImage->delete();
                   }
                   else
                   {
                       //change image title
                       $newTitle = $_POST['imageName' . $productImage->id] ?? $productImage->name;
                       $productImage->image->imageName = $newTitle;
                       $productImage->image->save();
                   }
               }

               //upload new images (if available)
               if(count($errorMessages) === 0 && !empty($fileNames))
               {
                   $this->addImagesToProduct($product, 'productImages');
               }

               //apply changes to product
               $product->productName        = $name;
               $product->catchPhrase        = $catchPhrase;
               $product->productDescription = $description;
               $product->vendorID           = $vendor;
               $product->categoryID         = $category;
               $product->standardPrice      = $price;
               $product->isHidden           = $isHidden;

               //save product to database
               $product->save();
               $_SESSION['productSuccess'] = 'Das Produkt "' . $name . '" wurde ergolgreich geändert!';
               
               $this->updateLastActiveTime();
               
               //redirect to product page
               header('Location: ?c=products&a=view&pid=' . $product->id);
           }
       }
       $this->setParam('errorMessages', $errorMessages);
           
   }

   /**
    * Checks if the given images have the correct file type and the correct file size
    *
    * @param string $imagesKey
    * @param string $errorMessages
    * @return void
    */
   private function validateImages($imagesKey, &$errorMessages)
   {
       //check if images are okay
       foreach($_FILES[$imagesKey]['name'] as $key => $value)
       {
           $currentFileName = basename($_FILES[$imagesKey]['name'][$key]);
           $fileType = pathinfo($currentFileName, PATHINFO_EXTENSION);
           
           //check, if file type is okay
           if(!in_array($fileType, $GLOBALS['supportedFiles']))
           {
               $errorMessages['img' . $key . 'type'] = 'Der Dateityp von ' . $currentFileName . ' wird nicht unterstützt!';
           }
           
           //check if image size is okay
           if($_FILES[$imagesKey]['size'][$key] > MAX_FILE_SIZE)
           {
               $errorMessages['img' . $key . 'size'] = 'Die Datei ' . $currentFileName . ' übersteigt die maximale Dateigröße von ' . MAX_FILE_SIZE . ' KB!';
           }
       }
   }


   /**
    * Adds all images to the given product
    *
    * @param Product $product
    * @param string  $imagesKey
    * @return void
    */
   private function addImagesToProduct(&$product, $imagesKey)
   {
        //generate a unique directory name by using the md5 hash of the product name
        $directoryName = PRODUCT_IMAGE_PATH . DIRECTORY_SEPARATOR . md5($product->productName);   
       
       //create directory, if it does not exist
       if(!file_exists($directoryName))
       {
           mkdir($directoryName, 0755, true);
       }

       //upload images
       foreach($_FILES['productImages']['name'] as $key => $value)
       {
           //extract base name of file without file extension
           $fileName = explode('.', $_FILES['productImages']['name'][$key])[0];
       
           //create (almost) unique filename
           $currentFileName = str_replace(' ', '_', $fileName);
           $imageName       = substr(explode('_', $currentFileName)[0], 0, 10) . date('Ydmhis', time()) . uniqid('', true);
           $fileType        = pathinfo($_FILES['productImages']['name'][$key], PATHINFO_EXTENSION); 
           $targetPath      = $directoryName . DIRECTORY_SEPARATOR . $imageName . '.' . $fileType;

           //try to upload the file
           $uploadWasSuccessful = \move_uploaded_file($_FILES['productImages']['tmp_name'][$key], $targetPath);
           if($uploadWasSuccessful)
           {
               $product->addImage($targetPath);
           }
       }
   }
}