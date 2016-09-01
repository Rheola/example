<?php

/**
 * Created by PhpStorm.
 * User: Rheola
 * Date: 31.08.16
 * Time: 10:43
 */
class Model{
    public $id;
    private $_isNewRecord;
    private $_errors = [];


    public function __construct(){
        $this->_isNewRecord = true;
    }

    public static function tableName(){
        return strtolower(self::class);
    }


    public function addError($error){
        $this->_errors[] = $error;
    }


    /**
     * @return mixed
     */
    public function getErrors(){

        $data = '';

        foreach($this->_errors as $error){
            $data .= '<li>'.$error.'</li>';
        }

        return $data;

    }

    public function hasErrors(){
        return count($this->_errors) > 0;
    }


    public function isNewRecord(){
        return $this->_isNewRecord;
    }

    /**
     * @param $id
     * @return Review
     */
    public static function findOne($table, $id){

        $command = new DbCommand();
        $rawData = $command->selectAll($table,
            ['where' => 'id = '.$id]
        );
        if($rawData === false){
            return null;
        }

        if(count($rawData) == 0){
            return null;

        }

        $data = [];


        foreach($rawData as $item){
            $model = new Review();
            $model->_isNewRecord = false;
            foreach($item as $field => $value){
                $model->$field = $value;
            }
            $data[] = $model;
        }
        if(count($data > 0)){

            return $data[0];
        }

        return null;
    }

    public function save($table){
        $command = new DbCommand();
        $fields = [];

        if($this->isNewRecord()){
            $this->creation_date = date('Y-m-d H:i:s', time());
            foreach($this as $key => $value){
                $fields[$key] = $value;
            }

            $result = $command->insert($table, $fields);

            $this->id = $command->pdo->lastInsertId();
            if($result){
                $this->_isNewRecord = false;
            }

            return $result;


        } else{
            foreach($this as $key => $value){
                $fields[$key] = $value;
            }

            return $command->update($table, $this->id, $fields);
        }
    }

}