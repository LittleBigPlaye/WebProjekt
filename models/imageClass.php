<?php
namespace myf\models;

use \myf\core\BaseModel as BaseModel;

/**
 * This Class is used to represent one single entry of the images table
 * @author Robin Beck
 */
class Image extends BaseModel
{
    const TABLENAME = '`images`';

    protected $schema = [
        'id'            =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' , 'autoincrement' => true],
        'createdAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'     ]    ,
        'imageName'     =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'max' => 150],
        'imagePath'     =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'max' => 256],
        'thumbnailPath' =>  ['type' => BaseModel::TYPE_STRING  , 'null' => 'not null', 'max' => 256]
    ];

    public function __get ($key){
        if($key == 'imagePath') 
        {
            return $this->fixPathName(parent::__get('imagePath'));
        }
        if($key == 'thumbnailPath') 
        {
            return $this->fixPathName(parent::__get('thumbnailPath'));
        }
        return parent::__get($key);
    }

    /**
     * This function is used to delete the entry from the database and unlinking the files before
     *
     * @param [type] $errors
     * @return void
     */
    public function delete(&$errors = null)
    {
        //make sure to delete the image file before deleting the image database entry
        if(file_exists($this->imagePath))
        {
            unlink($this->imagePath);
        }
        if(file_exists($this->thumbnailPath))
        {
            unlink($this->thumbnailPath);
        }
        parent::delete($errors);
    }

    /**
     * This function is used to fix wrong directory separators that might have been inserted into the database
     * This problem occurs if the image has been added on e.g. a Windows system and has been ported to a unixoid system afterwards
     *
     * @param string $path  the path that should be fixed
     * @return void         the fixed path
     */
    private function fixPathName($path) 
    {
        $replacedPath = str_replace(['\\','/'], DIRECTORY_SEPARATOR , $path);
        return $replacedPath;
    }
}