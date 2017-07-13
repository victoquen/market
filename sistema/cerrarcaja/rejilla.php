<?php

include ("../js/fechas.php");
//error_reporting(0);
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


$fechainicio=$_POST["fechainicio"];
if ($fechainicio<>"") { $fechainicio=explota($fechainicio); }

//$cadena_busqueda=$_POST["cadena_busqueda"];

//ventas-----------------------------------------------------------------------------------------------------
$sel_facturas="SELECT  sum(totalfactura) as totalfac, sum(iva) as totaliva, sum(ret_iva) as totalretiva, sum(ret_fuente) as totalretfuente FROM facturas WHERE anulado = 0 AND fecha='$fechainicio'";
$rs_facturas=mysql_query($sel_facturas,$conn);

if (mysql_num_rows($rs_facturas) > 0 ) {
	$total=mysql_result($rs_facturas,0,"totalfac");       
        $totaliva=mysql_result($rs_facturas,0,"totaliva");
        $totalretiva= mysql_result($rs_facturas,0,"totalretiva");
        $totalretfuente= mysql_result($rs_facturas,0,"totalretfuente");
} else {
	$total=0;       
        $totaliva=0;
        $totalretiva = 0;
        $totalretfuente = 0;
}


$neto=$total-$totaliva - $totalretiva - $totalretfuente;


$sel_cobros="SELECT sum(a.importe) as suma,a.id_formapago, b.nombre
FROM cobros a INNER JOIN formapago b ON a.id_formapago=b.id_formapago
WHERE fechacobro='$fechainicio'
GROUP BY a.id_formapago, b.nombre
ORDER BY id_formapago ASC";

$rs_cobros=mysql_query($sel_cobros,$conn);



//compras----------------------------------------------------------------------------------------------------------------------------


$sel_facturasp="SELECT  sum(fp.totalfactura) as totalfac, sum(r.totalretencion) as retenciones, sum(fp.iva) as totaliva 
                FROM facturasp fp INNER JOIN retencion r ON fp.id_facturap = r.id_factura 
                WHERE fp.anulado = 0 AND r.anulado = 0 AND fp.fecha='$fechainicio'";
$rs_facturasp=mysql_query($sel_facturasp,$conn);

if (mysql_num_rows($rs_facturasp) > 0 ) {
	$totalp=mysql_result($rs_facturasp,0,"totalfac");
        $retencionesp=mysql_result($rs_facturasp,0,"retenciones");
        $totalivap=mysql_result($rs_facturasp,0,"totaliva");
} else {
	$totalp=0;
        $retencionesp=0;
        $totalivap=0;
}


$netop=$totalp-$totalivap;


$sel_pagos="SELECT sum(a.importe) as suma,a.id_formapago, b.nombre
FROM pagos a INNER JOIN formapago b ON a.id_formapago=b.id_formapago
WHERE fechacobro='$fechainicio'
GROUP BY a.id_formapago, b.nombre
ORDER BY id_formapago ASC";

$rs_pagos=mysql_query($sel_pagos,$conn);


?>
<html>
	<head>
		<title>Cierre Caja</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">	
		<script>
		
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		 function imprimir(fechainicio,minimo,maximo,neto,iva,total,contado,tarjeta) {
			location.href="../fpdf/cerrarcaja_html.php?fechainicio="+fechainicio+"&minimo="+minimo+"&maximo="+maximo+"&neto="+neto+"&iva="+iva+"&total="+total+"&contado="+contado+"&tarjeta="+tarjeta;	
		 }
		</script>
	</head>
	<body>	
            
		<div id="pagina">
			<div id="zonaContenido">
			<div align="center">
				<form id="formulario" name="formulario" method="post" action="rejilla.php" target="frame_rejilla">
					<table class="fuente8" width="90%" cellspacing=0 cellpadding=3 border=0>
					  <tr>
						  
                                              <td colspan="2" align="center"><b>CAJA FECHA: </b><?php echo implota($fechainicio)?></td>

						  
					  </tr>
                                          <tr class="itemImparTabla">
                                              <td  align="left"><b>VENTAS(cobros)</b></td>
                                              <td  align="left"><b>COMPRAS(pagos)</b></td>
                                          </tr>
                                          <tr>
                                              <!-- ventas*********************************************************************************** -->
                                              <td >
                                                  <table class="fuente8" width="70%" cellspacing=0 cellpadding=3 border=0>                                                     
                                                      <tr>
                                                          <td><b>Total Ret. Iva</b></td>
                                                          <td><?php echo number_format($totalretiva,2,",",".")?> &#36;</td>
                                                          <td></td>
                                                      </tr>
                                                      <tr>
                                                          <td><b>Total Ret. Fuente</b></td>
                                                          <td><?php echo number_format($totalretfuente,2,",",".")?> &#36;</td>
                                                          <td></td>
                                                      </tr>
                                                      <tr>
                                                              <td><b>Neto</b></td>
                                                              <td><?php echo number_format($neto,2,",",".")?> &#36;</td>
                                                              <td></td>


                                                      </tr>
                                                      <tr>
                                                              <td><b>12% IVA</b></td>
                                                              <td><?php echo number_format($totaliva,2,",",".")?> &#36;</td>
                                                              <td></td>

                                                      </tr>
                                                      <tr class="itemImparTabla">
                                                              <td><b>TOTAL en Facturas</b></td>
                                                              <td></td>
                                                              <td><b><?php echo number_format($total,2,",",".")?> &#36;</b></td>

                                                      </tr>

                                                      <?php
                                                      $totalcobrado=0;
                                                        $contador=0;
                                                        $efectivocobros=0;
                                                         while ($contador < mysql_num_rows($rs_cobros))
                                                         {
                                                            if(mysql_result($rs_cobros,$contador,"nombre")=="EFECTIVO")
                                                                    $efectivocobros=mysql_result($rs_cobros,$contador,"suma");

                                                      ?>
                                                            <tr>
                                                              <td><b><?php echo mysql_result($rs_cobros,$contador,"nombre")?></b></td>
                                                              <td><?php echo number_format(mysql_result($rs_cobros,$contador,"suma"),2,",",".")?> &#36;</td>
                                                              <td></td>

                                                            </tr>

                                                      <?php
                                                            $totalcobrado=$totalcobrado+mysql_result($rs_cobros,$contador,"suma");
                                                            $contador++;
                                                         }

                                                      ?>

                                                      <tr class="itemImparTabla">
                                                              <td><strong>TOTAL Cobrado</strong></td>
                                                              <td></td>
                                                              <td><b><?php echo number_format($totalcobrado,2,",",".")?> &#36;</b></td>
                                                      </tr>
                                                  </table>
                                                </td>


                                            <!-- compras*********************************************************************************** -->
                                            <td>
                                                  <table class="fuente8" width="70%" cellspacing=0 cellpadding=3 border=0>
                                                      <tr>
                                                              <td><b>Valor de Retenciones</b></td>
                                                              <td><?php echo number_format($retencionesp,2,",",".")?> &#36;</td>
                                                              <td>&nbsp;</td>

                                                      </tr>
                                                      <tr>
                                                              <td><b>Neto</b></td>
                                                              <td><?php echo number_format($netop,2,",",".")?> &#36;</td>
                                                              <td></td>


                                                      </tr>
                                                      <tr>
                                                              <td><b>12% IVA</b></td>
                                                              <td><?php echo number_format($totalivap,2,",",".")?> &#36;</td>
                                                              <td></td>

                                                      </tr>
                                                      <tr class="itemImparTabla">
                                                              <td ><b>TOTAL en Facturas</b></td>
                                                              <td></td>
                                                              <td><b><?php echo number_format($totalp,2,",",".")?> &#36;</b></td>

                                                      </tr>

                                                      <?php
                                                        $totalpagado=0;
                                                        $contadorp=0;
                                                        $efectivopagos=0;
                                                         while ($contadorp < mysql_num_rows($rs_pagos))
                                                         {
                                                            if(mysql_result($rs_pagos,$contadorp,"nombre")=="EFECTIVO")
                                                                    $efectivopagos=mysql_result($rs_pagos,$contadorp,"suma");

                                                      ?>
                                                            <tr>
                                                              <td><b><?php echo mysql_result($rs_pagos,$contadorp,"nombre")?></b></td>
                                                              <td><?php echo number_format(mysql_result($rs_pagos,$contadorp,"suma"),2,",",".")?> &#36;</td>
                                                              <td></td>

                                                            </tr>

                                                      <?php
                                                            $totalpagado=$totalpagado+mysql_result($rs_pagos,$contadorp,"suma");
                                                            $contadorp++;
                                                         }

                                                      ?>

                                                      <tr class="itemImparTabla">
                                                              <td><strong>TOTAL Pagado</strong></td>
                                                              <td></td>
                                                              <td><b><?php echo number_format($totalpagado,2,",",".")?> &#36;</b></td>
                                                      </tr>
                                                  </table>
                                                </td>


                                            </tr>
                                            <tr>
                                                <td colspan="2"><hr/></td>
                                            </tr>
                                            <tr class="itemImparTabla">
                                                <td align="right">(total cobrado - total pagado) <b>TOTAL DIA= </b></td>
                                                <td align="left">&#36; <?php echo number_format(($totalcobrado-$totalpagado),2,",",".")?></td>
                                            </tr>
                                            <tr class="itemImparTabla">
                                                <td align="right"><b>EFECTIVO= </b></td>
                                                <td align="left">&#36; <?php echo number_format(($efectivocobros-$efectivopagos),2,",",".")?></td>
                                            </tr>
					</table>
			  </div>
			  <div id="botonBusqueda">
			  <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir('<?php echo $fechainicio?>','<?php echo $minimo?>','<?php echo $maximo?>','<?php echo $neto?>','<?php echo $iva?>','<?php echo $total?>','<?php echo $contado?>','<?php echo $tarjeta?>')" onMouseOver="style.cursor=cursor">		
				</div>
			</div>	
		</div>
	</body>
</html>
