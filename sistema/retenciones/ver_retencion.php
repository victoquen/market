<?php 
include ("../js/fechas.php");
include_once '../conexion/conexion.php';

error_reporting(0);
$idretencion=$_GET["idretencion"];

$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();

//datos retencion
$query_ret="SELECT id_factura, serie1, serie2, codigo_retencion, autorizacion, concepto, totalretencion,fecha
            FROM retencion
            WHERE id_retencion=$idretencion";
$res_ret=mysql_query($query_ret,$conn);
$idfactura=mysql_result($res_ret,0,"id_factura");

//datos proveedor
$query_prov="SELECT fp.id_proveedor id_proveedor, p.empresa as empresa, p.ci_ruc as ci_ruc, p.direccion as direccion, fp.tipocomprobante as tipocomprobante, fp.serie1 as serie1, fp.serie2 as serie2, fp.codigo_factura as codigo_factura
             FROM proveedor p INNER JOIN facturasp fp ON p.id_proveedor = fp.id_proveedor
             WHERE fp.id_facturap= $idfactura";
$res_prov=mysql_query($query_prov,$conn);


//telefono proveedor
$id_prov=mysql_result($res_prov,0,"id_proveedor");
$query_fono="SELECT numero FROM proveedorfono WHERE id_proveedor = $id_prov";
$res_fono=mysql_query($query_fono,$conn);

?>

<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function aceptar() {
			location.href="../facturas_proveedores/index.php";
		}

                function imprimir(idretencion) {
			window.open("../imprimir/imprimir_retencion.php?idretencion="+idretencion);
		}

		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">VER RETENCION</div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                                <tr>
                                                    <td width="10%">No. retencion</td>
                                                    <td>
                                                        <?php  echo mysql_result($res_ret,0,"serie1") ." - ".mysql_result($res_ret,0,"serie2")."  # ".mysql_result($res_ret,0,"codigo_retencion") ?>
                                                    </td>
                                                    <td width="12%">Autorizaci&oacute;n</td>
                                                    <td colspan="2">
                                                        <?php  echo mysql_result($res_ret,0,"autorizacion")?>
                                                    </td>
                                                </tr>
						<tr>
                                                    <td width="10%">Proveedor</td>
                                                    <td width="27%"><?php  echo mysql_result($res_prov,0,"empresa")?></td>
                                                    <td width="12%">CI/RUC</td>
                                                    <td  colspan="2"><?php  echo mysql_result($res_prov,0,"ci_ruc")?></td>
						</tr>
                                                <tr>
                                                    <td width="10%">Direcci&oacute;n</td>
						    <td width="27%"><?php  echo mysql_result($res_prov,0,"direccion")?></td>
                                                    <td width="12%">Telf.:</td>
                                                    <td  colspan="2"><?php  echo mysql_result($res_fono,0,"numero")?></td>
						</tr>
						<tr>
                                                    <td width="10%">Fecha</td>
						    <td width="27%"><?php  echo implota(mysql_result($res_ret,0,"fecha"))?></td>

                                                    <td width="12%">Tipo Comprobante</td>
                                                    <?php  
                                                        $tipocomprob= mysql_result($res_prov,0,"tipocomprobante");
                                                        switch ($tipocomprob)
                                                        {
                                                            // 1 FACTURA
                                                            case 1:
                                                                    $comprobante="FACTURA";
                                                                    break;
                                                            // 2 LIQUIDACIONES DE COMPRA
                                                            case 2:
                                                                    $comprobante="LIQUIDACIONES DE COMPRA";
                                                                    break;
                                                            // 3 NOTA DE VENTA
                                                            case 3:
                                                                    $comprobante="NOTA DE VENTA";
                                                                    break;
                                                        }
                                                    ?>
                                                    <td ><?php  echo $comprobante?></td>

                                                    <td width="12%">No. Comprobante</td>
                                                    <td><?php  echo mysql_result($res_prov,0,"serie1")." - ".mysql_result($res_prov,0,"serie2")."  # ".mysql_result($res_prov,0,"codigo_factura")?></td>

                                                </tr>
                                                <tr>
                                                    <td>Concepto</td>
                                                    <td colspan="5"><?php  echo mysql_result($res_ret,0,"concepto")?></td>
                                                </tr>
					  <tr>
						  <td></td>
						  <td colspan="6"></td>
					  </tr>
				  </table>
					 <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">

                                                    <td width="16%">EJERCICIO FISCAL</td>
                                                    <td width="16%">BASE IMPONIBLE</td>
                                                    <td width="35%">IMPUESTO</td>
                                                    <td width="8%">COD IMPUESTO</td>
                                                    <td width="8%">% RETENCION</td>
                                                    <td width="8%">VALOR RETENIDO</td>
						</tr>
					</table>
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">

					  <?php   
                                                $sel_lineas="SELECT rt.ejercicio_fiscal as ejercicio_fiscal, rt.base_imponible as base_imponible, rt.impuesto as impuesto,
                                                            rt.codigo_impuesto as codigo_impuesto, rt.porcentaje_retencion as porcentaje_retencion,
                                                            rt.valor_retenido as valor_retenido
                                                            FROM retenlinea rt  WHERE rt.id_retencion = '$idretencion'";
                                                $rs_lineas=mysql_query($sel_lineas,$conn);
						for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
							$ejercicio_fiscal=mysql_result($rs_lineas,$i,"ejercicio_fiscal");
                                                        $base_imponible=mysql_result($rs_lineas,$i,"base_imponible");
                                                        $impuesto=mysql_result($rs_lineas,$i,"impuesto");
                                                        $codigo_impuesto=mysql_result($rs_lineas,$i,"codigo_impuesto");
                                                        $porcentaje_retencion=mysql_result($rs_lineas,$i,"porcentaje_retencion");
                                                        $valor_retenido=mysql_result($rs_lineas,$i,"valor_retenido");
							if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
									<tr class="<?php  echo $fondolinea?>">

                                                                                <td width="16%" align="center"><?php  echo $ejercicio_fiscal?></td>
                                                                                <td width="16%" align="center"><?php  echo number_format($base_imponible,2)?> &#36;</td>
                                                                                <td width="35%"><?php  echo $impuesto?></td>
                                                                                <td width="8%" align="center"><?php  echo $codigo_impuesto?></td>
                                                                                <td width="8%" align="center"><?php  echo $porcentaje_retencion?></td>
                                                                                <td width="8%" align="center"><?php  echo number_format($valor_retenido,2)?> &#36;</td>
									</tr>
					<?php  } ?>
					</table>
			  </div>

					<div id="frmBusqueda">
					<table width="15%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
						<tr>
							<td width="15%">Total:</td>
							<td width="15%"><?php  echo number_format(mysql_result($res_ret,0,"totalretencion"),2);?> &#36;</td>
						</tr>


					</table>
			  </div>
				<div id="botonBusqueda">
					<div align="center">

                                            <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor=cursor">

                                            <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir(<?php  echo $idretencion?>)" onMouseOver="style.cursor=cursor">
				        </div>
					</div>
			  </div>
			 </div>
		  </div>
		</div>
	</body>
</html>
