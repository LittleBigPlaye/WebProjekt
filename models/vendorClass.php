<?php

namespace myf\models;

use \myf\core\BaseModel as BaseModel;

/**
 * This Class is used to represent a single entry of the vendors table
 * @author Robin Beck
 */
class Vendor extends BaseModel
{
    const TABLENAME = '`vendors`';

    protected $schema = [
        'id'                    =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' , 'autoincrement' => true],
        'createdAt'             =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'             =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'     ],
        'vendorName'            =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null' ]
    ];
}