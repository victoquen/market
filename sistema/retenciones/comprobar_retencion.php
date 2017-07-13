<?php
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idfactura=$_GET["idfactura"];

$query="SELECT id_retencion FROM retencion WHERE (anulado = 0) AND  id_factura = $idfactura";
$result=mysql_query($query,$conn);

$cont=mysql_num_rows($result);
if($cont>0)
{
    $modificar=1;
    $idretencion=mysql_result($result,0,"id_retencion");
    
    echo "<script>location.href='ver_retencion.php?idretencion=".$idretencion."';</script>";
}
 else {
    $modificar=0;   
    echo "<script>location.href='new_retencion.php?idfactura=".$idfactura."';</script>";
}


?>
