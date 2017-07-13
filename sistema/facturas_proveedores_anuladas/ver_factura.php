<?php 
 
include ("../js/fechas.php");
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);

$idfactura=$_GET["idfactura"];
//$cadena_busqueda=$_GET["cadena_busqueda"];

$query="SELECT * FROM facturasp WHERE id_facturap='$idfactura'";
$rs_query=mysql_query($query,$conn);
$codfactura=mysql_result($rs_query,0,"codigo_factura");
$idproveedor=mysql_result($rs_query,0,"id_proveedor");
$fecha=mysql_result($rs_query,0,"fecha");
$retencion=mysql_result($rs_query,0,"retencion");

$totaliva=mysql_result($rs_query,0,"iva");
$totalfactura=mysql_result($rs_query,0,"totalfactura");
$totalretencion=mysql_result($rs_query,0,"totalretencion");

?>

<html>
	<head>
		<title>Principal</title>
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
		
		function imprimir(idfactura) {
			window.open("../fpdf/imprimir_factura.php?codfactura="+idfactura);
		}
		
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">VER FACTURA </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<?php  
						 $sel_proveedor="SELECT * FROM proveedor WHERE id_proveedor='$idproveedor'";
						  $rs_proveedor=mysql_query($sel_proveedor,$conn); ?>
						<tr>
							<td width="15%">proveedor</td>
							<td width="85%" colspan="2"><?php  echo mysql_result($rs_proveedor,0,"empresa");?></td>
					    </tr>
						<tr>
							<td width="15%">CI / RUC</td>
						    <td width="85%" colspan="2"><?php  echo mysql_result($rs_proveedor,0,"ci_ruc");?></td>
					    </tr>
						<tr>
						  <td>Direcci&oacute;n</td>
						  <td colspan="2"><?php  echo mysql_result($rs_proveedor,0,"direccion"); ?></td>
					  </tr>
						<tr>
						  <td>C&oacute;digo de factura</td>
						  <td colspan="2"><?php  echo $codfactura?></td>
					  </tr>
					  <tr>
						  <td>Fecha</td>
						  <td colspan="2"><?php  echo implota($fecha)?></td>
					  </tr>
					  <tr>
                                                  <td>Retenci&oacute;n</td>
						  <td colspan="2"><?php  echo $retencion?> %</td>
					  </tr>
					  <tr>
						  <td></td>
						  <td colspan="2"></td>
					  </tr>
				  </table>
					 <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							<td width="5%">CANT.</td>
							<td width="18%">CODIGO</td>
							<td width="40%">DESCRIPCION</td>
							<td width="8%">COSTO</td>
							<td width="8%">DCTO %</td>
                                                        <td width="8%">SUBT.</td>
							<td width="8%">IVA</td>
						</tr>
					</table>
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
					  <?php  $sel_lineas="SELECT b.codigo as codigo, b.nombre as nombre, a.cantidad as cantidad, a.costo as costo, a.subtotal as subtotal, a.dcto as dcto, a.iva as iva FROM factulineap a INNER JOIN producto b ON a.id_producto=b.id_producto WHERE a.id_facturap = '$idfactura'";
                                                $rs_lineas=mysql_query($sel_lineas,$conn);
						for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
							$codarticulo=mysql_result($rs_lineas,$i,"codigo");
                                                        $descripcion=mysql_result($rs_lineas,$i,"nombre");
                                                        $cantidad=mysql_result($rs_lineas,$i,"cantidad");
                                                        $costo=mysql_result($rs_lineas,$i,"costo");
                                                        $subtotal=mysql_result($rs_lineas,$i,"subtotal");
                                                        $descuento=mysql_result($rs_lineas,$i,"dcto");
                                                        $iva=mysql_result($rs_lineas, $i, "iva");
							if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
									<tr class="<?php  echo $fondolinea?>">
										<td width="5%"><?php  echo $cantidad?></td>
                                                                                <td width="18%"><?php  echo $codarticulo?></td>
                                                                                <td width="40%"><?php  echo $descripcion?></td>
                                                                                <td width="8%" class="aCentro" align="center"><?php  echo $costo?></td>
                                                                                <td width="8%" class="aCentro" align="center"><?php  echo $descuento?></td>
                                                                                <td width="8%" class="aCentro" align="center"><?php  echo $subtotal?></td>
                                                                                <td width="8%" class="aCentro" align="center"><?php  echo $iva?></td>
									</tr>
									
					<?php  } ?>
					</table>
			  </div>
					<div id="frmBusqueda">
					<table width="25%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
						<tr>
							<td width="15%">Subtotal:</td>
                                                        <td width="15%" align="right"><?php  echo number_format(($totalfactura-$totaliva),2);?> &#36;</td>
                                                        <td width="25%"></td>
						</tr>
						<tr>
							<td width="15%">IVA</td>
							<td width="15%" align="right"><?php  echo number_format($totaliva,2);?> &#36;</td>
                                                        <td width="25%"></td>
						</tr>
						<tr>
							<td width="15%">Total</td>
							<td width="15%" align="right"><?php  echo $totalfactura?> &#36;</td>
                                                        <td width="25%"></td>
						</tr>
                                                <tr>
                                                        <td width="15%">Retenci&oacute;n:</td>
							<td width="15%" align="right"><?php  echo $totalretencion?> &#36;</td>
                                                        <td width="25%"></td>
						</tr>
                                                
					</table>
			  </div>
				<div id="botonBusqueda">
					<div align="center">
					  <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor=cursor">
					 <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir(<?php  echo $idfactura?>)" onMouseOver="style.cursor=cursor">
				        </div>
					</div>
			  </div>
		  </div>
		</div>
	</body>
</html>
