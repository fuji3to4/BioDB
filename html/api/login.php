<?php

$db_user = "user";
$db_pass = "password";
$db_host = "docker-mysql"; 
$db_name = "demo";

$dsn="mysql:host={$db_host};dbname={$db_name};charset=utf8";

try{
        $pdo = new PDO($dsn,$db_user,$db_pass);

        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

} catch(PDOException $Exception){
        die("DB接続エラー:".$Exception->getMessage());

}
?>