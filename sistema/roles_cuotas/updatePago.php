<?php 
require_once 'db.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
$estado = $data->estado;
$valor = $data->valor;
$final =$data->final;
$usuario =$data->usuario;
$hora =$data->hora;

$query="UPDATE pagos_credito SET  valor=$valor, estado='$estado', fecha_pago='$final', usuario='$usuario', hora='$hora'
 WHERE id=$id";

$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

$result = $mysqli->affected_rows;

echo $json_response = json_encode($result);

?>