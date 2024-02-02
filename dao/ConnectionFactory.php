<?php
 
    class ConnectionFactory {

        private $connection;
        
        public static function connect() {
            $database = "games";
            $host = "localhost";
            $user = "root";
            $password = "";
            try {
                $connection = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
            } 
            catch(PDOException $e) {
                die($e->getMessage());
            }
            return $connection;
        }

}