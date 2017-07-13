<?php

require_once 'db2.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));
$id_cuota = $data->id_cuota;
$estado_cuota= $data->estado_cuota;



$query="UPDATE `cuota_legacy`SET`estado_cuota` = $estado_cuota WHERE `id_cuota` = $id_cuota;";
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);


$result = $mysqli->affected_rows;

echo $json_response = json_encode($result);


?>