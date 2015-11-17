<?php

$con = 'localhost';
$banco = 'gestor_web';
$usuario = 'root';
$senha   = '';

//$con = 'mysql.hostinger.com.br';
//$banco = 'u858834861_gd';
//$usuario = 'u858834861_cesar';
//$senha   = 'cesark123';

$pdo = new PDO("mysql:host=$con;dbname=$banco", "$usuario", "$senha");
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

?>