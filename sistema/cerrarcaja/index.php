<?php
//error_reporting(0);
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

//$cadena_busqueda=$_GET["cadena_busqueda"];

/*if (!isset($cadena_busqueda)) { $cadena_busqueda=""; } else { $cadena_busqueda=str_replace("",",",$cadena_busqueda); }

if ($cadena_busqueda<>"") {
	$fechainicio=$array_cadena_busqueda[1];
} else {
	$fechainicio="";
}*/

$hoy=date("d/m/Y");

$idruc = 1;
//datos factureros existentes
$query_o = "SELECT * FROM facturero WHERE id_ruc= $idruc";
$res_o = mysql_query($query_o, $conn);

session_start();
//id facturero segun el usuario de la sesion
$id_facturero=$_SESSION['id_facturero'];
$tipo=$_SESSION['tipo'];
?>
<html>
	<head>
		<title>Cobros</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<!-- INICIO ARCHIVOS CALENDARIO -->
		<link rel="stylesheet" href="../css/jquery-ui.css"/>
		<link rel="stylesheet" href="../css/jquery-ui.min.css"/>
		<link rel="stylesheet" href="../css/jquery-ui.structure.css"/>
		<link rel="stylesheet" href="../css/jquery-ui.structure.min.css"/>
		<script src="../js/jquery-1.12.4.js"></script>
		<script src="../js/1.12.1_jquery-ui..js"></script>
		<script language="javascript">
			$(function () {
				$("#fechainicio").datepicker({
					changeMonth: true,
					changeYear: true,
					dateFormat: 'dd/mm/yy',
					showOn: "button",
					buttonImage: "../img/calendario.png",
					buttonImageOnly: true,
					buttonText: "Seleccionar Fecha"
				});
			});

			function dateChanged() {
				document.getElementById("formulario").submit();
			}
			;

		</script>
		<!-- FIN ARCHIVOS CALENDARIO -->
		<script language="javascript">
		
		var cursor;
		if (document.all) {
		// Est� utilizando EXPLORER
		cursor='hand';
		} else {
		// Est� utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		function inicio() {
			document.getElementById("formulario").submit();
		}
		
		function buscar() {                    
			document.getElementById("formulario").submit();
		}
		
                
                function buscar1() {			
			alert("func");
		}
                
		function hacer_cadena_busqueda() {			
			var fechainicio=document.getElementById("fechainicio").value;
			var cadena="";
			cadena="~"+fechainicio+"~";
			return cadena;
			}
		</script>
	</head>
	<body onLoad="inicio()">
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">Buscar FECHA</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="rejilla.php" target="frame_rejilla">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>					
					  <tr>
						  <td>Fecha de cierre</td>
                                                  <td>
													  <input id="fechainicio" type="text" class="cajaPequena" NAME="fechainicio"
															 maxlength="10" value="<?php echo date("d/m/Y") ?>" readonly onchange="dateChanged()"/>



                                                  </td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>

						  <td width="6%"><b>FACTURERO:</b></td>
						  <td>
							  <select id="facturero" class="comboMedio" NAME="facturero" onchange="dateChanged()">
								  <?php
								  $contador = 0;
								  while ($contador < mysql_num_rows($res_o)) {
									  if (mysql_result($res_o, $contador, "id_facturero") == $idfacturero) {
										  ?>
										  <option selected
												  value="<?php echo mysql_result($res_o, $contador, "id_facturero") ?>"><?php echo mysql_result($res_o, $contador, "serie1") . '-' . mysql_result($res_o, $contador, "serie2") ?></option>


									  <?php } else {
										  if ($tipo == "administrador") {
											  ?>
											  <option
												  value="<?php echo mysql_result($res_o, $contador, "id_facturero") ?>"><?php echo mysql_result($res_o, $contador, "serie1") . '-' . mysql_result($res_o, $contador, "serie2") ?></option>
										  <?php }
									  }
									  $contador++;
								  } ?>
							  </select>

						  </td>
					  </tr>
					</table>
                                </form>
                                </div>
                               
			 	<div id="botonBusqueda">
                                    <!--<img src="../img/botonbuscar.jpg" width="69" height="22" border="1" onClick="buscar()" onMouseOver="style.cursor=cursor">-->
			  <div id="lineaResultado">
			  <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
			  	<tr>
                                    <td><div id="lineaResultado" class="header">DETALLES CIERRE CAJA</div></td>				
                                </tr>
				
				
				<!--<input type="hidden" id="cadena_busqueda" name="cadena_busqueda">-->
			
                                <tr>
                                    <td>
                                    
                                            <div id="lineaResultado">
                                                    <iframe width="100%" height="1500" id="frame_rejilla" name="frame_rejilla" frameborder="0">
                                                            <ilayer width="100%" height="1400" id="frame_rejilla" name="frame_rejilla"></ilayer>
                                                    </iframe>
                                            </div>
                                            <iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
                                                    <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
                                            </iframe>
                                    </td>
                                </tr>
                        </table>
                              </div>
		  </div>			
		</div>
                </div>
                </div>
	</body>
</html>
