<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', ''); 
define('DATABASE', 'leavedb');
function db()
{
    try {
        $conn = new PDO('mysql:host='.HOST.';dbname='.DATABASE.'', USER, PASSWORD);
        return $conn;
    } catch (PDOException $e) {
        return "Error!: " . $e->getMessage();
        die();
    }
}
?>