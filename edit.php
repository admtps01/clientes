<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'config.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

$data = json_decode(file_get_contents("php://input"));
if(isset($data->id)){
	$msg['message'] = '';
	$post_id = $data->id;

	$get_post = "SELECT * FROM `cliente` WHERE id=:post_id";
	$get_stmt = $conn->prepare($get_post);
	$get_stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
	$get_stmt->execute();

	if($get_stmt->rowCount() > 0){
		$row = $get_stmt->fetch(PDO::FETCH_ASSOC);

		$post_nombre = isset($data->nombre) ? $data->nombre : $row['nombre'];
		$post_apellido = isset($data->apellido) ? $data->apellido : $row['apellido'];
		$post_correo = isset($data->correo) ? $data->correo : $row['correo'];
		$post_celular = isset($data->celular) ? $data->celular : $row['celular'];

		$update_query = "UPDATE `cliente` SET nombre = :nombre, apellido = :apellido, correo = :correo, celular = :celular WHERE id = :id";
		$update_stmt = $conn->prepare($update_query);

		$update_stmt->bindValue(':nombre',htmlspecialchars(strip_tags($post_nombre)),PDO::PARAM_STR);
		$update_stmt->bindValue(':apellido',htmlspecialchars(strip_tags($post_apellido)),PDO::PARAM_STR);
		$update_stmt->bindValue(':correo',htmlspecialchars(strip_tags($post_correo)),PDO::PARAM_STR);
		$update_stmt->bindValue(':celular',htmlspecialchars(strip_tags($post_celular)),PDO::PARAM_STR);
		$update_stmt->bindValue(':id', $post_id, PDO::PARAM_INT);
		if($update_stmt->execute()){
			$msg['message'] = 'Datos Actualizados Correctamente';
		}else{
			$msg['message'] = 'datos no encontrados';
		}
	}else{
		$msg['message'] = 'ID Invalido';
	}
	echo json_encode($msg);
}
?>