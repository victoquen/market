<?php

include("../js/fechas.php");
include("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);

$accion = $_POST["accion"];
if (!isset($accion)) {
    $accion = $_GET["accion"];
}
if ($accion != "baja") {

    $fecha = explota($_POST["fecha"]);
    $transferenciatmp = $_POST["transferenciatmp"];
}
$minimo = 0;

if ($accion == "alta") {
    
    include("class/transferencia.php");
    $transferencia = new Transferencia();

    $query_cont = "SELECT * FROM transferencialineatmp WHERE id_transferencia='$transferenciatmp' ORDER BY numlinea ASC";
    $rs_cont = mysql_query($query_cont, $conn);
    $num_rows_cont = mysql_num_rows($rs_cont);
    if ($num_rows_cont > 0) {


        $idtransferencia = $transferencia->save($conn, $fecha);


        if ($idtransferencia) {
            $mensaje_minimo = "<ul>";
            $mensaje = "La transferencia de bodega ha sido dada de alta correctamente";
            $validacion = 0;
            $query_tmp = "SELECT * FROM transferencialineatmp WHERE id_transferencia='$transferenciatmp' ORDER BY numlinea ASC";
            $rs_tmp = mysql_query($query_tmp, $conn);

            $contador = 0;
            //$baseimponible=0;

            include("../producto_serie/class/Productoserie.php");
            include("class/transferencialinea.php");
            $transferencialinea = new Transferencialinea();

            $num_rows = mysql_num_rows($rs_tmp);
            while ($contador < $num_rows) {

                $idbodegaorigen = mysql_result($rs_tmp, $contador, "id_bodegaorigen");
                $idbodegadestino = mysql_result($rs_tmp, $contador, "id_bodegadestino");
                $id_producto = mysql_result($rs_tmp, $contador, "id_producto");
                $cantidad = mysql_result($rs_tmp, $contador, "cantidad");

                //SERIES SPLIT *********************************************************************************************
                $seriestemp = mysql_result($rs_tmp, $contador, "series");
                $series = split("----", $seriestemp);
                //**********************************************************************************************************


                $result = $transferencialinea->save($conn, $idtransferencia, $idbodegaorigen, $idbodegadestino, $id_producto, $cantidad);


                $query_bodega = "SELECT id_productobodega, stock FROM productobodega WHERE id_producto = '$id_producto' AND id_bodega = '$idbodegaorigen'";
                $rs_bodega = mysql_query($query_bodega, $conn);
                $stock_bodega = mysql_result($rs_bodega, 0, "stock");
                $id_productobodega = mysql_result($rs_bodega, 0, "id_productobodega");


                $query_upbod = "UPDATE productobodega SET stock = (stock - '$cantidad') WHERE id_productobodega = '$id_productobodega'";
                $rs_updbod = mysql_query($query_upbod, $conn);


                $query_bodega = "SELECT id_productobodega, stock FROM productobodega WHERE id_producto = '$id_producto' AND id_bodega = '$idbodegadestino'";
                $rs_bodega = mysql_query($query_bodega, $conn);
                $stock_bodega = mysql_result($rs_bodega, 0, "stock");
                $id_productobodega = mysql_result($rs_bodega, 0, "id_productobodega");


                $query_upbod = "UPDATE productobodega SET stock = (stock + '$cantidad') WHERE id_productobodega = '$id_productobodega'";
                $rs_updbod = mysql_query($query_upbod, $conn);

                $query_totstock = "SELECT SUM(stock) as total FROM productobodega WHERE id_producto = '$id_producto'";
                $rs_totstock = mysql_query($query_totstock, $conn);
                $totstock = mysql_result($rs_totstock, 0, "total");

                $sel_articulos = "UPDATE producto SET stock='$totstock' WHERE id_producto='$id_producto'";
                $rs_articulos = mysql_query($sel_articulos, $conn);

                // UPDATE SERIES PRODUCTO *********************************************************************************
                foreach ($series as $s) {
                    $serie = new Productoserie();
                    $res_serie = $serie->transferencia($conn, $id_productobodega, $s);
                }
                //**********************************************************************************************************

                $contador++;
            }

            $query = "DELETE FROM transferencialineatmp WHERE id_transferencia='$transferenciatmp'";
            $rs = mysql_query($query, $conn);
            $query = "DELETE FROM transferenciatmp WHERE id_transferencia='$transferenciatmp'";
            $rs = mysql_query($query, $conn);

        } else {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar la TRANSFERENCIA</span>";
            $validacion = 1;
        }
    }else{
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   NO EXISTEN TRANSFERENCIAS DE PRODUCTOS, ERROR al ingresar la TRANSFERENCIA</span>";
        $validacion = 1;
    }

    $query = "DELETE FROM transferencialineatmp WHERE id_transferencia='$transferenciatmp'";
    $rs = mysql_query($query, $conn);
    $query = "DELETE FROM transferenciatmp WHERE id_transferencia='$transferenciatmp'";
    $rs = mysql_query($query, $conn);

    $cabecera1 = "Inicio >> Transferencia &gt;&gt; Nueva Transferencia ";
    $cabecera2 = "INSERTAR TRANSFRERENCIA" . $mensaje;
}

if ($accion == "modificar") {
    $idfactura = $_POST["idfactura"];
    $act_factura = "UPDATE facturasp SET codigo_factura='$codfactura', serie1='$serie1', serie2='$serie2', autorizacion='$autorizacion',
                                           fecha='$fecha',id_proveedor='$idproveedor', credito='$credito', plazo='$plazo',
                                           tipocomprobante='$tipo_comprobante', retencion='$retencion' ,cuenta='$cuenta', descuento='$descuento', 
                                           iva0='$iva0', iva12='$iva12', iva='$importeiva', flete='$flete', totalfactura='$totalfactura'  
                       WHERE id_facturap='$idfactura'";
    $rs_factura = mysql_query($act_factura, $conn);

    $act_retencion = "UPDATE retencion SET fecha='$fecha' WHERE id_factura='$idfactura'";
    $rs_retencion = mysql_query($act_retencion, $conn);


    $query_mostrar = "SELECT * FROM facturasp WHERE id_facturap='$idfactura'";
    $rs_mostrar = mysql_query($query_mostrar);

    $descuento = mysql_result($rs_mostrar, 0, "descuento");
    $iva0 = mysql_result($rs_mostrar, 0, "iva0");
    $iva12 = mysql_result($rs_mostrar, 0, "iva12");
    $importeiva = mysql_result($rs_mostrar, 0, "iva");
    $flete = mysql_result($rs_mostrar, 0, "flete");
    $totalfactura = mysql_result($rs_mostrar, 0, "totalfactura");
    $baseimponible = $totalfactura - $flete - $importeiva + $descuento;

    if ($rs_factura) {
        $mensaje = "Los datos de la factura han sido modificados correctamente";
        $validacion = 0;
    } else {
        $mensaje = "Error al modificar factura";
        $validacion = 1;
    }
    $cabecera1 = "Inicio >> Compras &gt;&gt; Modificar Factura ";
    $cabecera2 = "MODIFICAR FACTURA ";
}

if ($accion == "baja") {


    $idfactura = $_GET["idfactura"];
    include("class/facturasp.php");
    $facturap = new Facturap();


    //$query="UPDATE facturas SET anulado=1 WHERE id_factura='$idfactura'";
    //$rs_query=mysql_query($query,$conn);
    $result = $facturap->delete_factura($conn, $idfactura);

    $query = "DELETE FROM pagos WHERE id_factura=$idfactura";
    $rs_del = mysql_query($query, $conn);

    $query = "DELETE FROM librodiario WHERE id_factura=$idfactura AND tipodocumento=1";
    $rs_del = mysql_query($query, $conn);

    $query = "SELECT * FROM transferencialinea WHERE id_facturap='$idfactura'";
    $rs_tmp = mysql_query($query, $conn);
    $contador = 0;
    $baseimponible = 0;
    while ($contador < mysql_num_rows($rs_tmp)) {

        $idproducto = mysql_result($rs_tmp, $contador, "id_producto");
        $cantidad = mysql_result($rs_tmp, $contador, "cantidad");
        $sel_articulos = "UPDATE producto SET stock=(stock-'$cantidad') WHERE id_producto='$idproducto'";
        $rs_articulos = mysql_query($sel_articulos);
        $contador++;
    }
    if ($result) {
        $mensaje = "La factura de compra ha sido anulada correctamente";
    }
    $cabecera1 = "Inicio >> Ventas &gt;&gt; Anular Factura de Compra";
    $cabecera2 = "ANULAR FACTURA de COMPRA";
    $query_mostrar = "SELECT * FROM facturasp WHERE id_facturap='$idfactura'";
    $rs_mostrar = mysql_query($query_mostrar);

    $codfactura = mysql_result($rs_mostrar, 0, "codigo_factura");
    $serie1 = mysql_result($rs_mostrar, 0, "serie1");
    $serie2 = mysql_result($rs_mostrar, 0, "serie2");
    $autorizacion = mysql_result($rs_mostrar, 0, "autorizacion");
    $idproveedor = mysql_result($rs_mostrar, 0, "id_proveedor");
    $fecha = mysql_result($rs_mostrar, 0, "fecha");
    $credito = mysql_result($rs_mostrar, 0, "credito");
    $plazo = mysql_result($rs_mostrar, 0, "plazo");
    $tipo_comprobante = mysql_result($rs_mostrar, 0, "tipocomprobante");

    $descuento = mysql_result($rs_mostrar, 0, "descuento");
    $iva0 = mysql_result($rs_mostrar, 0, "iva0");
    $iva12 = mysql_result($rs_mostrar, 0, "iva12");
    $importeiva = mysql_result($rs_mostrar, 0, "iva");
    $flete = mysql_result($rs_mostrar, 0, "flete");
    $totalfactura = mysql_result($rs_mostrar, 0, "totalfactura");
    $baseimponible = $totalfactura - $flete - $importeiva + $descuento;


    $validacion = 0;
}

?>


<html>
<head>
    <title>Principal</title>

    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>

    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
    <script language="javascript">
        var cursor;
        if (document.all) {
            // Está utilizando EXPLORER
            cursor = 'hand';
        } else {
            // Está utilizando MOZILLA/NETSCAPE
            cursor = 'pointer';
        }

        function aceptar(validacion) {


            location.href = "index.php";

        }


        function aceptar_retencion(validacion, accion, idfactura) {
            if (validacion == 0)
                if (accion == "alta") {
                    location.href = "../retenciones/new_retencion.php?idfactura=" + idfactura;
                }
                else
                    location.href = "index.php";
            else
                history.back();
        }


        function imprimir(idtransferencia) {
            //window.open("../imprimir/imprimir_transferencia.php?idtransferencia="+idtransferencia);
            window.open("../class/imprimir_transferencia.php?id_transferencia=" + idtransferencia);
        }

    </script>
</head>
<body>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $cabecera2 ?></div>
            <div id="frmBusqueda">


                <tr>
                    <td>Transferencia No.:</td>
                    <td colspan="2"><?php echo $idtransferencia ?></td>
                </tr>
                <tr>
                    <td>Fecha</td>
                    <td colspan="2"><?php echo implota($fecha) ?></td>
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
                    $sel_lineas = "SELECT b.codigo as codigo, b.nombre as nombre, a.cantidad as cantidad, a.id_bodegaorigen as idbodegaorigen, 
												a.id_bodegadestino as idbodegadestino   
										FROM producto b INNER JOIN  transferencialinea a ON b.id_producto = a.id_producto 
										WHERE a.id_transferencia = $idtransferencia ";
                    $rs_lineas = mysql_query($sel_lineas, $conn);
                    for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
                        $codarticulo = mysql_result($rs_lineas, $i, "codigo");
                        $descripcion = mysql_result($rs_lineas, $i, "nombre");
                        $cantidad = mysql_result($rs_lineas, $i, "cantidad");
                        $idbodegaorigen = mysql_result($rs_lineas, $i, "idbodegaorigen");
                        $idbodegadestino = mysql_result($rs_lineas, $i, "idbodegadestino");


                        $queryb = "SELECT nombre FROM bodega WHERE id_bodega = '$idbodegaorigen'";
                        $resb = mysql_query($queryb, $conn);
                        $nombodegaorigen = mysql_result($resb, 0, "nombre");

                        $queryb = "SELECT nombre FROM bodega WHERE id_bodega = '$idbodegadestino'";
                        $resb = mysql_query($queryb, $conn);
                        $nombodegadestino = mysql_result($resb, 0, "nombre");


                        if ($i % 2) {
                            $fondolinea = "itemParTabla";
                        } else {
                            $fondolinea = "itemImparTabla";
                        } ?>
                        <tr class="<?php echo $fondolinea ?>">

                            <td width="5%"><?php echo $codarticulo ?></td>
                            <td width="41%" align="center"><?php echo $descripcion ?></td>
                            <td width="5%"><?php echo $cantidad ?></td>
                            <td width="22%" align="center"><?php echo $nombodegaorigen ?></td>
                            <td width="22%" align="center"><?php echo $nombodegadestino ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>


            <div id="botonBusqueda">
                <div align="center">

                    <img src="../img/botonaceptar.jpg" width="85" height="22"
                         onClick="aceptar(<?php echo $validacion ?>)" border="1" onMouseOver="style.cursor=cursor">
                    <img src="../img/botonimprimir.jpg" width="79" height="22" border="1"
                         onClick="imprimir(<?php echo $idtransferencia ?>)" onMouseOver="style.cursor=cursor">
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
