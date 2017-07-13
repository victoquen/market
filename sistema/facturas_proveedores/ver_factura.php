<?php 
 
include ("../js/fechas.php");
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);

$idfactura=$_GET["idfactura"];
//$cadena_busqueda=$_GET["cadena_busqueda"];

$query="SELECT *, DATE_ADD(fecha,INTERVAL (plazo*30) DAY) as fecha_venc FROM facturasp WHERE id_facturap='$idfactura'";
$rs_query=mysql_query($query,$conn);


$codfactura=mysql_result($rs_query,0,"codigo_factura");
$serie1=mysql_result($rs_query,0,"serie1");
$serie2=mysql_result($rs_query,0,"serie2");
$autorizacion=mysql_result($rs_query,0,"autorizacion");
$idproveedor=mysql_result($rs_query,0,"id_proveedor");
$fecha=mysql_result($rs_query,0,"fecha");
$fecha_venc=mysql_result($rs_query,0,"fecha_venc");
$credito=mysql_result($rs_query,0,"credito");
$plazo=mysql_result($rs_query,0,"plazo");
$tipo_comprobante=mysql_result($rs_query,0,"tipocomprobante");
$retencion=mysql_result($rs_query,0,"retencion");
$cuenta=mysql_result($rs_query,0,"cuenta");

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
						  <td>Tipo Comprobante</td>
						  <td colspan="2">
                                                    <?php 
                                                            switch ($tipo_comprobante)
                                                            {
                                                                case 1: echo "FACTURA";
                                                                    break;
                                                                case 2: echo "LIQUIDACION DE COMPRA";
                                                                    break;
                                                                case 3: echo "NOTA DE VENTA";
                                                                    break;
                                                            }
                                                    ?>
                                                  </td>
					  </tr>
						<tr>
						  <td>No. de factura</td>
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
                                                  <td>Sujeta a Retenci&oacute;n</td>
						  <td colspan="2">
                                                    <?php 
                                                        if ($retencion==1)
                                                            echo "Si";
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
						  <td>Cuenta:</td>
						  <td>
                                                      <?php  
                                                        $query_nombreCuenta="SELECT nombre FROM cuenta WHERE id_cuenta='$cuenta'";
                                                        $sel_nombreCuenta=mysql_query($query_nombreCuenta,$conn);
                                                        $nombre_cuenta = mysql_result($sel_nombreCuenta,0,"nombre");
                                                        echo $nombre_cuenta;
                                                      ?>
                                                  </td>
					  </tr>
				  </table>
					 <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							<td width="5%">CODIGO</td>
							<td width="41%">DESCRIPCION</td>
                                                        <td width="5%">CANT</td>
							<td width="8%">COSTO</td>
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
                                                        $descuento_ind=mysql_result($rs_lineas,$i,"dcto");
                                                        $iva=mysql_result($rs_lineas, $i, "iva");
							if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
									<tr class="<?php  echo $fondolinea?>">
										
                                                                                <td width="5%"><?php  echo $codarticulo?></td>
                                                                                <td width="41%" align="center"><?php  echo $descripcion?></td>
                                                                                <td width="5%"><?php  echo $cantidad?></td>
                                                                                <td width="8%" class="aCentro" align="center"><?php  echo $costo?></td>                                                                               
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
							<td width="15%"><?php  echo number_format($baseimponible,4);?> &#36;</td>
						</tr>
                                                <tr>
							<td width="15%">Dcto.:</td>
							<td width="15%"><?php  echo number_format($descuento,4);?> &#36;</td>
						</tr>
                                                <tr>
							<td width="15%">IVA 0:</td>
							<td width="15%"><?php  echo number_format($iva0,4);?> &#36;</td>
						</tr>
                                                <tr>
							<td width="15%">IVA 12:</td>
							<td width="15%"><?php  echo number_format($iva12,4);?> &#36;</td>
						</tr>
						<tr>
							<td width="15%">Total IVA:</td>
							<td width="15%"><?php  echo number_format($importeiva,4);?> &#36;</td>
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
					  <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor=cursor">
					 <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir(<?php  echo $idfactura?>)" onMouseOver="style.cursor=cursor">
				        </div>
					</div>
			  </div>
		  </div>
		</div>
	</body>
</html>
