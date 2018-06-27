<?php
// PHP database connection file.
error_reporting(1);
class Database {
    private static $dbName = 'kiitquestionbank' ;
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'root';
    private static $dbUserPassword = '';

    private static $cont  = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect() {
       // One connection through whole application
       if ( null == self::$cont ) {
        try {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
        } catch(PDOException $e) {
          die($e->getMessage());
        }
       }
       return self::$cont;
    }

     //Disconnection after complete the db task.
    public static function disconnect() {
        self::$cont = null;
    }
}

?>
