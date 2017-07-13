<?php  

$idbodega=$_GET["idbodega"];

include_once '../conexion/conexion.php';
include_once 'class/bodega.php';

$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();

$reten= new Bodega();
$row = $reten->get_bodega_id($conn, $idbodega);

?>
<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
             
		<script type="text/javascript" src="../js/validar.js"></script>
		<script language="javascript">
		
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
		
		function limpiar() {
			document.getElementById("formulario").reset();
		}
	
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">MODIFICAR BODEGA</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="save_bodega.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td>ID</td>
							<td><?php echo $idbodega?></td>
						    <td width="42%" rowspan="14" align="left" valign="top"><ul id="lista-errores"></ul></td>
						</tr> 										
						<tr>
							<td width="15%">Nombre</td>
							<td width="43%"><input NAME="Anombre" type="text" class="cajaGrande" id="nombre" value="<?php echo $row['nombre']?>" size="200" maxlength="200"></td>
						</tr>    
						<tr>
							<td width="15%">Direcci&oacute;n</td>
							<td width="43%"><input NAME="Adireccion" type="text" class="cajaGrande" id="direccion" value="<?php echo $row['direccion']?>" size="500" maxlength="500"></td>
						</tr>	

					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
					<input id="accion" name="accion" value="modificar" type="hidden">
					<input id="id" name="id" value="" type="hidden">
					<input id="idbodega" name="idbodega" value="<?php echo $idbodega;?>" type="hidden">
			  </div>
			  </form>
		  </div>
		  </div>
		</div>
	</body>
</html>
