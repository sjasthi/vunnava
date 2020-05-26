<?php

class Connection
{

    protected $db;
    protected $production;

    function __construct()
    {
        $production = true;// true in production
        $username = "";
        $pass = "";
        if ($production) {
            $username = "metroics_webuser";
            $password = "Dh23HRENtf5N";
            $dbname = "metroics_vunnuva";
        } else {
             $username = "root";
            $password = "";
            $dbname = "pushycart";
        }
        $conn = NULL;
        try {
            $conn = new PDO("mysql:host=localhost;dbname=" . $dbname, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        $this->db = $conn;
    }

    public function getConnection()
    {
        return $this->db;
    }
}