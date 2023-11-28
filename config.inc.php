<?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = "kilburnazon";
    try
    {
        $conn = new PDO("mysql:host=$host; dbname=$database" , $username, $password);
        $message = "success";
    }
    catch (PDOException $pe)
    {
        $message = "fail";
    }
?>