<?php

namespace App;

use PDO;

class DataBase {
    private static $datasource='mysql:host=localhost;dbname=aviali';
    private static $username='root';
    private static $password='';
    private static $db;

    public static function getConnectToDataBase() {
        if(!isset(self::$db)){
            try{
                self::$db=new PDO(self::$datasource,self::$username,self::$password);
            }
            catch(\Error $e) {
                $trace = $e->getTrace();
                echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
            }

        }

        return self::$db;
    }

}