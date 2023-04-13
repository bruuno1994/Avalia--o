<?php
header('Access-Control-Allow-Origin: *');

    // Conexão com o Banco de Dados
$connect = new PDO("mysql:host=localhost;dbname=id20421070_mini_pi", "id20421070_bruno9537", "kps4015AB***");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();
if ($received_data->action == 'fetchall') {

    // Início da consulta ao Banco de Dados
    $query = "
 SELECT * FROM fatec_professores 
 ORDER BY salary DESC
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}
    // Código em PHP responsável por inserir um novo professor no Banco de Dados
if ($received_data->action == 'insert') {
    $data = array(
        ':first_name' => $received_data->first_name,
        ':address' => $received_data->address,
        ':course' => $received_data->course,
        ':salary' => $received_data->salary
    );
    // Código em SQL responsável por inserir um novo professor no Banco de Dados
    $query = "
 INSERT INTO fatec_professores 
 (first_name, address, course, salary) 
 VALUES (:first_name, :address, :course, :salary)
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Professor Adicionado'
    );

    echo json_encode($output);
}
if ($received_data->action == 'fetchSingle') {
    $query = "
 SELECT * FROM fatec_professores 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    foreach ($result as $row) {
        $data['id'] = $row['id'];
        $data['first_name'] = $row['first_name'];
        $data['address'] = $row['address'];
        $data['course'] = $row['course'];
        $data['salary'] = $row['salary'];
    }

    echo json_encode($data);
}
if ($received_data->action == 'update') {
    $data = array(
        ':first_name' => $received_data->first_name,
        ':address' => $received_data->address,
        ':course' => $received_data->course,
        ':salary' => $received_data->salary,
        ':id' => $received_data->hiddenId
    );

    $query = "
 UPDATE fatec_professores
 SET first_name = :first_name, 
 address = :address,
 course = :course,
 salary = :salary
 WHERE id = :id
 ";

    $statement = $connect->prepare($query);

    $statement->execute($data);

    $output = array(
        'message' => 'Professor Atualizado'
    );

    echo json_encode($output);
}

if ($received_data->action == 'delete') {
    $query = "
 DELETE FROM fatec_professores 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $output = array(
        'message' => 'Professor Deletado'
    );

    echo json_encode($output);
}

?>