<?php 

class CustomFilter{
    
    private $filter_array;
    private $ranged;
    private $sql;
    public $rows;
    
    function __construct($filter,$ranged=true)
	{
        $this->filter_array = json_decode($filter);
        $this->ranged = $ranged;
        $this->prepareSql();
    }

    function prepareSql(){
        if($this->filter_array[0]->property=='ip'){
            if($this->ranged){
                $this->sql="SELECT INET_NTOA(ip) AS ip, date, log FROM tbl_log WHERE ip BETWEEN INET_ATON('{$this->filter_array[0]->value}') AND INET_ATON('{$this->filter_array[1]->value}')";
            }else{
                $this->sql="SELECT INET_NTOA(ip) AS ip, date, log FROM tbl_log WHERE ip {$this->filter_array[0]->operator} INET_ATON('{$this->filter_array[0]->value}')";
            }
        }else{
            if($this->ranged){
                $this->sql = "SELECT INET_NTOA(ip) AS ip, date, log FROM tbl_log WHERE DATE(date) BETWEEN '{$this->filter_array[0]->value}' AND '{$this->filter_array[1]->value}'";
            }else{
                $this->sql = "SELECT INET_NTOA(ip) AS ip, date, log FROM tbl_log WHERE DATE(date) {$this->filter_array[0]->operator} '{$this->filter_array[0]->value}'";
            }
        }
        return $this->sql;
    }

    function queryFilter(){
        $connection=Yii::app()->db;
        $command=$connection->createCommand($this->prepareSql());
        $dataReader = $command->query();
        $this->rows = $dataReader->readAll();
    }


    function getRows(){
        $this->queryFilter();
        return $this->rows;
    }

    function getRowCount(){
        return count($this->getRows());
    }
}