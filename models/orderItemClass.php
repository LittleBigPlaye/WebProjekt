<?php

namespace myf\models;


use myf\core\BaseModel as BaseModel;

/**
 * This Class represents one single entry of the orderItems table of the database
 * @author Robin Beck
 */
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
        'actualPrice' =>  ['type' => BaseModel::TYPE_DECIMAL  , 'null' => 'null']
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
        else if($key == 'formattedActualPrice')
        {
            $actualPrice = parent::__get('actualPrice');
            return number_format($actualPrice, 2, ',', '.');
        }
        return parent::__get($key);
    }

    /**
     * This function makes sure that the orderItem can only be saved, if a product is referenced
     *
     * @param [type] $errors
     * @return void
     */
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
        parent::__destruct();
    }
}