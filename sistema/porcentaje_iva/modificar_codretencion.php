<?php

$id=$_REQUEST["id"];

include_once '../conexion/conexion.php';
include_once 'class/porcentaje_iva.php';

$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();

$reten= new Porcentaje_iva();
$row = $reten->get_iva_id($conn, $id);

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

		function validarForm(){
			var mensaje = "";


			if (document.getElementById("porcentaje").value == "") mensaje += "  - Ingresar procentaje\n";
			if (document.getElementById("Acbotipos").value == "") mensaje += "  - Escoger activo\n";

			if (mensaje != "") {
				alert("Atencion, se han detectado las siguientes incorrecciones:\n\n" + mensaje);
			} else {

				document.getElementById("formulario").submit();
				document.getElementById("porcentaje").value = "";
				document.getElementById("Acbotipos").value = 0;

			}

		}
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">MODIFICAR CODIGO IVA</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="save_codretencion.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td>ID</td>
							<td><?php echo $id?></td>
						    <td width="42%" rowspan="14" align="left" valign="top"><ul id="lista-errores"></ul></td>
						</tr> 

						<tr>
							<td width="15%">Codigo</td>
							<td width="43%"><input NAME="porcentaje" type="text" class="cajaPequena" id="porcentaje" value="<?php echo $row['porcentaje']?>" size="45" maxlength="45"></td>
						</tr>	

						<tr>
                                    <td width="15%">Tipo</td>
									<td>
									<select id="Acbotipos" name="Acbotipos" class="comboGrande">
										<?php if($row['activo'] == "0"){?>
										<option selected value="0">NO</option>
										<option value="1">SI</option>
										<?php } else {?>
											<option  value="0">NO</option>
											<option selected value="1">SI</option>
										<?php }?>
									</select>
									</td>
								</tr>						
					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validarForm()" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
					<input id="accion" name="accion" value="modificar" type="hidden">
					<input id="id" name="id" value="" type="hidden">
					<input id="id" name="id" value="<?php echo $id;?>" type="hidden">
			  </div>
			  </form>
		  </div>
		  </div>
		</div>
	</body>
</html>
