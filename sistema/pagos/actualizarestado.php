<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 
?>
<html>
<head>
</head>
<?php
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();
 ?>
<body>
<?php
	$estado=$_GET["estado"];
	$idfactura=$_GET["idfactura"];
	$act_factura="UPDATE facturasp SET estado='$estado' WHERE id_facturap='$idfactura'";
	$rs_act=mysql_query($act_factura,$conn);
?>
</body>
</html>
