<?php

class CustomGroupBy{
    private $sql;
    public $rows;

    function __construct()
	{
        $this->prepareSql();
    }

    function prepareSql(){
        $this->sql = "SELECT INET_NTOA(ip) AS ip, COUNT(ip) AS ip_count FROM tbl_log GROUP BY ip";
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