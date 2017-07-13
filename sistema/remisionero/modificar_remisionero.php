<?php   

$idremisionero='1';

include_once '../conexion/conexion.php';
include_once 'class/remisionero.php';
include ("../js/fechas.php");
$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();

$remisionero= new remisionero();
$row = $remisionero->get_remisionero_id($conn, $idremisionero);

?>
<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">

                <link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>


             
		<script type="text/javascript" src="../js/validar.js"></script>
                <script type="text/javascript" src="../js/fechas.js"></script>
		<script language="javascript">
		
		function cancelar() {
			location.href="../central2.php";
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
                                    <div id="tituloForm" class="header">ACTUALIZAR DATOS GUIA DE REMISION</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="save_remisionero.php">
					<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
						                                             
						<tr>
                                                    <td width="10%">Tipo Servicio</td>
                                                    <td width="43%"><input NAME="Aserie1" type="text" class="cajaMedia" id="serie1" value="<?php  echo $row['serie1']?>"></td>
                                                     <td width="42%" rowspan="6" align="left" valign="top"><ul id="lista-errores"></ul></td>
                                                </tr>
                                                <tr>
                                                    <td width="10%">No. Local</td>
                                                    <td width="43%"><input NAME="Aserie2" type="text" class="cajaMedia" id="serie2" value="<?php  echo $row['serie2']?>"></td>

                                                </tr>
                                                <tr>
                                                    <td width="10%">Autorizaci&oacute;n</td>
                                                    <td width="43%"><input NAME="Aautorizacion" type="text" class="cajaMedia" id="autorizacion" value="<?php  echo $row['autorizacion']?>" size="45" maxlength="45"></td>

                                                </tr>
                                                <tr>
                                                    <td width="10%">Serie Inicio</td>
                                                    <td width="43%"><input NAME="Ainicio" type="text" class="cajaMedia" id="inicio" value="<?php  echo $row['inicio']?>" size="45" maxlength="45"></td>

                                                </tr>
                                                <tr>
                                                    <td width="10%">Serie Fin</td>
                                                    <td width="43%"><input NAME="Afin" type="text" class="cajaMedia" id="fin" value="<?php  echo $row['fin']?>" size="45" maxlength="45"></td>

                                                </tr>
                                                <tr>
                                                    
                                                     <td width="10%">Fecha Vencto.</td>
						    <td width="43%"><input NAME="afecha_caducidad" type="text" class="cajaPequena" id="fecha_caducidad" size="10" maxlength="10" value="<?php  echo implota($row['fecha_caducidad'])?>" readonly> <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'">
                                                        <script type="text/javascript">
                                                                                Calendar.setup(
                                                                                  {
                                                                                inputField : "fecha_caducidad",
                                                                                ifFormat   : "%d/%m/%Y",
                                                                                button     : "Image1"
                                                                                  }
                                                                                );
                                                        </script></td>

                                                </tr>
					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1" onMouseOver="style.cursor=cursor">					
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
					<input id="accion" name="accion" value="modificar" type="hidden">
					<input id="id" name="id" value="" type="hidden">
					<input id="idremisionero" name="idremisionero" value="<?php  echo $idremisionero?>" type="hidden">
			  </div>
			  </form>
		  </div>
		  </div>
		</div>
	</body>
</html>
