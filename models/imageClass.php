<?php
/**
 * @author Robin Beck
 */
namespace myf\models;

use \myf\core\BaseModel as BaseModel;

class Image extends BaseModel
{
    const TABLENAME = '`images`';

    protected $schema = [
        'id'            =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' ],
        'createdAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'     ]    ,
        'imageName'     =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'min' =>  5, 'max' => 150],
        'imageURL'      =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'min' =>  5, 'max' => 150]
    ];
}