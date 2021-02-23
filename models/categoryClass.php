<?php

namespace myf\models;

use \myf\core\BaseModel as BaseModel;

/**
 * This Class is used to represent one single entry of the Categories table
 * @author Robin Beck
 */
class Category extends BaseModel
{
    const TABLENAME = '`categories`';

    protected $schema = [
        'id'            =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' , 'autoincrement' => true],
        'createdAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'     ]    ,
        'categoryName'  =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'max' => 45]
    ];
}