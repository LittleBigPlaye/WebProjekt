<?php

/**
 * @author Robin Beck
 */

namespace myf\models;


use myf\core\BaseModel as BaseModel;

class Order extends BaseModel
{
    const TABLENAME ='`orders`';
    protected $schema = [
        'id'                    =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' , 'autoincrement' => true],
        'createdAt'             =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'             =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'     ],
        'shippingDate'          =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'],
        'cancellationDate'      =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'],
        'loginID'               =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null']
    ];

    private $orderItems = [];

    public function __get($key)
    {
        if($key == 'orderItems' )
        {
            if(count($this->orderItems) == 0 && $this->id !== null)
            {
                $this->orderItems = OrderItem::find('ordersID=' . $this->id);
            }
            return $this->orderItems;
        }
        return parent::__get($key);
    }

    public function addOrderItem(&$orderItem)
    {
        array_push($this->orderItems, $orderItem);
    }

    public function save(&$errors = null)
    {
        if(!empty($this->orderItems))
        {
            parent::save();
            foreach($this->orderItems as $orderItem)
            {
                //give OrderItem ID of current order
                $orderItem->ordersID = $this->id;
                //save OrderItem to DB
                $orderItem->save();
            }
        }
    }

    public function calculateTotalPrice()
    {
        $totalPrice = 0;
        foreach($this->orderItems as &$orderItem)
        {
            $totalPrice += $orderItem->actualPrice;
        }
        return $totalPrice;
    }

    public function __destruct()
    {
        $orderItems = [];
    }
}