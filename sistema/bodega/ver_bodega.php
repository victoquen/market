<?php
include_once '../conexion/conexion.php';
include_once 'class/bodega.php';

$idbodega=$_REQUEST["idbodega"];

$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();

$reten= new bodega();
$row = $reten->get_bodega_id($conn, $idbodega);

?>

<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function aceptar() {
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
				<div id="tituloForm" class="header">VER BODEGA </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>                                            
						
						<tr>
							<td width="15%"><strong>Nombre</strong></td>
							<td width="85%" colspan="2"><?php echo $row['nombre']?></td>
					    </tr> 
						<tr>
							<td width="15%"><strong>Direcci&oacute;n</strong></td>
							<td width="85%" colspan="2"><?php echo $row['porcentaje']?></td>
					    </tr>
						
											
					</table>
                                </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			 </div>
		  </div>
		</div>
	</body>
</html>