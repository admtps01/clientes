<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'config.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

$data = json_decode(file_get_contents("php://input"));

$msg['message'] = '';

if(isset($data->nombre) && isset($data->apellido) && isset($data->correo) && isset($data->celular)){

	if(!empty($data->nombre) && !empty($data->apellido) && !empty($data->correo) && !empty($data->celular)){
	$inset_query = "INSERT INTO `cliente` (nombre,apellido,correo,celular) VALUES(:nombre,:apellido,:correo,:celular)";
	$insert_stmt = $conn->prepare($inset_query);

	$insert_stmt->bindValue(':nombre', htmlspecialchars(strip_tags($data->nombre)),PDO::PARAM_STR);
	$insert_stmt->bindValue(':apellido', htmlspecialchars(strip_tags($data->apellido)),PDO::PARAM_STR);
	$insert_stmt->bindValue(':correo', htmlspecialchars(strip_tags($data->correo)),PDO::PARAM_STR);
	$insert_stmt->bindValue(':celular', htmlspecialchars(strip_tags($data->celular)),PDO::PARAM_STR);

		if($insert_stmt->execute()){
			$msg['message'] = 'Datos Insertados Correctamente';
		}else {
			$msg['messahe'] = 'Datos no Insertados';
		}
	}else{
		$msg['message'] = 'Oops! hay un campo desocupado. Por Favor diligenciar todos los campos.';
	}
}else{$msg['message'] = 'Por favor diligenciar todos los campos | nombre,apellido,correo,celular';	}
echo json_encode($msg);
?>