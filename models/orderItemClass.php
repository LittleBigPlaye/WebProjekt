<?php

/**
 * @author Robin Beck
 */

namespace myf\models;


use myf\core\BaseModel as BaseModel;

class OrderItem extends BaseModel
{
    const TABLENAME ='`orderItems`';
    protected $schema = [
        'id'          =>  ['type' => BaseModel::TYPE_INT      , 'null' => 'not null' , 'autoincrement' => true],
        'createdAt'   =>  ['type' => BaseModel::TYPE_DATE     , 'null' => 'not null' ],
        'updatedAt'   =>  ['type' => BaseModel::TYPE_DATE     , 'null' => 'null'     ],
        'productsID'  =>  ['type' => BaseModel::TYPE_INT      , 'null' => 'null'],
        'ordersID'    =>  ['type' => BaseModel::TYPE_INT      , 'null' => 'null'],
        'quantity'    =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'null'],
        'actualPrice' => ['type' => BaseModel::TYPE_DECIMAL  , 'null' => 'null']
    ];

    private $product = null;

    public function __get($key)
    {
        if($key == 'product')
        {
            if($this->product === null)
            {
                $this->product = Product::findOne('id=' . $this->productsID);
            }
            return $this->product;
        }
        return parent::__get($key);
    }

    public function save(&$errors = null) 
    {
        if($this->productsID !== null && $this->ordersID !== null)
        {
            parent::save();
        }
    }

    public function __destruct()
    {
        $this->product = null;
    }
}