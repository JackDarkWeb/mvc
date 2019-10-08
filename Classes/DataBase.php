<?php


class DataBase
{
    private  $instance = null;
    private $pdo,
        $query,
        $error = false,
        $results,
        $count = 0;

    protected function setDb()
    {
        try
        {
            $this->pdo = new PDO('mysql:host=localhost; dbname=management-consulting; charset=utf8', 'root', '');
        }catch(PDOException $e)
        {
            die($e->getMessage());
        }
    }

    /**
     * @return null
     */
    protected function getInstance()
    {
        if(($this->instance) == null)
        {
            $this->setDb();
        }
        return $this->pdo;
    }


    /**
     * @param $sql
     * @param array $params
     * @return $this
     */
    function query($sql, $params = [])
    {
        $this->error = false;
        if($this->query = $this->getInstance()->prepare($sql))
        {
            $x = 1;
            if(count($params))
            {
                foreach ($params as $param)
                {
                    $this->query->bindValue($x, $param);
                    $x++;
                }
            }
        }
        if($this->query->execute()){
            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
            $this->count   = $this->query->rowCount();
        }else
        {
            $this->error = true;
        }
        return $this;
    }


    /**
     * @param $action
     * @param $table
     * @param array $where
     * @return $this|bool
     */
    // [ORDER BY id DESC]
    private function action($action, $table, $where = []){

        if(gettype($where) == 'array' && count($where) === 3){

            $operators = ['=', '<', '>', '<=', '>='];

            $field    = $where[0];
            $operator = $where[1];
            $value    = $where[2];

            if(in_array($operator, $operators)){

                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? ";

                if(!$this->query($sql, [$value])->error()){

                    return $this;
                }
            }
        }else{

            $sql = "{$action} FROM {$table}";
            if(!$this->query($sql, [])->error()){

                return $this;
            }

        }
        return false;
    }

    /**
     * @param $table
     * @param $where
     * @return bool|Db
     */
    function get($table, $where){

        return $this->action('SELECT *', $table, $where);
    }

    /**
     * @param $table
     * @return bool|Db
     */
    function findAll($table){
        return $this->action('SELECT *', $table);
    }


}