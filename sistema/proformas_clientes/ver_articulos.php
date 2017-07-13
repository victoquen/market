<?php 
    $op=$_GET["op"];
?>
<html>
<head>
<title>Buscador de Articulos</title>
<script>

var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}

function buscar() {
	if (document.getElementById("iniciopagina").value=="") {
		document.getElementById("iniciopagina").value=1;
	} else {
		document.getElementById("iniciopagina").value=document.getElementById("paginas").value;
	}
	document.getElementById("form1").submit();
	document.getElementById("tabla_resultado").style.display="";
}

function inicio() {

	var combo_familia=document.getElementById("cmbfamilia").value;
	if (combo_familia==0) {
		buscar();
	} else {
		document.getElementById("tabla_resultado").style.display="none";
	}
			
}

function paginar() {
	document.getElementById("iniciopagina").value=document.getElementById("paginas").value;
	document.getElementById("form1").submit();
}

function enviar() {
	document.getElementById("form1").submit();
}

function nuevo_producto(){
    var op=<?php echo $op?>;
    location.href="../producto/new_producto.php?origen=factura&op="+op;
}

</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body onLoad="buscar()">
<form name="form1" id="form1" method="post" action="frame_articulos.php" target="frame_resultado" onSubmit="buscar()">

  <table width="95%" id="tabla_resultado" name="tabla_resultado" style="display:none" align="center">
	<tr>
  		<td>
			<iframe width="100%" height="530" id="frame_resultado" name="frame_resultado">
				<ilayer width="100%" height="530" id="frame_resultado" name="frame_resultado"></ilayer>
			</iframe>
		</td>
	</tr>
</table>
<input type="hidden" id="iniciopagina" name="iniciopagina">
<input type="hidden" id="op" name="op" value="<?php echo $op?>">
<table width="100%" border="0">
  <tr>
    <td><div align="center">
      <img src="../img/botoncerrar.jpg" width="70" height="22" onClick="window.close()" border="1" onMouseOver="style.cursor=cursor">
      <img src="../img/botonnuevoarticulo.jpg"  height="22" onClick="nuevo_producto()" border="1" onMouseOver="style.cursor=cursor">
    </div></td>
  </tr>
</table>
<iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
	<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
</iframe>
</form>
</body>
</html>
