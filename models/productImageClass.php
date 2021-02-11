<?php

namespace myf\models;

use \myf\core\BaseModel as BaseModel;

/**
 * This Class is used to represent a single entry of the productImages table
 * It also contains the relation to the images table
 * @author Robin Beck
 */
class ProductImage extends BaseModel
{
    const TABLENAME = '`productImages`';

    protected $schema = [
        'id'            =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' , 'autoincrement' => true],
        'createdAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'     ],
        'imagesID'      =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' ],
        'productsID'    =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' ]
    ];

    private $image = null;


    public function __get($key)
    {
        if($key == 'path' || $key == 'thumbnailPath' || $key == 'name' || $key == 'image')
        {
            if($this->image == null)
            {
                $this->image = Image::findOne('id=' . $this->imagesID);
            }
            switch($key)
            {
                case 'path':
                    if($this->image !== null  && file_exists(PRODUCT_IMAGE_PATH . DIRECTORY_SEPARATOR . $this->image->imagePath))
                    {
                        return PRODUCT_IMAGE_PATH . DIRECTORY_SEPARATOR . $this->image->imagePath;
                    }
                    else
                    {
                        return FALLBACK_IMAGE;
                    }
                    break;
                
                case 'thumbnailPath':
                    if($this->image !== null  && file_exists(PRODUCT_THUMBNAIL_PATH . DIRECTORY_SEPARATOR . $this->image->thumbnailPath))
                    {
                        return PRODUCT_THUMBNAIL_PATH . DIRECTORY_SEPARATOR . $this->image->thumbnailPath;
                    }
                    else
                    {
                        return FALLBACK_IMAGE;
                    }
                    break;

                case 'name':
                    return $this->image->imageName;
                    break;
                default:
                    return $this->image;
            }
        }

        return parent::__get($key);
    }

    

    public function __destruct()
    {
        $this->image = null;
        parent::__destruct();
    }

    /**
     * This function is used to save the attached image (if it has not been added to the database already)
     * and to save the productImage entry itself
     *
     * @param [type] $errors
     * @return void
     */
    public function save(&$errors = null) {
        if($this->image != null)
        {
            //make sure that the image has an id
            $this->image->save();
            //make sure to reference to the image
            $this->imagesID = $this->image->id;
        }
        //save this productImage
        parent::save();
    }

    /**
     * This function is used to set the image that is referenced by this entry
     *
     * @param string $imagePath      relative path to the image
     * @param string $thumbnailPath  relative path to the thumbnail
     * @param string $imageName      name of the image
     * @return void
     */
    public function setImage($imagePath, $thumbnailPath, $imageName='')
    {
        if($this->image == null)
        {   
            $this->image = new Image(array());
        }
        $this->image->imagePath      = $imagePath;
        $this->image->thumbnailPath  = $thumbnailPath;
        $this->image->imageName      = $imageName;
    }

    /**
     * This function is used to make sure that the referenced image is also going to be deleted,
     * if the image is not referenced by any other product images
     *
     * @param [type] $errors
     * @return void
     */
    public function delete(&$errors = null)
    {
        parent::delete($errors);

        $this->image = Image::findOne('id=' . $this->imagesID);
        if($this->image != null)
        {
            $numberOfImageReferences = count(ProductImage::find('imagesID=' . $this->imagesID));
            if($numberOfImageReferences < 1)
            {
                $this->image->delete($errors);
                $this->image = null;
            }
        }
    }
}