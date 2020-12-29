<?php


namespace myf\models;


use myf\core\BaseModel as BaseModel;

class Login extends BaseModel
{
    const TABLENAME ='`logins`';

    protected $schema = [
        'id'                        => ['type' => BaseModel::TYPE_INT, 'null' => 'not null', 'autoincrement' => true],
        'createdAt'                 => ['type' => BaseModel::TYPE_DATE, 'null' => 'not null'],
        'updatedAt'                 => ['type' => BaseModel::TYPE_DATE, 'null' => 'null'],
        'validated'                 => ['type' => BaseModel::TYPE_INT, 'null' => 'not null'],
        'enabled'                   => ['type' => BaseModel::TYPE_INT, 'null' => 'not null'],
        'email'                     => ['type' => BaseModel::TYPE_STRING, 'null' => 'not null'],
        'lastActive'                => ['type' => BaseModel::TYPE_DATE, 'null' => 'null'],
        'lastLogin'                 => ['type' => BaseModel::TYPE_DATE, 'null' => 'null'],
        'failedLoginCount'          => ['type' => BaseModel::TYPE_INT, 'null' => 'not null'],
        'passwordHash'              => ['type' => BaseModel::TYPE_STRING, 'null' => 'not null'],
        'passwordResetHash'         => ['type' => BaseModel::TYPE_STRING, 'null' => 'null'],
        'passwordResetCreatedAt'    => ['type' => BaseModel::TYPE_STRING, 'null' => 'not null'],
        'userID'                    => ['type' => BaseModel::TYPE_INT, 'null' => 'not null']
        ];

    private $user = null;

    public function __get($key)
    {
        //relation to table "users"
        if($key == 'user')
        {
            if($this->user == null)
            {
                $userResult = User::findOne('id=' .$this->userID);
                $this->user = new User($userResult);

            }
            return $this->user;
        }
        else
        {
            return parent::__get($key);
        }
    }

}