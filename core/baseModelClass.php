<?php
/**
 * @author John Klippstein
 */
namespace myf\core;


abstract class BaseModel
{
    const TYPE_INT      = 'int';
    const TYPE_FLOAT    = 'float';
    const TYPE_STRING   = 'string';
    const TYPE_DECIMAL  = 'dec';
    const TYPE_DATE     = 'date';

    protected $data = [];
    protected $params = [];

    /**
     * _baseModellClass constructor.
     * @param $params
     *
     */
    public function __construct($params)
    {
        foreach ($this->schema as $key => $value)
        {
            if(isset($params[$key]))
            {
                $this->{$key} = $params[$key];
            }
            else
            {
                $this->{$key} = null;
            }
        }
    }


    /**
     * @param $key
     * @return mixed
     * @throws Exception
     */
    public function __get($key)
    {

        if(array_key_exists($key, $this->data))
        {
            return $this->data[$key];
        }
        throw new \Exception('You can not access to property "'.$key.'" for the class "'.get_called_class());
    }

    /**
     * @param $key
     * @param $value
     * @throws Exception
     */
    public function __set($key, $value)
    {
        if (array_key_exists($key, $this->schema)) {
            $this->data[$key] = $value;
            return;
        }

        throw new \Exception('You can not write top property "'.$key.'" for the class "'.get_called_class());
    }


    /**
     * @param $errors
     * @return bool
     */
    protected function insert(&$errors)
    {
        $db = $GLOBALS['database'];

        try
        {
            $sql = 'INSERT INTO '.self::tablename().' (';
            $valueString = ' VALUES (';

            foreach ($this->schema as $key => $schemaOptions)
            {
                if(!isset($schemaOptions['autoincrement']) || $schemaOptions['autoincrement'] === false)
                {
                    $sql .= '`'.$key.'`,';

                    if($this->data[$key] === null)
                    {
                        $valueString .='NULL,';
                    }
                    else
                    {
                        $valueString .= $db->quote($this->data[$key]).',';
                    }
                }
            }

            $sql = trim($sql,',');
            $valueString = trim($valueString, ',');

            $sql .= ')'.$valueString.')';
            $statment = $db->prepare($sql);
            $result = $statment->execute();
            if($result !== 0)
            {
                $this->id = $db->lastInsertId();
            }

            return true;

        }
        catch (\PDOException $e)
        {
            $errors[]='Error inserting '.get_called_class();
            die($e->getMessage());
        }
        return false;

    }


    /**
     * @param $errors
     * @return bool
     *
     */
    protected function update(&$errors)
    {
        $db = $GLOBALS['database'];

        try
        {
            $sql = 'UPDATE '.self::tablename().' SET ';
            foreach ($this->schema as $key => $schemaOptions)
            {
                if($this->data[$key] !== null)
                {
                    $sql .= $key. ' = '.$db->quote($this->data[$key]).',';
                }
            }

            $sql = trim($sql,',');
            $sql .= ' WHERE id = '.$this->data['id'];

            $statement = $db->prepare($sql);
            $statement->execute();

            return true;
        }
        catch (\PDOException $e)
        {
            $errors[]='Error updating '.get_called_class();
        }
        return false;
    }


    /**
     * @param null $errors
     * @return bool
     */
    public function validate (&$errors = null)
    {
        foreach ($this->schema as $key => $schemaOptions)
        {
            if(isset($this->data[$key]) && is_array($schemaOptions))
            {
                $valueErrors = $this->validateValue($key, $this->data[$key], $schemaOptions);

                if($valueErrors !== true)
                {
                    array_push($errors, ...$valueErrors); //die 3 Punkte geben an, dass die Werte aus $valueErrors in $errors angehangen werden und nicht das Array
                }
            }
        }

        if(count($errors) === 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $attribute
     * @param $value
     * @param $schemaOptions
     * @return array|bool
     */
    protected function validateValue($attribute, &$value, &$schemaOptions)
    {
        $type = $schemaOptions['type'];
        $errors = [];

        switch ($type)
        {
            case BaseModel::TYPE_INT:
                break;
            case BaseModel::TYPE_FLOAT:
                break;
            case BaseModel::TYPE_STRING:
                {
                    if(isset($schemaOptions['min']) && mb_strlen($value) < $schemaOptions['min'])
                    {
                        $errors[] = $attribute.': String needs min. '.$schemaOptions['min'].' charackters!';
                    }

                    if(isset($schemaOptions['max']) && mb_strlen($value) > $schemaOptions['max'])
                    {
                        $errors[] = $attribute.': String can have max. '.$schemaOptions['max'].' charackters!';
                    }
                    if(isset($schemaOptions['null']) && $schemaOptions['null'] == 'not null' && empty($value))
                    {
                        $errors[] = $attribute . ": Must not be NULL!";
                    }
                    if(isset($schemaOptions['allowedValues']) && !in_array($value, $schemaOptions['allowedValues']))
                    {
                        $errors[] = $attribute . ": Must be in valid range";
                    }
                }
                break;
        }

        return count($errors) > 0 ? $errors: true;
    }


    /**
     * @return |null
     */
    public static function tablename()
    {
        $class = get_called_class();
        if(defined($class.'::TABLENAME'))
        {
            return strtolower($class::TABLENAME);
        }
        return null;
    }

    /**
     * @param string $where
     * @return mixed
     */
    public static function find($where = '', $order = '')
    {
        $db  = $GLOBALS['database'];
        $results = array();

        try
        {
            $db->query('SET NAMES utf8')->execute();
            $sql = 'SELECT * FROM ' . self::tablename();

            if(!empty($where))
            {
                $sql .= ' WHERE ' . $where;
            }

            if(!empty($orderBy))
            {
                $sql .= ' ORDER BY ' . $orderBy;
            }
            $sql .= ';';

            $resultSets = $db->query($sql)->fetchAll();
            $currentClass = get_called_class();
            foreach($resultSets as $resultSet)
            {
                array_push($results, new $currentClass($resultSet));
            }
        }
        catch(\PDOException $e)
        {
            die('Select statment failed: ' . $e->getMessage());
        }

        return $results;
    }


    /**
     * @param string $where
     * @return mixed
     */
    public static function findOne($where='', $orderBy='')
    {
        $db  = $GLOBALS['database'];
        $result = null;

        try
        {
                $db->query('SET NAMES utf8')->execute();
                $sql = 'SELECT * FROM ' . self::tablename();

                if(!empty($where))
                {
                    $sql.=' WHERE ' . $where;
                }

                if(!empty($orderBy))
                {
                    $sql .= ' ORDER BY ' . $orderBy;
                }
                $sql .= ';';
                $resultSet = $db->query($sql)->fetch();

                $currentClass = get_called_class();
                if(is_array($resultSet))
                {
                    $result = new $currentClass($resultSet);
                }

        }
        catch(\PDOException $e)
        {
            die('Select statement failed: '.$e->getMessage());
        }
        return $result;
    }

    public static function findRange($offset, $length, $where='', $orderBy='')
    {
        $db  = $GLOBALS['database'];
        $results = array();

        try
        {
            $db->query('SET NAMES utf8;')->execute();
            $sql = 'SELECT * FROM ' . self::tablename();

            if(!empty($where))
            {
                $sql .= ' WHERE ' . $where;
            }
            if(!empty($orderBy))
            {
                $sql .= ' ORDER BY ' . $orderBy;
            }

            $sql .= ' LIMIT ' . $offset . ', ' . $length . ';';
            $resultSets = $db->query($sql)->fetchAll();
            $currentClass = get_called_class();
            foreach($resultSets as $resultSet)
            {
                array_push($results, new $currentClass($resultSet));
            }
        }
        catch(\PDOException $e)
        {
            die('Select statment failed: ' . $e->getMessage());
        }

        return $results;
    }

    /**
     * @param null $errors
     */
    public function save(&$errors = null)
    {
        if($this->id===null)
        {
            $this->insert($errors);
        }
        else
        {
            $this->update($errors);
        }
    }


    /**
     * @param null $errors
     * @return bool
     */
    public function delete(&$errors = null)
    {
        $db = $GLOBALS['database'];

        try
        {
            $sql='DELETE FROM '.self::tablename().' WHERE id = '.$this->id;
            $db->exec($sql);
            return true;
        }
        catch (\PDOException $e)
        {
            $errors[]='Error deleting '.get_called_class();
        }
        return false;
    }

    public function startTransaction(&$errors = null) {
        $db = $GLOBALS['database'];
        try 
        {
            $db->beginTransaction();
        }
        catch (\PDOException $e)
        {
            $errors[] = 'Error while starting a transaction';
        }
    }

    public function stopTransaction() {
        $db = $GLOBALS['database'];
        try
        {
            $db->commit();
        }
        catch (\PDOException $e)
        {
            $errors[] = 'Error while stopping a transaction';
        }
    }

}