<?php

/**
 * Created by PhpStorm.
 * User: Rheola
 * Date: 31.08.16
 * Time: 17:04
 */
class DbCommand{

    public $pdo;


    public function __construct(){
        $connect_string = sprintf('sqlite:%s/../../application/database/database.db', __DIR__);
        $this->pdo = new PDO($connect_string);
    }

    /**
     * @param $table
     * @param null $order
     * @return array|bool
     */
    public function selectAll($table, $params = []){

        $where = null;
        if(isset($params['where'])){
            $where = $params['where'];
        }
        $order = null;
        if(isset($params['order'])){
            $order = $params['order'];
        }
        $query = $this->pdo->query($this->select_context($table, $where, $order));

        if(!$query){
            return false;
        }

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function select_context($table, $where, $order){
        $text = 'SELECT * FROM '.$table;
        if($where != null){
            $text .= ' where '.$where;
        }
        if($order !== null){
            $text .= ' order by '.$order;
        }

        return $text;
    }

    public function insert($table, $data){
        foreach($data as $key => $value){
            if(strpos($key, '_') === 0){

                continue;
            }
            if($value === null){
                continue;
            }

            $columns[] = preg_replace("/^(\(JSON\)\s*|#)/i", "", $key);

            switch(gettype($value)){
                case 'NULL':
                    $values[] = 'NULL';
                    break;
                case 'boolean':
                    $values[] = ($value ? '1' : '0');
                    break;

                case 'integer':
                case 'double':
                case 'string':
                    $values[] = $this->fn_quote($key, $value);
                    break;
            }
        }

        $query = 'INSERT INTO '.$table.' ('.implode(', ', $columns).') VALUES ('.implode($values, ', ').')';


        return $this->pdo->exec($query);
    }

    public function update($table, $id, $params){
        $data = [];
        foreach($params as $key => $value){
            if(strpos($key, '_') === 0){
                continue;
            }
            if($value === null){
                continue;
            }
            if($key === 'id'){
                continue;
            }
            switch(gettype($value)){
                case 'NULL':
                    $value = 'NULL';
                    break;
                case 'boolean':
                    $value = ($value ? '1' : '0');
                    break;

                case 'integer':
                case 'double':
                case 'string':
                    $value = $this->fn_quote($key, $value);
                    break;
            }

            $data[] = sprintf('%s = %s', $key, $value);
        }

        $fields = implode(', ', $data);

        $query = sprintf('update %s  set %s where id=%d', $table, $fields, $id);


        return $this->pdo->exec($query);
    }

    protected function fn_quote($column, $string){
        return (strpos($column, '#') === 0 && preg_match('/^[A-Z0-9\_]*\([^)]*\)$/', $string)) ?
            $string :
            $this->pdo->quote($string);
    }
}