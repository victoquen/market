<?php 
require_once 'db.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));
$id_contrato = $data->id_contrato;
$descripcion_pago = $data->descripcion_pago;
$fecha_maxima = $data->fecha_maxima;
$estado = $data->estado;
$valor = $data->valor;


$query="INSERT INTO pagos_credito` (`id_contrato`, `descripcion_pago`, `fecha_maxima`, `estado`, `valor`)
 VALUES ('$id_contrato', '$descripcion_pago', '$fecha_maxima', '$estado', '$valor');";

$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

$result = $mysqli->affected_rows;

echo $json_response = json_encode($result);

?>