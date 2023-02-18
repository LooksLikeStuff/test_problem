<?php

try {

    $host = "localhost";
    $root = "root";
    $pass = "";

    $dbh = new PDO("mysql:host=$host", $root, $pass);

    $dbh->exec("CREATE DATABASE `test_problem`;");

    $dbh = null;

    $dbh = new PDO("mysql:host=$host;dbname=test_problem;", $root, $pass);

    $dbh->exec("CREATE TABLE history( 
        id  INT AUTO_INCREMENT,
        string TEXT NULL,
        PRIMARY KEY(id)
    );");

} catch (PDOException $e) {
    echo $e->getMessage();
}