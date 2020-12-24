<?php
/**
 * @author Robin Beck
 */
namespace myf\models;

use \myf\core\BaseModel as BaseModel;

class Product extends BaseModel
{
    const TABLENAME = '`products`';

    protected $schema = [
        'id'                    =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' , 'autoincrement' => true],
        'createdAt'             =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'             =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'     ],
        'productName'           =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null' ],
        'catchPhrase'           =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'null'     ],
        'productDescription'    =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'min' => 10, 'max' => 5000],  
        'standardPrice'         =>  ['type' => BaseModel::TYPE_DECIMAL , 'null' => 'not null'],
        'categoryID'            =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null'],
        'vendorID'              =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null']
    ];

    private $vendor        = null;
    private $category      = null;
    private $productImages = null;

    public function __get($key) 
    {
        //relation to table "vendors"
        if($key == 'vendor')
        {
            if($this->vendor == null)
            {
                $vendorResult = Vendor::findOne('id=' . $this->vendorID);
                $this->vendor = new Vendor($vendorResult);
            }
            return $this->vendor;
        }
        //relation to table "categories"
        else if($key == 'category')
        {
            if($this->category == null)
            {
                $categoryResult = Category::findOne('id=' . $this->categoryID);
                $this->category = new Category($categoryResult);
            }
            return $this->category;
        }
        //relation to table "productImages"
        else if($key == 'images')
        {
            if($this->productImages == null)
            {
                $imageResults = ProductImage::find('productsID=' . $this->id);
                if(count($imageResults) > 0)
                {
                    $this->productImages = array();
                    foreach($imageResults as $result)
                    {
                        array_push($this->productImages, new ProductImage($result));
                    }    
                }
            }
            return $this->productImages;
        }
        else
        {
            return parent::__get($key);
        }
    }

    public function save(&$errors = null) {
        if($this->productImages != null)
        {
            $this->productImages->save();
        }
        parent::save();
    }

    public function __destruct()
    {
        $vendor        = null;
        $category      = null;
        $productImages = null;
    }

    public function addImage() 
    {
        //TODO add logic to add an image to the image collection
    }
}