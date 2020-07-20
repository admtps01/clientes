<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'config.php';
$db_connection = new Database();
$conn = $db_connection->dbConnection();

$data = json_decode(file_get_contents("php://input"));

if(isset($data->id)){
    $msg['message'] = '';
    $post_id = $data->id;

    $check_post = "SELECT * FROM `cliente` WHERE id = :post_id";
    $check_post_stmt = $conn->prepare($check_post);
    $check_post_stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    $check_post_stmt->execute();

    if($check_post_stmt->rowCount() > 0){

        $delete_post = "DELETE FROM `cliente` WHERE id = :post_id";
        $delete_post_stmt = $conn->prepare($delete_post);
        $delete_post_stmt->bindValue(':post_id' $post_id, PDO::PARAM_INT);

        if($delete_post_stmt->execute()) {
            $msg['message'] = 'Cliente Eliminado correctamente';
        }else{
            $msg['message'] = 'cliente no eliminado';
        }
    }else{
        $msg['message'] = 'ID invalida';
    }
    echo json_encode($msg);
}
?>