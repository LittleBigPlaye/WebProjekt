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
        'id'            =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' , 'autoincrement' => true],
        'createdAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'     ]    ,
        'imageName'     =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'min' =>  5, 'max' => 150],
        'imageURL'      =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'min' =>  5, 'max' => 256],
        'thumbnailURL'  =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'min' =>  5, 'max' => 256]
    ];

    public function __get ($key){
        if($key == 'path') 
        {
            return $this->fixPathName($this->imageURL);
        }
        if($key == 'thumbnailPath') 
        {
            return $this->fixPathName($this->thumbnailURL);
        }
        return parent::__get($key);
    }

    public function delete(&$errors = null)
    {
        //make sure to delete the image file before deleting the image database entry
        if(file_exists($this->imageURL))
        {
            unlink($this->imageURL);
        }
        if(file_exists($this->thumbnailURL))
        {
            unlink($this->thumbnailURL);
        }
        parent::delete($errors);
    }

    //used to fix wrong directory separators from the database 
    //(occurs, if images have been added on windows system and afterwards the server runs on a system with / as directory separator)
    private function fixPathName($path) 
    {
        $replacedPath = str_replace(['\\','/'], DIRECTORY_SEPARATOR , $path);
        return $replacedPath;
    }
}