<?php


//Добавление строки в базу данных и получение истории введенных строк
try{
    $dbh = new PDO("mysql:host=localhost;dbname=test_problem", "root", "");

    $sth = $dbh->prepare("INSERT INTO history(string) VALUES(:string)");
    $sth->execute(["string"=> $string]);

    $sth = $dbh->prepare("SELECT string FROM history");
    $sth->execute();

    $history = $sth->fetchAll(PDO::FETCH_COLUMN, 0);

} catch(PDOException $e) {
    echo $e->getMessage();
}