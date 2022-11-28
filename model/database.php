<?php
class Database 
{
    private static $connection;
    
    private function __construct() 
    {
    }

    public static function get_connection() 
    {
        if (!isset(self::$connection)) 
        {
            $ini = parse_ini_file('connection.ini');
            self::$connection = new PDO("mysql:host=".$ini["servername"].";dbname=".$ini["dbname"].";port=".$ini["port"], $ini["username"], $ini["password"]);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        }
        return self::$connection;
    }
}
