<?php 

include ("../js/fechas.php");
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);

$accion=$_POST["accion"];
if (!isset($accion)) { $accion=$_GET["accion"]; }
if($accion!="baja")
{
    $codfacturatmp=$_POST["codfacturatmp"];
    $codfactura=$_POST["codfactura"];
    $serie1=$_POST["serie1"];
    $serie2=$_POST["serie2"];
    $autorizacion=$_POST["autorizacion"];
    $idproveedor=$_POST["codproveedor"];
    $fecha=explota($_POST["fecha"]);
    $credito=$_POST["cbocredito"];
    $plazo=$_POST["cboplazo"];
    $retencion=$_POST["cboretencion"];
    $cuenta=$_POST["cbocuenta"];
    

    $baseimponible=$_POST["baseimponible2"];
    $descuento=$_POST["descuentototal2"];
    $iva0=$_POST["iva0final"];
    $iva12=$_POST["iva12final"];
    $importeiva=$_POST["importeiva2"];
    $flete=$_POST["flete2"];
    $totalfactura=$_POST["preciototal2"];

    $tipo_comprobante=$_POST["cbotipocomprobante"];
}
$minimo=0;

if ($accion=="alta") {
//	$query_operacion="INSERT INTO facturas (codfactura, fecha, iva, codproveedor, estado, borrado) VALUES ('', '$fecha', '$iva', '$codproveedor', '1', '0')";
//	$rs_operacion=mysql_query($query_operacion);
//	$codfactura=mysql_insert_id();

        include("class/facturasp.php");
        $facturap = new Facturap();
        $idfactura=$facturap->save_factura($conn, $idproveedor, $codfactura, $serie1,$serie2,$autorizacion,$fecha, $descuento,$iva0, $iva12,$importeiva,$flete,$totalfactura, $credito, $plazo, $tipo_comprobante,$retencion,$cuenta);


	if ($idfactura)
        {
            $mensaje_minimo="<ul>";
            $mensaje="La factura de compra ha sido dada de alta correctamente";
            $validacion=0;
            $query_tmp="SELECT * FROM factulineaptmp WHERE codfactura='$codfacturatmp' ORDER BY numlinea ASC";
            $rs_tmp=mysql_query($query_tmp, $conn);

                $contador=0;
                //$baseimponible=0;
                include("class/factulineap.php");
                $factulineap= new Factulineap();

                $num_rows=mysql_num_rows($rs_tmp);
                while ($contador < $num_rows)
                {
                    //$codfamilia=mysql_result($rs_tmp,$contador,"codfamilia");
                    $id_producto=mysql_result($rs_tmp,$contador,"id_articulo");
                    $cantidad=mysql_result($rs_tmp,$contador,"cantidad");
                    $costo=mysql_result($rs_tmp,$contador,"costo");                      
                    $subtotal=mysql_result($rs_tmp,$contador,"importe");
                    $dcto=mysql_result($rs_tmp,$contador,"dcto");
                    $iva=mysql_result($rs_tmp,$contador,"iva");
                    $pvp=mysql_result($rs_tmp,$contador,"pvp");
                    //$baseimponible=$baseimponible+$importe;
                    
                    $result=$factulineap->save_factulinea($conn,$idfactura, $id_producto, $cantidad, $costo, $dcto, $subtotal,$iva);
                    

                    $sel_articulos="UPDATE producto SET stock=(stock+'$cantidad'), costo='$costo', pvp='$pvp' WHERE id_producto='$id_producto'";
                    $rs_articulos=mysql_query($sel_articulos, $conn);
                    
                                        
                    
                    $contador++;
                }

                $query="DELETE FROM factulineaptmp WHERE codfactura='$codfacturatmp'";
                $rs=mysql_query($query, $conn);
                $query="DELETE FROM facturasptmp WHERE codfactura='$codfacturatmp'";
                $rs=mysql_query($query, $conn);

        }
         
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar la FACTURA de COMPRA</span>";
            $validacion=1;
        }
             
	$cabecera1="Inicio >> Compras &gt;&gt; Nueva Factura ";
	$cabecera2="INSERTAR FACTURA de COMPRA ";
}

if ($accion=="modificar") {
	$idfactura=$_POST["idfactura"];
	$act_factura="UPDATE facturasp SET codigo_factura='$codfactura', serie1='$serie1', serie2='$serie2', autorizacion='$autorizacion',
                                           fecha='$fecha',id_proveedor='$idproveedor', credito='$credito', plazo='$plazo',
                                           tipocomprobante='$tipo_comprobante', retencion='$retencion' ,cuenta='$cuenta', descuento='$descuento', 
                                           iva0='$iva0', iva12='$iva12', iva='$importeiva', flete='$flete', totalfactura='$totalfactura'  
                       WHERE id_facturap='$idfactura'";
	$rs_factura=mysql_query($act_factura,$conn);
        
        $act_retencion="UPDATE retencion SET fecha='$fecha' WHERE id_factura='$idfactura'";
        $rs_retencion=mysql_query($act_retencion,$conn);
        
	

        $query_mostrar="SELECT * FROM facturasp WHERE id_facturap='$idfactura'";
	$rs_mostrar=mysql_query($query_mostrar);

        $descuento=mysql_result($rs_mostrar,0,"descuento");
        $iva0=mysql_result($rs_mostrar,0,"iva0");
        $iva12=mysql_result($rs_mostrar,0,"iva12");
        $importeiva=mysql_result($rs_mostrar,0,"iva");
        $flete=mysql_result($rs_mostrar,0,"flete");
        $totalfactura=mysql_result($rs_mostrar,0,"totalfactura");
        $baseimponible=$totalfactura-$flete-$importeiva+$descuento;

	if ($rs_factura) 
        {
            $mensaje="Los datos de la factura han sido modificados correctamente";
            $validacion=0;
        }
        else 
        {
            $mensaje="Error al modificar factura";
            $validacion=1;
        }
	$cabecera1="Inicio >> Compras &gt;&gt; Modificar Factura ";
	$cabecera2="MODIFICAR FACTURA ";
}

if ($accion=="baja") {


	$idfactura=$_GET["idfactura"];
        include("class/facturasp.php");
        $facturap= new Facturap();


	//$query="UPDATE facturas SET anulado=1 WHERE id_factura='$idfactura'";
	//$rs_query=mysql_query($query,$conn);
        $result=$facturap->delete_factura($conn,$idfactura);

        $query="DELETE FROM pagos WHERE id_factura=$idfactura";
        $rs_del=mysql_query($query,$conn);

        $query="DELETE FROM librodiario WHERE id_factura=$idfactura AND tipodocumento=1";
        $rs_del=mysql_query($query,$conn);

	$query="SELECT * FROM factulineap WHERE id_facturap='$idfactura'";
	$rs_tmp=mysql_query($query,$conn);
	$contador=0;
	$baseimponible=0;
	while ($contador < mysql_num_rows($rs_tmp)) {

		$idproducto=mysql_result($rs_tmp,$contador,"id_producto");
		$cantidad=mysql_result($rs_tmp,$contador,"cantidad");
		$sel_articulos="UPDATE producto SET stock=(stock-'$cantidad') WHERE id_producto='$idproducto'";
		$rs_articulos=mysql_query($sel_articulos);
		$contador++;
	}
	if ($result) { $mensaje="La factura de compra ha sido anulada correctamente"; }
	$cabecera1="Inicio >> Ventas &gt;&gt; Anular Factura de Compra";
	$cabecera2="ANULAR FACTURA de COMPRA";
	$query_mostrar="SELECT * FROM facturasp WHERE id_facturap='$idfactura'";
	$rs_mostrar=mysql_query($query_mostrar);

        $codfactura=mysql_result($rs_mostrar,0,"codigo_factura");
        $serie1=mysql_result($rs_mostrar,0,"serie1");
        $serie2=mysql_result($rs_mostrar,0,"serie2");
        $autorizacion=mysql_result($rs_mostrar,0,"autorizacion");
        $idproveedor=mysql_result($rs_mostrar,0,"id_proveedor");
        $fecha=mysql_result($rs_mostrar,0,"fecha");
        $credito=mysql_result($rs_mostrar,0,"credito");
        $plazo=mysql_result($rs_mostrar,0,"plazo");
        $tipo_comprobante=mysql_result($rs_mostrar,0,"tipocomprobante");

        $descuento=mysql_result($rs_mostrar,0,"descuento");
        $iva0=mysql_result($rs_mostrar,0,"iva0");
        $iva12=mysql_result($rs_mostrar,0,"iva12");
        $importeiva=mysql_result($rs_mostrar,0,"iva");
        $flete=mysql_result($rs_mostrar,0,"flete");
        $totalfactura=mysql_result($rs_mostrar,0,"totalfactura");
        $baseimponible=$totalfactura-$flete-$importeiva+$descuento;


        $validacion=0;
}

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
		
		function aceptar(validacion, accion, idfactura) {
			if(validacion==0)
                            if(accion=="alta")
                            {
                                location.href="../pagos/ver_pagos.php?idfactura=" + idfactura;
                            }
                            else
                                location.href="index.php";
                        else
                            history.back();
		}


                function aceptar_retencion(validacion, accion, idfactura) {
			if(validacion==0)
                            if(accion=="alta")
                            {
                                location.href="../retenciones/new_retencion.php?idfactura=" + idfactura;
                            }
                            else
                                location.href="index.php";
                        else
                            history.back();
		}

		
		function imprimir(codfactura) {
			window.open("../impresion/imprimir_factura.php?codfactura="+codfactura);
		}
		
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header"><?php  echo $cabecera2?></div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="15%"></td>
							<td width="85%" colspan="2" class="mensaje"><?php  echo $mensaje;?></td>
					    </tr>
						<?php  if ($minimo==1) { ?>
						<tr>
							<td width="15%"></td>
							<td width="85%" colspan="2" class="mensajeminimo">Los siguientes productos se encuentran sin stock:<br><?php  echo $mensaje_minimo ."</ul>"?></td>
					    </tr>
						<?php  } 
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
                                                                case 2: echo "NOTA DE VENTA";
                                                                    break;
                                                                case 3: echo "Liquidaciones de  Compra";
                                                                    break;
                                                            }
                                                    ?>
                                                  </td>
					  </tr>
                                          <tr>
						  <td>No. Factura</td>
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
                                            
					  <?php  //$sel_lineas="SELECT factulinea.*,articulos.*,familias.nombre as nombrefamilia FROM factulinea,articulos,familias WHERE factulinea.codfactura='$codfactura' AND factulinea.codigo=articulos.codarticulo AND factulinea.codfamilia=articulos.codfamilia AND articulos.codfamilia=familias.codfamilia ORDER BY factulinea.numlinea ASC";
                                                $sel_lineas="SELECT b.codigo as codigo, b.nombre as nombre, a.cantidad as cantidad, a.costo as costo, a.subtotal as subtotal, a.dcto as dcto, a.iva as iva FROM factulineap a INNER JOIN producto b ON a.id_producto=b.id_producto WHERE a.id_facturap = '$idfactura'";
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
                                            <?php  if ($accion=="alta")
                                            {
                                             ?>
                                                <img src="../img/botonretencion_hacer.jpg" width="85" height="22" onClick="aceptar_retencion(<?php echo $validacion?>,'<?php  echo $accion?>',<?php  echo $idfactura?>)" border="1" onMouseOver="style.cursor=cursor">
                                                <img src="../img/botonpagar.png" width="85" height="22" onClick="aceptar(<?php echo $validacion?>,'<?php  echo $accion?>',<?php  echo $idfactura?>)" border="1" onMouseOver="style.cursor=cursor">
                                            <?php  } else{?>
                                                <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php echo $validacion?>,'<?php  echo $accion?>',<?php  echo $idfactura?>)" border="1" onMouseOver="style.cursor=cursor">
                                             <?php }?>
                                         <!--<img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir(<?php  echo $codfactura?>)" onMouseOver="style.cursor=cursor">-->
				        </div>
					</div>
			  </div>
		  </div>
		</div>
	</body>
</html>
