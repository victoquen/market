<?php 

include ("../js/fechas.php");
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$idfactura=$_GET["idfactura"];


$query="SELECT *, DATE_ADD(fecha,INTERVAL (plazo*30) DAY) as fecha_venc FROM proformas WHERE id_factura='$idfactura'";
$rs_query=mysql_query($query,$conn);

$idfactura=mysql_result($rs_query,0,"id_factura");

$codfactura=mysql_result($rs_query,0,"codigo_factura");
$serie1=mysql_result($rs_query,0,"serie1");
$serie2=mysql_result($rs_query,0,"serie2");
$autorizacion=mysql_result($rs_query,0,"autorizacion");
$idcliente=mysql_result($rs_query,0,"id_cliente");
$fecha=mysql_result($rs_query,0,"fecha");
$fecha_venc=mysql_result($rs_query,0,"fecha_venc");
$credito=mysql_result($rs_query,0,"credito");
$plazo=mysql_result($rs_query,0,"plazo");


$descuento=mysql_result($rs_query,0,"descuento");
$iva0=mysql_result($rs_query,0,"iva0");
$iva12=mysql_result($rs_query,0,"iva12");
$importeiva=mysql_result($rs_query,0,"iva");
$flete=mysql_result($rs_query,0,"flete");
$totalfactura=mysql_result($rs_query,0,"totalfactura");
$baseimponible=$totalfactura-$flete-$importeiva+$descuento;


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
		
		function aceptar(idfactura) {
			location.href="guardar_factura.php?idfactura=" + idfactura + "&accion=baja";
		}
		
		function cancelar() {
			location.href="index.php";
		}
		
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">ELIMINAR FACTURA </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<?php  
						$sel_cliente="SELECT * FROM cliente WHERE id_cliente='$idcliente'";
						  $rs_cliente=mysql_query($sel_cliente,$conn); ?>
						<tr>
							<td width="15%">Cliente</td>
							<td width="85%" colspan="2"><?php  echo mysql_result($rs_cliente,0,"nombre");?></td>
					    </tr>
						<tr>
							<td width="15%">CI / RUC</td>
						    <td width="85%" colspan="2"><?php  echo mysql_result($rs_cliente,0,"ci_ruc");?></td>
					    </tr>
						<tr>
						  <td>Direcci&oacute;n</td>
						  <td colspan="2"><?php  echo mysql_result($rs_cliente,0,"direccion"); ?></td>
					  </tr>
						<tr>
						  <td>C&oacute;digo de factura</td>
						  <td colspan="2"><?php  echo $serie1."--".$serie2."--".$codfactura?></td>
					  </tr>
                                          <tr>
                                              <td>Autorizaci&oacute;n</td>
						  <td colspan="2"><?php  echo $autorizacion?></td>
					  </tr>
					  <tr>
						  <td>Fecha</td>
						  <td colspan="2"><?php  echo implota($fecha)?></td>
					  </tr>
					   <tr>
                                                  <td>Cr&eacute;dito</td>
						  <td colspan="2">
                                                    <?php 
                                                        if ($credito==1)
                                                            echo "Si --- <b>PLAZO: </b> ".($plazo*30);
                                                        else
                                                            echo "No"
                                                    ?>
                                                  </td>
					  </tr>
                                          <tr>
						  <td>Fecha Vencto.</td>
						  <td colspan="2"><?php  echo implota($fecha_venc)?></td>
					  </tr>
					  <tr>
						  <td></td>
						  <td colspan="2"></td>
					  </tr>
				  </table>
					 <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							<td width="18%">CODIGO</td>
							<td width="40%">DESCRIPCION</td>
                                                        <td width="5%">CANT.</td>
							<td width="8%">PRECIO</td>
                                                        <td width="8%">SUBT.</td>
							<td width="8%">DCTO</td>
							<td width="8%">IVA</td>
						</tr>
					</table>
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
					  <?php  
						 $sel_lineas="SELECT b.codigo as codigo, b.nombre as nombre, a.cantidad as cantidad, a.precio as precio, a.subtotal as subtotal, a.dcto as dcto, a.iva as iva FROM proforlinea a INNER JOIN producto b ON a.id_producto=b.id_producto WHERE a.id_factura = '$idfactura'";
                                                $rs_lineas=mysql_query($sel_lineas,$conn);
						for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
							$codarticulo=mysql_result($rs_lineas,$i,"codigo");
                                                        $descripcion=mysql_result($rs_lineas,$i,"nombre");
                                                        $cantidad=mysql_result($rs_lineas,$i,"cantidad");
                                                        $precio=mysql_result($rs_lineas,$i,"precio");
                                                        $subtotal=mysql_result($rs_lineas,$i,"subtotal");
                                                        $descuento_ind=mysql_result($rs_lineas,$i,"dcto");
                                                        $iva=mysql_result($rs_lineas, $i, "iva");
							if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
									<tr class="<?php  echo $fondolinea?>">
										<td width="18%"><?php  echo $codarticulo?></td>
                                                                                <td width="40%"><?php  echo $descripcion?></td>
                                                                                <td width="5%"><?php  echo $cantidad?></td>
                                                                                <td width="8%" class="aCentro" align="center"><?php  echo $precio?></td>
                                                                                <td width="8%" class="aCentro" align="center"><?php  echo $subtotal?></td>
                                                                                <td width="8%" class="aCentro" align="center"><?php  echo $descuento_ind?></td>
                                                                                <td width="8%" class="aCentro" align="center"><?php  echo $iva?></td>
									</tr>
									
					<?php  } ?>
					</table>
			  </div>			
					<div id="frmBusqueda">
					<table width="25%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
						<tr>
							<td width="15%">Subtotal:</td>
							<td width="15%"><?php  echo number_format($baseimponible,2);?> &#36;</td>
						</tr>
                                                <tr>
							<td width="15%">Dcto.:</td>
							<td width="15%"><?php  echo number_format($descuento,2);?> &#36;</td>
						</tr>
                                                <tr>
							<td width="15%">IVA 0:</td>
							<td width="15%"><?php  echo number_format($iva0,2);?> &#36;</td>
						</tr>
                                                <tr>
							<td width="15%">IVA 12:</td>
							<td width="15%"><?php  echo number_format($iva12,2);?> &#36;</td>
						</tr>
						<tr>
							<td width="15%">Total IVA:</td>
							<td width="15%"><?php  echo number_format($importeiva,2);?> &#36;</td>
						</tr>
                                                 <tr>
                                                        <td width="15%">Flete:</td>
							<td width="15%"><?php  echo $flete?> &#36;</td>
						</tr>
						<tr>
							<td width="15%">Total:</td>
							<td width="15%"><?php  echo $totalfactura?> &#36;</td>
						</tr>
					</table>
			  </div>
				<div id="botonBusqueda">
					<div align="center">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php  echo $idfactura?>)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
				        </div>
					</div>
			  </div>
		  </div>
		</div>
	</body>
</html>
