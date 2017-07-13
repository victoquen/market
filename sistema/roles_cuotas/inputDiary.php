<?php
require_once 'db2.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));
$idfactura= $data->id_factura;
$idcliente =$data->id_cliente;
$importe = $data->importe;
$fechacobro = $data->fechacobro;


$query="INSERT INTO cobros (id_factura,id_cliente,importe,id_formapago,fechacobro,observaciones) VALUES
('$idfactura','$idcliente','$importe','1','$fechacobro','pago cuota')";

$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

$result = $mysqli->affected_rows;

echo $json_response = json_encode($result);

?>