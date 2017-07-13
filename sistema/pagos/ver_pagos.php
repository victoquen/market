<?php  

include ("../js/fechas.php");
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);

$idfactura=$_GET["idfactura"];

$select_facturas="SELECT proveedor.id_proveedor,proveedor.empresa, proveedor.ci_ruc,
                    facturasp.id_facturap, facturasp.codigo_factura,facturasp.serie1,facturasp.serie2,facturasp.autorizacion, estado,totalfactura, fecha, DATE_ADD(fecha,INTERVAL (plazo*30) DAY) as fecha_venc
                    FROM facturasp LEFT JOIN pagos ON facturasp.id_facturap=pagos.id_factura INNER JOIN proveedor ON facturasp.id_proveedor=proveedor.id_proveedor
                    WHERE facturasp.id_facturap='$idfactura'";
$rs_facturas=mysql_query($select_facturas,$conn);

$hoy=date("d/m/Y");

$sel_cobros="SELECT sum(importe) as aportaciones FROM pagos WHERE  id_factura='$idfactura'";
$rs_cobros=mysql_query($sel_cobros,$conn);
if($rs_cobros)
    $aportaciones=mysql_result($rs_cobros,0,"aportaciones");
else
    $aportaciones=0;

?>
<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="../js/validar.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>
		<script language="javascript">
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		
		function cancelar() {
			location.href="index.php";
		}
		
		function cambiar_estado() {
			var estado=document.getElementById("cboEstados").value;
			var idfactura=document.getElementById("idfactura").value;
			miPopup = window.open("actualizarestado.php?estado="+estado+"&idfactura="+idfactura,"frame_datos","width=700,height=80,scrollbars=yes");
		}
		
		function cambiar_vencimiento() {
			var fechavencimiento=document.getElementById("fechavencimiento").value;
			var idfactura=document.getElementById("idfactura").value;
			miPopup = window.open("actualizarvencimiento.php?fechavencimiento="+fechavencimiento+"&idfactura="+idfactura,"frame_datos","width=700,height=80,scrollbars=yes");
		}

                function activar_bancos(indice)
                {
                   with (document.formulario)
                   {
                       value=AcboFP.options[indice].value ;
                     switch (value)
                      {                                                        
                          case "1":
                            acbobanco.selectedIndex=0;
                            acbobanco.disabled = true;
                            break;
                          default:
                            acbobanco.disabled = false;
                            break;
                      }
                   }
                }
                
		</script>

                

	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">PAGOS </div>
				<div id="frmBusqueda">
				<form id="formdatos" name="formdatos" method="post" action="guardar_pago.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
					<?php 
                                                $codfactura=mysql_result($rs_facturas,0,"codigo_factura");
                                                $serie1=mysql_result($rs_facturas,0,"serie1");
                                                $serie2=mysql_result($rs_facturas,0,"serie2");
                                                $autorizacion=mysql_result($rs_facturas,0,"autorizacion");

                                                $idproveedor=mysql_result($rs_facturas,0,"id_proveedor");
                                                $ci_ruc=mysql_result($rs_facturas,0,"ci_ruc");
					 	
						$nombre=mysql_result($rs_facturas,0,"empresa");
						$idfactura=mysql_result($rs_facturas,0,"id_facturap");
                                               
						$totalfactura=mysql_result($rs_facturas,0,"totalfactura");
						$estado=mysql_result($rs_facturas,0,"estado"); 
						
                                                $query_retencion="SELECT totalretencion FROM retencion WHERE (anulado = 0) AND id_factura='$idfactura'";
                                                $rs_retencion=mysql_query($query_retencion, $conn);
                                                $retencion=mysql_result($rs_retencion,0,"totalretencion");
                                                
                                                $fecha = mysql_result($rs_facturas,0,"fecha");
                                                $fecha_venc = mysql_result($rs_facturas,0,"fecha_venc");
                                                
						?>
						<tr>
                                                    <td width="15%">Ci/Ruc Proveedor</td>
						    <td width="43%"><?php  echo $ci_ruc?></td>
					        <td width="42%" rowspan="14" align="left" valign="top"></td>
						</tr>
						<tr>
                                                    <td width="15%">Proveedor</td>
						    <td width="43%"><?php  echo $nombre?></td>
					        <td width="42%" rowspan="14" align="left" valign="top"></td>
						</tr>	
						<tr>
                                                    <td width="15%">No. de factura</td>
                                                    <td>
                                                        <table class="fuente8" width="80%" cellspacing=0 cellpadding=3 border=0>
                                                            <tr>
                                                                <td width="30%"><?php  echo $serie1."--".$serie2."--".$codfactura?> </td>
                                                                <td width="20%">Autorizaci&oacute;n:</td>
                                                                <td ><?php  echo $autorizacion?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
					        <td width="42%" rowspan="14" align="left" valign="top"></td>
						</tr>
                                                
                                                <tr>
                                                    <td width="15%">Fecha Emi.</td>
                                                    <td>
                                                        <table class="fuente8" width="80%" cellspacing=0 cellpadding=3 border=0>
                                                            <tr>
                                                                
                                                                <td width="30%"><?php  echo $fecha?></td>
                                                                <td width="20%">Fecha Venc.:</td>
                                                                <td ><?php  echo $fecha_venc?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
					        <td width="42%" rowspan="14" align="left" valign="top"></td>
						</tr>
						<tr>
                                                    <td width="15%">Total Factura</td>
						    <td width="43%"><?php  echo number_format($totalfactura,4)?></td>
					        <td width="42%" rowspan="14" align="left" valign="top"></td>
						</tr>
                                                <tr>
                                                    <td width="15%">Retencion</td>
						    <td width="43%"><?php  echo number_format($retencion,2)?></td>
					        <td width="42%" rowspan="14" align="left" valign="top"></td>
						</tr>
						<?php  $pendiente=$totalfactura-$aportaciones - $retencion; ?>
						<tr>
							<td width="15%">Pendiente por pagar</td>
						    <td width="43%"><input type="text" name="pendiente" id="pendiente" value="<?php  echo number_format($pendiente,4,".","")?>" readonly="yes" class="cajaTotales"> &#36;</td>
					        <td width="42%" rowspan="14" align="left" valign="top"></td>
						</tr>
						<tr>
							<td width="15%">Estado de la factura</td>
						    <td width="43%"><select id="cboEstados" name="cboEstados" class="comboMedio" onChange="cambiar_estado()">
								<?php  if ($estado==0) { ?><option value="0" selected="selected">Sin Cobrar</option>
								<option value="1">Cobrada</option><?php  } else { ?>
								<option value="0">Sin Cobrar</option>
								<option value="1" selected="selected">Cobrada</option>
								<?php  } ?> 			
								</select></td>
					        <td width="42%" rowspan="14" align="left" valign="top"></td>
						</tr>	
															
					</table>
					</form>
			  </div>
			  <br>
			  <div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="frame_pagos.php" target="frame_pagos">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
                                                    <td width="15%">Fecha de pago</td>
						    <td width="35%"><input id="fechacobro" type="text" class="cajaPequena" NAME="fechacobro" maxlength="10" value="<?php  echo $hoy?>" readonly><img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'" title="Calendario">
                                                    <script type="text/javascript">
                                                            Calendar.setup(
                                                              {
                                                            inputField : "fechacobro",
                                                            ifFormat   : "%d/%m/%Y",
                                                            button     : "Image1"
                                                              }
                                                            );
                                                    </script></td>
                                                    <td width="50%" rowspan="14" align="left" valign="top"><ul id="lista-errores"></ul></td>
						</tr>
						<tr>
							<td width="15%">Valor Pagado</td>
						    <td width="35%"><input id="Rimporte" type="text" class="cajaPequena" NAME="Rimporte" maxlength="12"> &#36;</td>
                                                   <td width="50%" rowspan="14" align="left" valign="top"></td>
						</tr>	
						<?php 
					  	$query_fp="SELECT * FROM formapago WHERE borrado=0 ORDER BY nombre ASC";
						$res_fp=mysql_query($query_fp,$conn);
						$contador=0;
					  ?>
						<tr>
							<td width="15%">Forma de Pago</td>
                                                        <td width="35%"><select id="AcboFP" name="AcboFP" class="comboGrande" onchange="activar_bancos(this.selectedIndex)">
							
								<option value="0">Seleccione una forma de pago</option>
								<?php 
								while ($contador < mysql_num_rows($res_fp)) { ?>
								<option value="<?php  echo mysql_result($res_fp,$contador,"id_formapago")?>"><?php  echo mysql_result($res_fp,$contador,"nombre")?></option>
								<?php  $contador++;
								} ?>				
								</select>							
                                                        </td>
                                                        
							<td width="50%" rowspan="14" align="left" valign="top"></td>
                                                </tr>

                                                <?php 
					  	$query_b="SELECT * FROM banco WHERE borrado=0 ORDER BY nombre ASC";
						$res_b=mysql_query($query_b,$conn);
						$contador=0;
                                                ?>


						<tr>
							<td width="15%">Entidad Bancaria</td>
                                                        <td width="35%"><select id="acbobanco"  class="comboGrande" NAME="acbobanco" disabled="true">
                                                                    <option value="0">Seleccione una entidad bancaria</option>
								<?php 
								while ($contador < mysql_num_rows($res_b)) { ?>
								<option value="<?php  echo mysql_result($res_b,$contador,"id_banco")?>"><?php  echo mysql_result($res_b,$contador,"nombre")?></option>
								<?php  $contador++;
								} ?>
								</select>
                                                        </td>
                                                        
                                                        <td width="50%" rowspan="14" align="left" valign="top"></td>

						</tr>
                                                <tr>
                                                    <td width="50%" colspan="2">
                                                        <table  class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
                                                            <tr>
                                                                <td width="30%">No. Documento </td>
                                                                <td><input id="adocumento_numero" type="text" class="cajaPequena" NAME="adocumento_numero" maxlength="12"></td>
                                                                <td>No. Recibo</td>
                                                                <td><input id="arecibo_numero" type="text" class="cajaPequena" NAME="arecibo_numero" maxlength="12"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td width="50%" rowspan="14" align="left" valign="top"></td>
                                                </tr>
						<tr>
							<td width="15%">Observaciones</td>
                                                        <td width="35%"><textarea rows="1" cols="30" class="areaTexto" name="observaciones" id="observaciones"></textarea></td>
                                                        <td width="40%" rowspan="14" align="left" valign="top"></td>
						</tr>																	
					</table>
			  </div>
				<div id="botonBusqueda">
					<input type="hidden" name="id" id="id">
					<input type="hidden" name="accion" id="accion" value="insertar">
					<input type="hidden" name="idproveedor" id="idproveedor" value="<?php  echo $idproveedor?>">
					<input type="hidden" name="idfactura" id="idfactura" value="<?php  echo $idfactura?>">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="javascript:validar(formulario,true);" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botonvolver.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			  </form>
			  <br>
			  <div id="frmBusqueda">
			  <div id="tituloForm" class="header">RELACION DE PAGOS</div>
				<div id="frmResultado2">
				<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
                                                    <td width="5%" align="center">ITEM</td>
                                                    <td width="12%" align="center">FECHA</td>
                                                    <td width="12%" align="center">IMPORTE </td>
                                                    <td width="15%" align="center">BANCO</td>
                                                    <td width="15%" align="center">FORMA PAGO</td>
                                                    <td width="15%" align="center">N. DOC</td>
                                                    <td width="15%" align="center">N. RECIBO</td>
                                                    <td width="5%">OBV.</td>
                                                    <td width="6%">&nbsp;</td>
						</tr>
				</table>
				</div>
					<div id="lineaResultado">
					<iframe width="100%" height="250" id="frame_pagos" name="frame_pagos" frameborder="0" src="frame_pagos.php?accion=ver&idfactura=<?php  echo $idfactura?>">
						<ilayer width="100%" height="250" id="frame_pagos" name="frame_pagos"></ilayer>
					</iframe>
					<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>
				</div>
				</div>
			  </div>
		  </div>
		</div>
	</body>
</html>
