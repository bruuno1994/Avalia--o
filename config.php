<?php

$host = "localhost"; // nome do servidor MySQL
$user = "id20421070_bruno9537"; // usuário do MySQL
$pass = "kps4015AB***"; // senha do MySQL
$dbname = "id20421070_mini_pi"; // nome do banco de dados

// Conexão com o banco de dados MySQL
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Verifica se houve erro na conexão
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
