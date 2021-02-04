<?php

namespace myf\models;

use \myf\core\BaseModel as BaseModel;

/**
 * This Class is used to represent one single entry of the products table
 * It also contains relations to vendors, categories and productImages
 * @author Robin Beck
 */
class Product extends BaseModel
{
    const TABLENAME = '`products`';

    protected $schema = [
        'id'                    =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' , 'autoincrement' => true],
        'createdAt'             =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'             =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'     ],
        'productName'           =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'max' => 120],
        'catchPhrase'           =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'null'    , 'max' => 150] ,
        'productDescription'    =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'max' => 5000],  
        'standardPrice'         =>  ['type' => BaseModel::TYPE_DECIMAL , 'null' => 'not null'],
        'categoriesID'          =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null'],
        'vendorsID'             =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null'],
        'isHidden'              =>  ['type' => BaseMOdel::TYPE_INT     , 'null' => 'null']
    ];

    private $vendor        = null;
    private $category      = null;
    private $productImages = [];

    public function __get($key) 
    {
        //relation to table "vendors"
        if($key == 'vendor')
        {
            if($this->vendor == null)
            {
                $this->vendor = Vendor::findOne('id=' . $this->vendorsID);
            }
            return $this->vendor;
        }
        //relation to table "categories"
        else if($key == 'category')
        {
            if($this->category == null)
            {
                $this->category = Category::findOne('id=' . $this->categoriesID);
            }
            return $this->category;
        }
        //relation to table "productImages"
        else if($key == 'images')
        {
            if(count($this->productImages) === 0)
            {
                $this->productImages = ProductImage::find('productsID=' . $this->id);
            }
            return $this->productImages;
        }
        else
        {
            return parent::__get($key);
        }
    }

    /**
     * This function is used to save the product and all attached product images afterwards
     *
     * @param [type] $errors
     * @return void
     */
    public function save(&$errors = null) {
        //surrounding by transaction to make sure all inserts worked
        $this->startTransaction();
        //save this first to make sure it has a valid id
        parent::save();
        
        //save all images and the connection to the product
        foreach($this->productImages as $productImage)
        {
            if($productImage != null)
            {
                $productImage->productsID = $this->id;
                $productImage->save();
            }
        }
        $this->stopTransaction();
    }

    public function __destruct()
    {
        $vendor        = null;
        $category      = null;
        $productImages = [];
    }

    /**
     * This function is used to add a new image to the product
     *
     * @param string $imagePath     the (relative) path of the image
     * @param string $thumbnailPath the (relative) path of the thumbnail
     * @return void
     */
    public function addImage($imagePath, $thumbnailPath) 
    {
        //check if an image with the given path already exists
        if(Image::findOne('imagePath="' . $imagePath . '"') !== null)
        {
            return false;
        }
        else
        {
            $currentProductImage = new ProductImage(array());
            $currentProductImage->setImage($imagePath, $thumbnailPath);
            array_push($this->productImages, $currentProductImage);
        }
    }
}