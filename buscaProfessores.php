<?php

header('Access-Control-Allow-Origin: *');
// Fazendo a conexão com o Banco de Dados

$connect = new PDO("mysql:host=localhost;dbname=id20421070_mini_pi", "id20421070_bruno9537", "kps4015AB***");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

if($received_data->query != '')
// Consultando o Banco de Dados com fitro por nome
{
	$query = "
	SELECT * FROM fatec_professores 
	WHERE first_name LIKE '%".$received_data->query."%' 
	OR last_name LIKE '%".$received_data->query."%' 
	ORDER BY id DESC
	";
}
else
// Consultando o Banco de Dados sem filtro por nome
{
	$query = "
	SELECT * FROM fatec_professores
	ORDER BY salary DESC
	";
}

$statement = $connect->prepare($query);

$statement->execute();

while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$data[] = $row;
}

echo json_encode($data);

?>