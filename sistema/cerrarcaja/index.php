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

?>
<html>
	<head>
		<title>Cobros</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>
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
                                                  <td><input id="fechainicio" type="text" class="cajaPequena" NAME="fechainicio" maxlength="10" value="<?php echo $hoy?>" readonly >
                                                      <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1"  onMouseOver="this.style.cursor='pointer'"  title="Calendario">
                                                        <script type="text/javascript">
                                                            function dateChanged(calendar) {
                                                               if (calendar.dateClicked) {
                                                                   
                                                                   document.getElementById("formulario").submit(); 
                                                               }
                                                               
                                                            };
                                                            
                                                            
                                                            Calendar.setup(
                                                              {
                                                                inputField : "fechainicio",
                                                                ifFormat   : "%d/%m/%Y",
                                                                button     : "Image1",
                                                                onUpdate   : dateChanged
                                                              }
                                                            );
                                                                
                                                        </script>	
                                                  </td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
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
                                                    <iframe width="100%" height="350" id="frame_rejilla" name="frame_rejilla" frameborder="0">
                                                            <ilayer width="100%" height="350" id="frame_rejilla" name="frame_rejilla"></ilayer>
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