<?php 
namespace Core;
use PDO;
use PDOException;

class Database{
    private static ?Database $instance=null;
    private PDO $pdo;
    private function __construct()
    {
        /**
         * A Data Source Name (DSN) is a data structure used in computing, primarily with ODBC (Open Database Connectivity),
         *  that stores connection details—such as driver,
         *  server, database name,
         *  and user credentials—required to connect to a database
         */
        $dsn="mysql:host=".Config::get('DB_HOST').";dbname=".Config::GET('DB_NAME').";charset=utf8mb4";
        /**
         * PDO, or PHP Data Objects, is a lightweight, object-oriented database abstraction layer in PHP, 
         * allowing developers to use a consistent interface for accessing multiple database types (MySQL, PostgreSQL, etc.).
         */
        try {
            //Creates a PDO instance representing a connection to a database
            $this->pdo=new PDO($dsn,Config::get('DB_USER'),Config::get('DB_PASS'),
            //mode for Errors and error handling, and mod for fetching data as assoc array
            //options A key=>value array of driver-specific connection options.
            [
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}