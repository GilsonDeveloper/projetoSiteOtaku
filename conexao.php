<?php

$host = 'localhost';
$dbname = 'otaku';
$user = 'root';
$pass = '';

try {

  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $erro) {

    echo "Erro na conexão ou consulta: " . $erro->getMessage();
}


?>