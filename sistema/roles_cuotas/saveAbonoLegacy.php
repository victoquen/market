<?php

require_once 'db2.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));
$id_cuota = $data->id_cuota;
$id_usuario= $data->id_usuario;
$costo= $data->costo;
$fecha_abono= $data->fecha_abono;
$numero_comprobante= $data->numero_comprobante;
$interes_mora= $data->interes_mora;
$dias_mora= $data->dias_mora;
$costo_cobrado= $data->costo_cobrado;
$observacion= $data->observacion;
$hora= $data->hora;


$query="INSERT INTO `abono_legacy`(`id_cuota`,`id_usuario`,`costo`,`fecha_abono`,`numero_comprobante`,`interes_mora`,`dias_mora`,`costo_cobrado`,`observacion`,`hora`)VALUES
($id_cuota ,$id_usuario ,$costo ,'$fecha_abono' ,$numero_comprobante ,$interes_mora ,$dias_mora ,$costo_cobrado ,'$observacion' ,'$hora' );";
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

//$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

$result = $mysqli->affected_rows;

echo $json_response = json_encode($result);


?>