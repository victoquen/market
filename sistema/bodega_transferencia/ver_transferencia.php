<?php
 
include ("../js/fechas.php");
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);

$idtransferencia=$_GET["idtransferencia"];
//$cadena_busqueda=$_GET["cadena_busqueda"];

$query="SELECT * FROM transferencia WHERE id_transferencia='$idtransferencia' AND borrado = 0";
$rs_query=mysql_query($query,$conn);

$fecha=mysql_result($rs_query,0,"fecha");


?>

<html>
	<head>
		<title>Principal</title>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
               
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
		
		function aceptar() {
			location.href="index.php";
		}
		
		function imprimir(idtransferencia) {
			window.open("../class/imprimir_transferencia.php?id_transferencia="+idtransferencia);
			//window.open("../class/imprimir_transferencia.php);
		}
		
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">VER TRANSFERENCIA </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						
					 <tr>
						  <td>Transferencia No.:</td>
						  <td colspan="2"><?php echo $idtransferencia?></td>
					  </tr>	
						
					  <tr>
						  <td>Fecha</td>
						  <td colspan="2"><?php echo implota($fecha)?></td>
					  </tr>
					  
				  </table>
					 <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							<td width="5%">CODIGO</td>
							<td width="40%">DESCRIPCION</td>
							<td width="5%">CANT</td>
							<td width="22%">Origen</td>
							<td width="22%">Destino</td>
						</tr>
					</table>
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
					  <?php
							$sel_lineas="SELECT b.codigo as codigo, b.nombre as nombre, a.cantidad as cantidad, a.id_bodegaorigen as idbodegaorigen, 
												a.id_bodegadestino as idbodegadestino   
										FROM producto b INNER JOIN  transferencialinea a ON b.id_producto = a.id_producto 
										WHERE a.id_transferencia = $idtransferencia ";
							$rs_lineas=mysql_query($sel_lineas, $conn);
							for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {							
								$codarticulo=mysql_result($rs_lineas,$i,"codigo");
								$descripcion=mysql_result($rs_lineas,$i,"nombre");
								$cantidad=mysql_result($rs_lineas,$i,"cantidad");
								$idbodegaorigen=mysql_result($rs_lineas,$i,"idbodegaorigen");
								$idbodegadestino=mysql_result($rs_lineas,$i,"idbodegadestino");
								
								
								$queryb = "SELECT nombre FROM bodega WHERE id_bodega = '$idbodegaorigen'";
								$resb = mysql_query($queryb, $conn);
								$nombodegaorigen = mysql_result($resb, 0, "nombre");
								
								$queryb = "SELECT nombre FROM bodega WHERE id_bodega = '$idbodegadestino'";
								$resb = mysql_query($queryb, $conn);
								$nombodegadestino = mysql_result($resb, 0, "nombre");
									
									
								if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
										<tr class="<?php  echo $fondolinea?>">
											
											<td width="5%"><?php  echo $codarticulo?></td>
											<td width="41%" align="center"><?php  echo $descripcion?></td>
											<td width="5%"><?php  echo $cantidad?></td>				
											<td width="22%" align="center"><?php  echo $nombodegaorigen?></td>
											<td width="22%" align="center"><?php  echo $nombodegadestino?></td>															
										</tr>									
					<? } ?>
					</table>
			  </div>				
				<div id="botonBusqueda">
					<div align="center">
					  <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor=cursor">
					 <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir(<?php echo $idtransferencia?>)" onMouseOver="style.cursor=cursor">
				        </div>
					</div>
			  </div>
		  </div>
		</div>
	</body>
</html>
