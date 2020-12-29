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
        if($key == 'path' || $key == 'name' || $key == 'image')
        {
            if($this->image == null)
            {
                $imageResult = Image::findOne('id=' . $this->imagesID);
                $this->image = new Image($imageResult);
            }
            if($key == 'path')
            {
                return $this->image->imageURL;
            }
            else if($key == 'name')
            {
                return $this->image->imageName;
            }
            else
            {
                echo 'NochnTest';
                return $this->image;
            }
        }

        return parent::__get($key);
    }

    

    public function __destruct()
    {
        $image = null;
    }

    public function save(&$errors = null) {
        if($this->image != null)
        {
            //make sure that the image has an id
            $this->image->save();
            //make sure to reference to the image
            $this->imagesID = $this->image->id;
        }
        //save this productImage
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

    public function delete(&$errors = null)
    {
        parent::delete($errors);

        $imageResult = Image::findOne('id=' . $this->imagesID);
        $this->image = new Image($imageResult);
        if($this->image != null)
        {
            $numberOfImageReferences = count(ProductImage::find('imagesID=' . $this->imagesID));
            echo $numberOfImageReferences;
            //delete image, if no references are left
            if($numberOfImageReferences < 1)
            {
                $this->image->delete($errors);
                $this->image = null;
            }
        }
    }
}