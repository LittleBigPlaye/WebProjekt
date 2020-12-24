<?
namespace myf\core;
/**
 * @author Robin Beck
 */

function loadVendors()
{
    $vendorResults = \myf\models\Vendor::find();
        $vendors = [];
        foreach($vendorResults as $result)
        {
            array_push($vendors, new \myf\models\Vendor($result));
        }
    return $vendors;
}

function loadCategories()
{
    $categoryResults = \myf\models\Category::find();
        $categories = [];
        foreach($categoryResults as $result)
        {
            array_push($categories, new \myf\models\Category($result));
        }
    return $categories;
}

function validateNumberInput($number, $numberOfDecimals)
{
    if(is_numeric($number) && preg_match('/^[0-9]+\.[0-9]{'.$numberOfDecimals.'}$/', $number))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function uploadImage($folderName, $image, &$errorMessage = null)
{
    $targetDir    = IMAGEPATH . $folderName;
    $targetFile   = $targetDir . basename($image['name']);
    
    $fileType = \strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $fileIsImage = getImageSize($image['tmp_name']);
    //check if the file is actually an image
    if(!$fileIsImage)
    {
        $errorMessage = 'Die Datei "' . $image['tmp_name'] . '" ist kein Bild!';
        return false;
    }

    //check if the file is too large
    if($image['size'] > $maxFileSize)
    {
        $errorMessage = 'Die Datei "' . $image['tmp_name'] . '" ist zu groß! (maximal ' . $maxFileSize . ' KB möglich)';
        return false; 
    }

    //check if the file has a valid file extension
    if(!\in_array($fileType, $supportedFiles))
    {
        $errorMessage = 'Das Format der Datei "' . $image['tmp_name'] . '" wird nicht unterstützt';
        return false;
    }

    //try to upload the file
    $uploadWasSuccessful = move_upload_file($image['tmp_name'], $targetFilet);
    if(!$uploadWasSuccessful)
    {
        $errorMessage = 'Beim Upload des Bildes ist ein Fehler aufgetreten!';
    }

    return $filePath;
}