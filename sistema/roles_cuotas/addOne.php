<?php 
require_once 'db.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));
$id_contrato_empleado= $data->id_contrato_empleado;
$seguro =$data->seguro;
$sueldo = $data->sueldo;
$descuento = $data->descuento;
$comision = $data->comision;
$total_dias = $data->total_dias;
$total_pagar = $data->total_pagar;
$mes = $data->mes;
$anio = $data->anio;
$dias_no_laborados = $data->dias_no_laborados;

$query="INSERT INTO rol_pago` (`id_relacion_empleado_contrato`, `seguro`, `sueldo`, `descuento`, `comision`, `total_dias`, `total_pagar`, `mes`, `anio`, `borrado`, `dias_no_laborados`)
 VALUES ('$id_contrato_empleado', '$seguro', '$sueldo', '$descuento', '$comision', '$total_dias', '$total_pagar', '$mes', '$anio', '0', '$dias_no_laborados');";

$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

$result = $mysqli->affected_rows;

echo $json_response = json_encode($result);

?>