<?php  

$idcodretencion=$_GET["idcodretencion"];

include_once '../conexion/conexion.php';
include_once 'class/codretencion.php';

$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();

$reten= new CodRetencion();
$row = $reten->get_codretencion_id($conn, $idcodretencion);

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
				<div id="tituloForm" class="header">MODIFICAR CODIGO RETENCION</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="save_codretencion.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td>ID</td>
							<td><?php echo $idcodretencion?></td>
						    <td width="42%" rowspan="14" align="left" valign="top"><ul id="lista-errores"></ul></td>
						</tr> 
						<tr>
							<td width="15%">Codigo</td>
							<td width="43%"><input NAME="Acodigo" type="text" class="cajaPequena" id="codigo" value="<?php echo $row['codigo']?>" size="45" maxlength="45"></td>
						</tr> 						
						<tr>
							<td width="15%">Nombre</td>
							<td width="43%"><input NAME="Anombre" type="text" class="cajaGrande" id="nombre" value="<?php echo $row['nombre']?>" size="45" maxlength="45"></td>
						</tr>    
						<tr>
							<td width="15%">Codigo</td>
							<td width="43%"><input NAME="Qporcentaje" type="text" class="cajaPequena" id="porcentaje" value="<?php echo $row['porcentaje']?>" size="45" maxlength="45"></td>
						</tr>	

						<tr>
                                    <td width="15%">Tipo</td>
									<td>
									<select id="Acbotipos" name="Acbotipos" class="comboGrande">
										<?php if($row['tipo'] == "RENTA"){?>
										<option selected value="RENTA">Retenci&oacute;n a la fuente</option>
										<option value="IVA">Retenci&oacute;n IVA</option>
										<?php } else {?>
										<option value="RENTA">Retenci&oacute;n a la fuente</option>
										<option selected value="IVA">Retenci&oacute;n IVA</option>
										<?php }?>
									</select>
									</td>
								</tr>						
					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
					<input id="accion" name="accion" value="modificar" type="hidden">
					<input id="id" name="id" value="" type="hidden">
					<input id="idcodretencion" name="idcodretencion" value="<?php echo $idcodretencion;?>" type="hidden">
			  </div>
			  </form>
		  </div>
		  </div>
		</div>
	</body>
</html>
