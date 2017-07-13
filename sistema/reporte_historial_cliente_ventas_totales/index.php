
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
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		
		function inicio() {
			document.getElementById("formulario").submit();
		}
		
		function buscar() {
			
			document.getElementById("formulario").submit();
		}
				
		function limpiar() {
			document.getElementById("formulario").reset();
		}
		</script>
	</head>
	<body onLoad="inicio()">
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">HISTORIAL VENTAS POR TIPO DE CLIENTE TOTALES</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="rejilla.php" target="frame_rejilla">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                            <tr>
                                              <td align="right">Tipo Cliente:</td>
                                              <td>
                                                  <select id="tipoCliente" name="tipoCliente" >
                                                      <option value="CF">Cliente Final</option>
                                                      <option value="DS">Distribuidor</option>
                                                  </select>                                                                                                                                                 
                                              </td>
                                          </tr>
					  <tr>
						  <td align="right" >Fecha de Inicio</td>
						  <td ><input id="fechainicio" type="text" class="cajaPequena" NAME="fechainicio" maxlength="10" readonly><img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario">
        <script type="text/javascript">
					function dateChanged(calendar) 
                                        {
                                            if (calendar.dateClicked) {

                                                document.getElementById("formulario").submit(); 
                                            }

                                         };
                                        
                                        Calendar.setup(
					{
                                            inputField : "fechainicio",
                                            ifFormat   : "%d/%m/%Y",
                                            button     : "Image1",
                                            //onUpdate   : dateChanged
					}
					);
		</script>	</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
						<tr>
						  <td align="right">Fecha de Fin</td>
						  <td><input id="fechafin" type="text" class="cajaPequena" NAME="fechafin" maxlength="10" value="<?php echo date("d/m/Y")?>" readonly><img src="../img/calendario.png" name="Image2" id="Image2" width="16" height="16" border="0"  onMouseOver="this.style.cursor='pointer'">
        <script type="text/javascript">
					Calendar.setup(
					{
                                            inputField : "fechafin",
                                            ifFormat   : "%d/%m/%Y",
                                            button     : "Image2",
                                            //onUpdate   : dateChanged
					}
					);
		</script></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>                                                                                                    
					  </tr>
                                          
                                          <tr>
                                              <td align="right">
                                                  <input type="submit" value="Buscar"/>
                                              </td>
                                          </tr>
					</table>
			  </div>
					<div id="botonBusqueda">
                                            <!--<img src="../img/botonbuscar.jpg" width="69" height="22" border="1" onClick="buscar()" onMouseOver="style.cursor=cursor">-->
			 	  <img src="../img/botonlimpiar.jpg" width="69" height="22" border="1" onClick="limpiar()" onMouseOver="style.cursor=cursor">	
				</div>
			 
				<div id="cabeceraResultado" class="header">
					relacion de MOVIMIENTOS </div>
				<div id="frmResultado">				
			</form>
				<div id="lineaResultado">
					<iframe width="100%" height="350" id="frame_rejilla" name="frame_rejilla" frameborder="0">
						<ilayer width="100%" height="350" id="frame_rejilla" name="frame_rejilla"></ilayer>
					</iframe>
				</div>
				<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>
				</div>
		  </div>			
		</div>
                </div>
	</body>
</html>
