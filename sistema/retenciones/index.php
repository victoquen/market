<html>
	<head>
		<title>RETENCIONES</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
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
			document.getElementById("form_busqueda").submit();
		}
		
		function nuevo_retencion() {
			location.href="new_retencion.php";
		}		
		</script>
	</head>
	<body onLoad="inicio()">
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">RETENCIONes</div>
				<div id="frmBusqueda">
                                    <form id="form_busqueda" name="form_busqueda" method="post" action="rejilla.php" target="frame_rejilla">                                
                                       <!-- <br/>
                                        <img src="../img/botonnuevaretencion.jpg" border="0" title ="nuevo Retencion"  border="1" onClick="nuevo_retencion()" onMouseOver="style.cursor=cursor">
                                       -->
                                </div>
                                     </form>
				<div id="lineaResultado">
					<iframe width="100%" height="800px" id="frame_rejilla" name="frame_rejilla" frameborder="0">
						<ilayer width="100%" height="800px" id="frame_rejilla" name="frame_rejilla"></ilayer>
					</iframe>					
				</div>
			</div>
		  </div>			
		</div>
	</body>
</html>
