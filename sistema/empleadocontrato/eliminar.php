<?php

$idrelacion_empleado_contrato=$_REQUEST["idrelacion_empleado_contrato"];

include_once '../conexion/conexion.php';
include ("../js/fechas.php");
include_once 'class/Relacion_empleado_contrato.php';

$db = new ServidorBaseDatos();
$conn = $db->getConexion();

$relacion_empleado_contrato = new Relacion_empleado_contrato();
$row = $relacion_empleado_contrato->get_id($conn, $idrelacion_empleado_contrato);

$rowempleado = $relacion_empleado_contrato->get_leyenda_empleado($conn,$row['id_empleado']);
$leyendaempleado = $rowempleado['leyendaempleado'];

$rowcontrato = $relacion_empleado_contrato->get_leyenda_contrato($conn,$row['id_contrato']);
$leyendacontrato = $rowempleado['leyendacontrato'];

if($row['activo'] == 0){
	$leyendaactivo = "NO";
}else{
	$leyendaactivo = "SI";
}

?>

<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function aceptar(idrelacion_empleado_contrato) {
			location.href="save.php?idrelacion_empleado_contrato=" + idrelacion_empleado_contrato + "&accion=baja";
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
				<div id="tituloForm" class="header">ELIMINAR empleado contrato </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="15%"><strong>Empleado</strong></td>
							<td width="85%" colspan="2"><?php echo $leyendaempleado ?></td>
						</tr>
						<tr>
							<td width="15%"><strong>Contrato</strong></td>
							<td width="85%" colspan="2"><?php echo $leyendacontrato ?></td>
						</tr>
						<tr>
							<td width="15%"><strong>Fecha Inicio</strong></td>
							<td width="85%" colspan="2"><?php echo implota($row['fecha_inicio']) ?></td>
						</tr>
						<tr>
							<td width="15%"><strong>Fecha Fin</strong></td>
							<td width="85%" colspan="2"><?php echo implota($row['fecha_fin']) ?></td>
						</tr>

						<tr>
							<td width="15%"><strong>Codigo Contrato</strong></td>
							<td width="85%" colspan="2"><?php echo $row['codigo'] ?></td>
						</tr>

						<tr>
							<td width="15%"><strong>Sueldo</strong></td>
							<td width="85%" colspan="2"><?php echo $row['sueldo'] ?></td>
						</tr>

						<tr>
							<td width="15%"><strong>Activo</strong></td>
							<td width="85%" colspan="2"><?php echo $leyendaactivo ?></td>
						</tr>
					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php echo $idrelacion_empleado_contrato?>)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			  </div>
		  </div>
		</div>
	</body>
</html>
