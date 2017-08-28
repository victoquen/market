<?php

include("../js/fechas.php");
$hoy = date("d/m/Y");
error_reporting(0);
include("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


if ($_POST["accion"] == "") {
    $accion = $_GET["accion"];

} else {
    $accion = $_POST["accion"];
}


if ($accion == "ver") {
    $idfactura = $_GET["idfactura"];
    if ($_GET["importe"] != "") {
        $importe = $_GET["importe"];

        ?>
        <script>

            var valor1 =<?php echo $importe;?>
                parent.document.getElementById("pendiente").value = valor1;

        </script>
        <?php
    }
}
if ($accion == "eliminado") {
    $idfactura = $_GET["idfactura"];
    if ($_REQUEST["importe"] != "") {
        $importe = $_REQUEST["importe"];

        ?>
        <script>


            parent.document.getElementById("pendiente").value =<?php echo $importe;?>;
            <?php
            $act_factura = "UPDATE facturasp SET estado='0' WHERE id_facturap='$idfactura'";
            $rs_act = mysql_query($act_factura, $conn);
            ?>
            parent.document.getElementById("cboEstados").value = 0;
        </script>
        <?php
    }
}

if ($accion == "insertar") {
    $importe = $_POST["Rimporte"];
    $idproveedor = $_POST["idproveedor"];
    $idfactura = $_POST["idfactura"];
    $formapago = $_POST["AcboFP"];
    if ($formapago == 1) {
        $idbanco = 1;
    } else {
        $idbanco = $_POST["acbobanco"];
    }
    $documento = $_POST["adocumento_numero"];
    $recibo = $_POST["arecibo_numero"];
    $observaciones = $_POST["observaciones"];
    //$estado=$_POST["cboEstados"];
    $fechacobro = $_POST["fechacobro"];
    if ($fechacobro <> "") {
        $fechacobro = explota($fechacobro);
    }
    $sel_insertar = "INSERT INTO pagos (id_pago,id_factura,id_proveedor,importe,id_formapago,id_banco,fechacobro,documento,recibo,observaciones) VALUES
                                          (null,'$idfactura','$idproveedor','$importe','$formapago','$idbanco','$fechacobro','$documento','$recibo','$observaciones')";
    $rs_insertar = mysql_query($sel_insertar, $conn);
    $idmov_pago = mysql_insert_id();

    //1 compra
    //2 venta

    $sel_libro = "INSERT INTO librodiario (id_librodiario,id_mov,fecha,tipodocumento,id_factura,id_cliente,id_formapago,id_banco,total) VALUES
                                            (null,'$idmov_pago','$fechacobro','1','$idfactura','$idproveedor','$formapago','$idbanco','$importe')";
    $rs_libro = mysql_query($sel_libro, $conn);


    ?>
    <script>
        parent.document.getElementById("observaciones").value = "";
        parent.document.getElementById("Rimporte").value = "";
        parent.document.getElementById("acbobanco").value = "0";
        parent.document.getElementById("AcboFP").value = "0";
        parent.document.getElementById("adocumento_numero").value = "";
        parent.document.getElementById("arecibo_numero").value = "";
        parent.document.getElementById("fechacobro").value = "<?php  echo $hoy?>";
        var importe =<?php  echo $importe?>;
        var total = parent.document.getElementById("pendiente").value - parseFloat(importe);
        var original = parseFloat(total);
        var result = Math.round(original * 100) / 100;
        parent.document.getElementById("pendiente").value = result;


        <?php


        $select_facturas = "SELECT totalfactura FROM facturasp  WHERE facturasp.id_facturap=$idfactura";
        $rs_facturas = mysql_query($select_facturas, $conn);
        $totalfactura = mysql_result($rs_facturas, 0, "totalfactura");

        $query_retencion = "SELECT totalretencion FROM retencion WHERE (anulado = 0) AND id_factura='$idfactura'";
        $rs_retencion = mysql_query($query_retencion, $conn);
        $retencion = mysql_result($rs_retencion, 0, "totalretencion");


        $sel_pagos = "SELECT sum(importe) as aportaciones FROM pagos WHERE id_factura=$idfactura";
        $rs_pagos = mysql_query($sel_pagos, $conn);
        if ($rs_pagos) {
            $aportaciones = mysql_result($rs_pagos, 0, "aportaciones");
        } else {
            $aportaciones = 0;
        }
        $pendiente = $totalfactura - $aportaciones - $retencion;


        if ($pendiente == 0) {
            $act_factura = "UPDATE facturasp SET estado='1' WHERE id_facturap='$idfactura'";
            $rs_act = mysql_query($act_factura, $conn);
        }
        ?>


    </script><?php
}

$query_busqueda = "SELECT count(*) as filas FROM pagos,proveedor WHERE pagos.id_proveedor=proveedor.id_proveedor AND pagos.id_factura='$idfactura' order BY id_pago DESC";
$rs_busqueda = mysql_query($query_busqueda, $conn);
$filas = mysql_result($rs_busqueda, 0, "filas");


?>
<html>
<head>
    <title>Clientes</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
    <script language="javascript">

        function abreVentana(observaciones) {
            miPopup = window.open("ver_observaciones.php?observaciones=" + observaciones, "miwin", "width=380,height=240,scrollbars=yes");
            miPopup.focus();
        }

        function eliminar(idfactura, idmov, fechacobro, importe) {
            miPopup = window.open("eliminar.php?idfactura=" + idfactura + "&idmov=" + idmov + "&fechacobro=" + fechacobro + "&importe=" + importe, "frame_datos", "width=380,height=240,scrollbars=yes");
            miPopup.focus();
        }

        function ver_pagos(idfactura) {
            parent.location.href = "ver_pagos.php?idfactura=" + idfactura + "&cadena_busqueda=<?php  echo $cadena_busqueda?>";
        }

    </script>
</head>
<body>
<div id="zonaContenido">
    <div align="center">
        <table class="fuente8" width="99%" cellspacing=0 cellpadding=3 border=0 ID="Table1">


            <form name="form1" id="form1">
                <?php if ($filas > 0) { ?>
                <?php $sel_resultado = "SELECT pagos.id_pago, pagos.id_factura, pagos.fechacobro, pagos.importe,
                                                                          formapago.nombre as nombrefp, pagos.id_banco,pagos.documento,
                                                                          pagos.recibo, pagos.observaciones
                                                                   FROM facturasp,pagos,proveedor,formapago
                                                                   WHERE pagos.id_factura='$idfactura' AND pagos.id_factura=facturasp.id_facturap AND pagos.id_proveedor=proveedor.id_proveedor AND pagos.id_formapago=formapago.id_formapago
                                                                   ORDER BY pagos.id_pago DESC";
                $res_resultado = mysql_query($sel_resultado, $conn);
                $contador = 0;
                while ($contador < mysql_num_rows($res_resultado)) {
                    if ($contador % 2) {
                        $fondolinea = "itemParTabla";
                    } else {
                        $fondolinea = "itemImparTabla";
                    } ?>
                    <tr class="<?php echo $fondolinea ?>">
                        <td class="aCentro" width="4%"><?php echo $contador + 1; ?></td>
                        <td width="12%">
                            <div
                                align="center"><?php echo implota(mysql_result($res_resultado, $contador, "fechacobro")) ?></div>
                        </td>
                        <td width="12%">
                            <div
                                align="center"><?php echo number_format(mysql_result($res_resultado, $contador, "importe"), 4, ",", ".") ?></div>
                        </td>
                        <td width="15%">
                            <div align="center"><?php echo mysql_result($res_resultado, $contador, "nombrefp") ?></div>
                        </td>
                        <td class="aDerecha" width="15%">
                            <div align="center">
                                <?php
                                if (mysql_result($res_resultado, $contador, "id_banco") == 0)
                                    echo "---";
                                else {
                                    $bancos_resultado = "SELECT nombre FROM banco WHERE id_banco='" . mysql_result($res_resultado, $contador, "id_banco") . "'";
                                    $res_bancos = mysql_query($bancos_resultado, $conn);
                                    echo mysql_result($res_bancos, 0, "nombre");
                                }
                                ?>
                            </div>
                        </td>
                        <td width="15%">
                            <div align="center">
                                <?php if (mysql_result($res_resultado, $contador, "documento") == "")
                                    echo "---";
                                else {
                                    echo mysql_result($res_resultado, $contador, "documento");
                                }
                                ?>
                            </div>
                        </td>
                        <td width="15%">
                            <div align="center">
                                <?php if (mysql_result($res_resultado, $contador, "recibo") == "")
                                    echo '---';
                                else {
                                    echo mysql_result($res_resultado, $contador, "recibo");
                                }
                                ?>
                            </div>
                        </td>
                        <td width="5%">
                            <div align="center"><a href="#"><img src="../img/observaciones.png" width="16" height="16"
                                                                 border="0"
                                                                 onClick="abreVentana('<?php echo mysql_result($res_resultado, $contador, "observaciones") ?>')"
                                                                 title="Ver Observaciones"></a></div>
                        </td>
                        <td width="5%">
                            <div align="center"><a href="#"><img src="../img/eliminar.png" width="16" height="16"
                                                                 border="0"
                                                                 onClick="eliminar('<?php echo mysql_result($res_resultado, $contador, "id_factura") ?>','<?php echo mysql_result($res_resultado, $contador, "id_pago") ?>','<?php echo mysql_result($res_resultado, $contador, "fechacobro") ?>','<?php echo mysql_result($res_resultado, $contador, "importe") ?>')"
                                                                 title="Eliminar"></a></div>
                        </td>
                    </tr>
                    <?php $contador++;
                }
                ?>
        </table>
        <?php } else { ?>
            <table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
                <tr>
                    <td width="100%"
                        class="mensaje"><?php echo "Todav&iacute;a no se ha producido ning&uacute;n cobro de esta factura."; ?></td>
                </tr>
            </table>
        <?php } ?>
        </form>

    </div>
    <iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
        <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
    </iframe>
</div>

</body>
</html>
