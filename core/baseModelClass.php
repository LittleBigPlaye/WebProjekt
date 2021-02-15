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
     * The constructor automatically matches database attributes to the corresponding param
     * 
     * @param array $params   parameters of the object to be build
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

        throw new \Exception('You can not write top property "'.$key.'" for the class "'.get_called_class());
    }


    /**
     * This function is used to insert an new entry into the database
     * 
     * @param array $errors   used to add potential error messages to an array (optional)
     * @return bool
     */
    protected function insert(&$errors)
    {
        $db = $GLOBALS['database'];
      
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

        try
        {
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
        }
        return false;
    }


    /**
     * This function is used to update an entry that already exists in the database and has a valid id
     * 
     * @param array $errors     used to add potential error messages to an array (optional)
     * @return bool
     *
     */
    protected function update(&$errors)
    {
        $db = $GLOBALS['database'];
       
        $sql = 'UPDATE '.self::tablename().' SET ';
        foreach ($this->schema as $key => $schemaOptions)
        {
            if($this->data[$key] === null || empty($this->data[$key]))
            {
                $sql .= $key. ' = NULL,';
            }
            else
            {
                $sql .= $key. ' = '.$db->quote($this->data[$key]).',';
            }
        }

        $sql = trim($sql,',');
        $sql .= ' WHERE id = '.$this->data['id'];

        try
        {
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
     * This function is used to check if all attributes match the given restrictions such as min / max length
     * 
     * @param array $errors  used to add potential error messages to an array (optional)
     * 
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

        return (count($errors) === 0);
    }

    /**
     * This function is used to validate a given attribute
     * 
     * @param $attribute        the attribute that should be validated
     * @param $value            the value of the attribute
     * @param $schemaOptions    the options for the given attribute
     * @return array|bool
     */
    protected function validateValue($attribute, &$value, &$schemaOptions)
    {
        $type = $schemaOptions['type'];
        $errors = [];

        switch ($type)
        {
            case BaseModel::TYPE_STRING:
            
                //check if the min length is valid
                if(isset($schemaOptions['min']) && mb_strlen($value) < $schemaOptions['min'])
                {
                    $errors[] = $attribute.': String needs min. '.$schemaOptions['min'].' charackters!';
                }

                //check if the max length is valid
                if(isset($schemaOptions['max']) && mb_strlen($value) > $schemaOptions['max'])
                {
                    $errors[] = $attribute.': String can have max. '.$schemaOptions['max'].' charackters!';
                }

                //check if the value shall not be null
                if(isset($schemaOptions['null']) && $schemaOptions['null'] == 'not null' && empty($value))
                {
                    $errors[] = $attribute . ": Must not be NULL!";
                }

                //check if the values are inside a range of allowed values
                if(isset($schemaOptions['allowedValues']) && !in_array($value, $schemaOptions['allowedValues']))
                {
                    $errors[] = $attribute . ": Must be in valid range";
                }
            
                break;
        }

        return count($errors) > 0 ? $errors: true;
    }


    /**
     * This function is used to obtain the tablename of the table that fits to the current class
     * To bypass case-sensitivity the class name is always converted to lower case
     * 
     * @return null|string
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
     * This function is used to get an array of results from the database
     * 
     * @param string $where     the where clause that should be applied to the query
     * @param string $order     the order by clause that should be applied to the query
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
     * This function is used to find just one explicit result
     * 
     * @param string $where     the where clause that should be used for the database query
     * @param string $order     the order by clause thet should be used for the database query
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

    /**
     * This function is used to obtain a range of result sets from the database
     *
     * @param int    $offset    the offset that should be used for the query
     * @param int    $length    the number of results that should be returned
     * @param string $where     the where clause for the query
     * @param string $orderBy   the order by clause for the query
     * @return void
     */
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
     * This function is used to automatically choose whether an entry should be inserted or just updated
     * 
     * @param null $errors  used to add potential error messages to an array (optional)
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
     * This function is used to delete an existing entry from the database
     * 
     * @param array $errors     used to add potential error messages to an array (optional)
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

    /**
     * This function is used to start a database transaction
     *
     * @param array $errors    used to add potential error messages to an array (optional)
     * @return void
     */
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

    /**
     * This function is used to stop a database transaction
     *
     * @param array $errors    used to add potential error messages to an array (optional)
     * @return void
     */
    public function stopTransaction(&$errors = null) {
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


    public function __destruct() 
    {
        $this->data   = [];
        $this->params = [];
    }

}