<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>PROVEEDORES</title>
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
		
		function nuevo_proveedor() {
			location.href="new_proveedor.php";
		}		
		</script>
	</head>
	<body onLoad="inicio()">
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">proveedor</div>
				<div id="frmBusqueda">
                                    <form id="form_busqueda" name="form_busqueda" method="post" action="rejilla.php" target="frame_rejilla">                                
                                        <br/>
                                        <img src="../img/botonnuevoproveedor.jpg" title="nueva Categor&iacute;a" border="0"  border="1" onClick="nuevo_proveedor()" onMouseOver="style.cursor=cursor">
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
