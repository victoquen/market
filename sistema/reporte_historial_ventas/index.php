<html>
	<head>
		<title>HISTORIAL Ventas</title>
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
		
		function load_formulario() {
			document.getElementById("form_busqueda").submit();
		}
				
                function ventanaArticulos(){

				miPopup = window.open("ver_articulos.php","miwin","width=700,height=580,scrollbars=yes");
				miPopup.focus();                               
		}
		</script>
	</head>
	<body onload="load_formulario()" >
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">HISTORIAL ventas </div>
				<div id="frmBusqueda">
                                    <form id="form_busqueda" name="form_busqueda" method="post" action="rejilla.php" target="frame_rejilla">                                
                                        <table class="fuente8">
                                            <tr>
                                                <td><b>PRODUCTO:</b></td>
                                                <td>                                                    
                                                    <input NAME="descripcion" id="descripcion" type="text" class="cajaGrande"   onclick="ventanaArticulos()" readonly>
                                                    <img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos()" onMouseOver="style.cursor=cursor" title="Buscar articulos">
                                                </td>
                                            </tr>
                                        </table>
                                        <input type="hidden" id="codarticulo" name="codarticulo"/>
                                        <input type="hidden" id="idarticulo" name="idarticulo" value="0"/>
                                        <input type="hidden" id="stock" name="stock"/>
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
