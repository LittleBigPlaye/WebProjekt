<?php

namespace myf\models;


use myf\core\BaseModel as BaseModel;

/**
 * This Class is used to represent one single entry of the orders table
 * @author Robin Beck
 */
class Order extends BaseModel
{
    const TABLENAME ='`orders`';
    protected $schema = [
        'id'                    =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' , 'autoincrement' => true],
        'createdAt'             =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'             =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'     ],
        'shippingDate'          =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'],
        'cancellationDate'      =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'],
        'loginsID'              =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null']
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

    /**
     * This function is used to add a order item to the order
     *
     * @param \myf\models\OrderItem $orderItem  the order item that should be added
     * @return void
     */
    public function addOrderItem(&$orderItem)
    {
        array_push($this->orderItems, $orderItem);
    }

    /**
     * This function makes sure that all order items are saved before the order is saved
     *
     * @param [type] $errors
     * @return void
     */
    public function save(&$errors = null)
    {
        if(!empty($this->orderItems))
        {
            $this->startTransaction();
            parent::save();
            foreach($this->orderItems as $orderItem)
            {
                //give OrderItem ID of current order
                $orderItem->ordersID = $this->id;
                //save OrderItem to DB
                $orderItem->save();
            }
            $this->stopTransaction();
        }
    }

    /**
     * This function is used to calculate the price of the order
     *
     * @return void
     */
    public function calculateTotalPrice()
    {
        $totalPrice = 0;
        foreach($this->orderItems as &$orderItem)
        {
            $totalPrice += $orderItem->actualPrice;
        }
        return number_format($totalPrice, '2', ',', '.');
    }

    public function __destruct()
    {
        $orderItems = [];
    }
}