<?php

namespace myf\models;

use \myf\core\BaseModel as BaseModel;

class Product extends BaseModel
{
    const TABLENAME = '`products`';

    protected $schema = [
        'id'                    =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' ],
        'createdAt'             =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'             =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'     ],
        'productName'           =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null' ],
        'catchPhrase'           =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'null'     ],
        'productDescription'    =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'min' => 10, 'max' => 5000],  
        'standardPrice'         =>  ['type' => BaseModel::TYPE_DECIMAL , 'null' => 'not null'],
        'categoryID'            =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null'],
        'vendorID'              =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null']
    ];

    private $vendor   = null;
    private $category = null;

    public function __get($key) 
    {
        if($key == 'vendor')
        {
            if($this->vendor == null)
            {
                $vendorResult = Vendor::findOne('id=' . $this->vendorID);
                $this->vendor = new Vendor($vendorResult);
            }
            return $this->vendor;
        }
        else if($key == 'category')
        {
            if($this->category == null)
            {
                $categoryResult = Category::findOne('id=' . $this->categoryID);
                $this->category = new Category($categoryResult);
            }
            return $this->category;
        }
        else
        {
            return parent::__get($key);
        }
    }

    public function __destruct()
    {
        $vendor   = null;
        $category = null;
    }
}