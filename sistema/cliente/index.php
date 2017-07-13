<?php

$tiempo_sesion = 60;

//iniciamos la sesión
//session_name("loginUsuario");
session_start();

//antes de hacer los cálculos, compruebo que el usuario está logueado
//utilizamos el mismo script que antes
if ($_SESSION["autentificado"] != "SI") {
	//si no está logueado lo envío a la página de autentificación
	header("Location: index.php");
} else {
	//sino, calculamos el tiempo transcurrido
	$fechaGuardada = $_SESSION["ultimoAcceso"];
	$ahora = date("Y-n-j H:i:s");
	$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));

	//comparamos el tiempo transcurrido
	if($tiempo_transcurrido >= $tiempo_sesion) {
		//si pasaron 1 minutos o más
		session_destroy(); // destruyo la sesión
		echo '<script>parent.location.href=\'../../logout.php\';</script>';

	}else {
		//sino, actualizo la fecha de la sesión
		$_SESSION["ultimoAcceso"] = $ahora;
	}
}

?>

<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>CLIENTES</title>
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
		
		function nuevo_cliente() {
			location.href="new_cliente.php";
		}		
		</script>
	</head>
	<body onLoad="inicio()">
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">CLIENTE</div>
				<div id="frmBusqueda">
                                    <form id="form_busqueda" name="form_busqueda" method="post" action="rejilla.php" target="frame_rejilla">                                
                                        <br/>
                                        <img src="../img/botonnuevocliente.jpg" title="nueva Categor&iacute;a" border="0" border="1" onClick="nuevo_cliente()" onMouseOver="style.cursor=cursor">
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
