<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conexion/conexion.php");
include ("../js/fechas.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idruc=$_POST["idruc"];
$idfacturero=$_POST["idfacturero"];

$establecimiento=$_POST["establecimiento"];
$tiposervicio=$_POST["tiposervicio"];
$serieinicio=$_POST["serieinicio"];
$seriefin=$_POST["seriefin"];
$autorizacion=$_POST["autorizacion"];
$fecha_caducidad= explota($_POST["fecha_caducidad"]);


$consulta = "UPDATE facturero SET  serie1 = '$establecimiento', serie2 = '$tiposervicio',autorizacion = '$autorizacion',
                                        inicio = '$serieinicio', fin = '$seriefin', fecha_caducidad = '$fecha_caducidad'
                  WHERE (id_facturero = '$idfacturero') AND (id_ruc = '$idruc') ";
$rs_consulta = mysql_query($consulta, $conn);
//echo "<script> parent.location.href='frame_telefonos_final.php?idproveedor=".$idproveedor."';</script>";


?>