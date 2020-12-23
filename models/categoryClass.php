<?php

namespace myf\models;

use \myf\core\BaseModel as BaseModel;

class Category extends BaseModel
{
    const TABLENAME = '`categories`';

    protected $schema = [
        'id'            =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' ],
        'createdAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'     ]    ,
        'categoryName'  =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'min' =>  5, 'max' => 45]
    ];
}