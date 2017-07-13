<?php

$idusuario=$_REQUEST["idusuario"];

include_once '../conexion/conexion.php';
include_once 'class/usuario.php';

$db = new ServidorBaseDatos();
$conn = $db->getConexion();

$usuario = new usuario();
$row = $usuario->get_id($conn, $idusuario);

$leyendafacturero = "CONTROL TOTAL";
if($row['id_facturero']!=-1){
	$rowfacturero = $usuario->get_leyenda_facturero($conn,$row['id_facturero']);
	$leyendafacturero = $rowfacturero['leyendafacturero'];
}

$rowbodega = $usuario->get_leyenda_bodega($conn,$row['id_bodega']);
$leyendabodega = $rowbodega['nombre'];
?>

<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function aceptar(idusuario) {
			location.href="save.php?idusuario=" + idusuario + "&accion=baja";
		}
		
		function cancelar() {
			location.href="index.php";
		}
		
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">ELIMINAR ENTIDAD BANCARIA </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="15%"><strong>Nombre</strong></td>
							<td width="85%" colspan="2"><?php echo $row['nombre'] ?></td>
						</tr>
						<tr>
							<td width="15%"><strong>Password</strong></td>
							<td width="85%" colspan="2"><?php echo $row['password'] ?></td>
						</tr>
						<tr>
							<td width="15%"><strong>Tipo</strong></td>
							<td width="85%" colspan="2"><?php echo $row['tipo'] ?></td>
						</tr>
						<tr>
							<td width="15%"><strong>Facturero</strong></td>
							<td width="85%" colspan="2"><?php  echo $leyendafacturero ?></td>
						</tr>
						<tr>
							<td width="15%"><strong>Bodega-Sucursal</strong></td>
							<td width="85%" colspan="2"><?php  echo $leyendabodega ?></td>
						</tr>
					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php echo $idusuario?>)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			  </div>
		  </div>
		</div>
	</body>
</html>
