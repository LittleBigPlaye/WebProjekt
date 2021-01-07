<?php


namespace myf\models;


use myf\core\BaseModel;

class Address extends BaseModel
{
    const TABLENAME = '`categories`';

    protected $schema = [
        'id'            =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' , 'autoincrement' => true],
        'createdAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'],
        'street'        =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null'],
        'streetNumber'  =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null'],
        'city'          =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null'],
        'zipCode'       =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null']
    ];
}