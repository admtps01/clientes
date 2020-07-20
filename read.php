<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

require 'config.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

//verificacion
if(isset($_GET['id']))
{
	//id parametro
	$post_id = filter_var($_GET['id'], FILTER_VALIDATE_INT,[
		'options' => [
			'default' =>'all_post',
			'min_range' => 1
		]
	]);
}
else {
	$post_id = 'all_post';
}
//hacer consulta
$sql = is_numeric($post_id) ? "SELECT * FROM `cliente` WHERE id='$post_id'" : "SELECT * FROM `cliente`";
$stmt = $conn->prepare($sql);
$stmt->execute();

if($stmt->rowCount() > 0){
	$cliente_array = [];
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$post_data = [
			'id' => $row['id'],
			'nombre' => $row['nombre'],
			'apellido' => $row['apellido'],
			'correo' => $row['correo'],
			'celular' => $row['celular']
		];
		array_push ($cliente_array, $post_data);
	}
	echo json_encode($cliente_array);
}
else {
	echo json_encode(['message'=>'Cliente No Encontrado']);
}
?>