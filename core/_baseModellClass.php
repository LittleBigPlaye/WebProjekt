<?php


abstract class _baseModellClass
{
    const TYPE_INT = 'int';
    const TYPE_FLOAT = 'float';
    const TYPE_STRING = 'string';

    public function __construct($params)
    {
        foreach ($this->schema as $key => $value)
        {
            if(isset($params[$key]))
            {
                $this->{key} = $params[$key];
            }
            else
            {
                $this->{$key} = null;
            }
        }
    }

    public function __get($key)
    {

        if(array_key_exists($key, $this->data))
        {
            return $this->data[$key];
        }
        throw new \Exception('You can not access to property "'.$key.'" for the class "'.get_called_class());
    }

    public function __set($key, $value)
    {
        if (array_key_exists($key, $this->schema)) {
            $this->data[$key] = $value;
            return;
        }

        throw new Exception('You can not write top property "'.$key.'" for the class "'.get_called_class());
    }
}