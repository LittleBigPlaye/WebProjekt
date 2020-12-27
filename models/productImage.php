<?php
/**
 * @author Robin Beck
 */
namespace myf\models;

use \myf\core\BaseModel as BaseModel;

class ProductImage extends BaseModel
{
    const TABLENAME = '`productImages`';

    protected $schema = [
        'id'            =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' , 'autoincrement' => true],
        'createdAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'not null' ],
        'updatedAt'     =>  ['type' => BaseModel::TYPE_DATE    , 'null' => 'null'     ],
        'imagesID'      =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' ],
        'productsID'    =>  ['type' => BaseModel::TYPE_INT     , 'null' => 'not null' ]
    ];

    private $image = null;


    public function __get($key)
    {
        if($key == 'path')
        {
            if($this->image == null)
            {
                $imageResult = Image::findOne('id=' . $this->imagesID);
                $this->image = new Image($imageResult);
            }
            return $this->image->imageURL;
        }
        return parent::__get($key);
    }

    public function __destruct()
    {
        $image = null;
    }

    public function save(&$errors = null) {
        //make sure that the image has an id
        $this->image->save();
        //make sure to reference to the image
        $this->imagesID = $this->image->id;
        //save this image
        parent::save();
    }

    public function setImage($imageURL, $imageName='')
    {
        if($this->image == null)
        {   
            $this->image = new Image(array());
        }
        $this->image->imageURL  = $imageURL;
        $this->image->imageName = $imageName;
        
    }
}