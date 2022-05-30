<?php

class LogParserCommand extends CConsoleCommand{

    public $ip;

    public $date;

    public $log;

    public function run($argc){
        $lines = file('/var/log/apache2/access.log', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $this->saveLogLine($line);
        }

        echo "Congrats! All contents in apache2 access log file are saved to mysql database!\n";
    }

    public function saveLogLine($line){
        $this->setProperties($line);

        $connection=Yii::app()->db;
        $sql="INSERT INTO tbl_log (ip, date, log) VALUES(INET_ATON(:ip), STR_TO_DATE(:date, '%d/%b/%Y:%H:%i:%s'), :log)";
        $command=$connection->createCommand($sql);
        $command->bindParam(":ip",$this->ip,PDO::PARAM_STR);
        $command->bindParam(":date",$this->date,PDO::PARAM_STR);
        $command->bindParam(":log",$this->log,PDO::PARAM_STR);
        $command->execute();

    }

    public function setProperties($line)
    {
        $this->ip = $this->getIP($line);
        $this->date = $this->getDateTime($line);
        $this->log = $this->getLog($line);
    }

    public function getIP($line){
        return preg_split('/(\s)/', $line, PREG_SPLIT_DELIM_CAPTURE)[0];
    }

    public function getDateTime($line){
        preg_match("/\[([^\]]*)\]/", $line, $datetime);
        return substr($datetime[1],0, 20);
    }

    public function getLog($line){
        $pos = strpos($line, '"');
        return substr($line, $pos);
    }
}