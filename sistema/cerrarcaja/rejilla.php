<?php

include("../js/fechas.php");
//error_reporting(0);
include("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$id_facturero = $_POST["facturero"];
$fechainicio = $_POST["fechainicio"];
if ($fechainicio <> "") {
    $fechainicio = explota($fechainicio);
}


$q_fact = "SELECT CONCAT( f.serie1,  '-', f.serie2 ) AS leyendafacturero
            FROM facturero f
            WHERE f.id_facturero = '$id_facturero'";
$rs_fact = mysql_query($q_fact, $conn);
$leyendafacturero = mysql_result($rs_fact, 0, "leyendafacturero");
//$cadena_busqueda=$_POST["cadena_busqueda"];

//ventas-----------------------------------------------------------------------------------------------------
$sel_facturas = "SELECT  sum(totalfactura) as totalfac, sum(iva) as totaliva, sum(ret_iva) as totalretiva, sum(ret_fuente) as totalretfuente FROM facturas WHERE anulado = 0 AND fecha='$fechainicio'";
$rs_facturas = mysql_query($sel_facturas, $conn);

if (mysql_num_rows($rs_facturas) > 0) {
    $total = mysql_result($rs_facturas, 0, "totalfac");
    $totaliva = mysql_result($rs_facturas, 0, "totaliva");
    $totalretiva = mysql_result($rs_facturas, 0, "totalretiva");
    $totalretfuente = mysql_result($rs_facturas, 0, "totalretfuente");
} else {
    $total = 0;
    $totaliva = 0;
    $totalretiva = 0;
    $totalretfuente = 0;
}


$neto = $total - $totaliva - $totalretiva - $totalretfuente;


$sel_cobros = "SELECT sum(a.importe) as suma,a.id_formapago, b.nombre
FROM cobros a INNER JOIN formapago b ON a.id_formapago=b.id_formapago
WHERE fechacobro='$fechainicio'
GROUP BY a.id_formapago, b.nombre
ORDER BY id_formapago ASC";

$rs_cobros = mysql_query($sel_cobros, $conn);


//ventas por caja-----------------------------------------------------------------------------------------------------

$sel_facturascaja = "SELECT  sum(totalfactura) as totalfac, sum(iva) as totaliva, sum(ret_iva) as totalretiva, sum(ret_fuente) as totalretfuente 
                FROM facturas 
                WHERE anulado = 0 AND fecha='$fechainicio' AND id_facturero = '$id_facturero'";
$rs_facturascaja = mysql_query($sel_facturascaja, $conn);


if (mysql_num_rows($rs_facturascaja) > 0) {
    $totalcaja = mysql_result($rs_facturascaja, 0, "totalfac");
    $totalivacaja = mysql_result($rs_facturascaja, 0, "totaliva");
    $totalretivacaja = mysql_result($rs_facturascaja, 0, "totalretiva");
    $totalretfuentecaja = mysql_result($rs_facturascaja, 0, "totalretfuente");
} else {
    $totalcaja = 0;
    $totalivacaja = 0;
    $totalretivacaja = 0;
    $totalretfuentecaja = 0;
}


$netocaja = $totalcaja - $totalivacaja - $totalretivacaja - $totalretfuentecaja;


$sel_cobroscaja = "SELECT sum(a.importe) as suma,a.id_formapago, b.nombre
FROM cobros a 
INNER JOIN formapago b ON a.id_formapago=b.id_formapago
INNER JOIN facturas f ON a.id_factura = f.id_factura
WHERE fechacobro='$fechainicio' AND f.id_facturero = '$id_facturero'
GROUP BY a.id_formapago, b.nombre
ORDER BY id_formapago ASC";

$rs_cobroscaja = mysql_query($sel_cobroscaja, $conn);


//compras----------------------------------------------------------------------------------------------------------------------------


$sel_facturasp = "SELECT  sum(fp.totalfactura) as totalfac, sum(r.totalretencion) as retenciones, sum(fp.iva) as totaliva 
                FROM facturasp fp INNER JOIN retencion r ON fp.id_facturap = r.id_factura 
                WHERE fp.anulado = 0 AND r.anulado = 0 AND fp.fecha='$fechainicio'";
$rs_facturasp = mysql_query($sel_facturasp, $conn);

if (mysql_num_rows($rs_facturasp) > 0) {
    $totalp = mysql_result($rs_facturasp, 0, "totalfac");
    $retencionesp = mysql_result($rs_facturasp, 0, "retenciones");
    $totalivap = mysql_result($rs_facturasp, 0, "totaliva");
} else {
    $totalp = 0;
    $retencionesp = 0;
    $totalivap = 0;
}


$netop = $totalp - $totalivap;


$sel_pagos = "SELECT sum(a.importe) as suma,a.id_formapago, b.nombre
FROM pagos a INNER JOIN formapago b ON a.id_formapago=b.id_formapago
WHERE fechacobro='$fechainicio'
GROUP BY a.id_formapago, b.nombre
ORDER BY id_formapago ASC";

$rs_pagos = mysql_query($sel_pagos, $conn);


?>
<html>
<head>
    <title>Cierre Caja</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
    <!-- INICIO archivos para DATA TABLES-->
    <link href="../css/styleDT.css" type="text/css" rel="stylesheet">
    <link href="../css/style1.css" type="text/css" rel="stylesheet">

    <link href="../css/buttons.dataTables.min.css" type="text/css" rel="stylesheet">
    <link href="../css/dataTables.tableTools.css" type="text/css" rel="stylesheet">
    <link href="../css/dataTables.tableTools.min.css" type="text/css" rel="stylesheet">

    <script type="text/javascript" language="javascript" src="../js/jqueryComplementos.js"/>
    <script type="text/javascript" language="javascript" src="../js/jquery.dataTables1.min.js"/>
    <script type="text/javascript" language="javascript" src="../js/dataTables.buttons.min.js"/>
    <script type="text/javascript" language="javascript" src="../js/buttons.flash.min.js"/>
    <script type="text/javascript" language="javascript" src="../js/jszip.min.js"/>
    <script type="text/javascript" language="javascript" src="../js/pdfmake.min.js"/>
    <script type="text/javascript" language="javascript" src="../js/vfs_fonts.js"/>
    <script type="text/javascript" language="javascript" src="../js/buttons.html5.min.js"/>
    <script type="text/javascript" language="javascript" src="../js/buttons.print.min.js"/>

    <script type="text/javascript" charset="utf-8" src="../js/dataTables.tableTools.js"></script>
    <script type="text/javascript" charset="utf-8" src="../js/dataTables.tableTools.min.js"></script>
    <!-- FIN archivos para DATA TABLES-->


    <script>

        var cursor;
        if (document.all) {
            // Est� utilizando EXPLORER
            cursor = 'hand';
        } else {
            // Est� utilizando MOZILLA/NETSCAPE
            cursor = 'pointer';
        }

        function imprimir(fechainicio, minimo, maximo, neto, iva, total, contado, tarjeta) {
            location.href = "../fpdf/cerrarcaja_html.php?fechainicio=" + fechainicio + "&minimo=" + minimo + "&maximo=" + maximo + "&neto=" + neto + "&iva=" + iva + "&total=" + total + "&contado=" + contado + "&tarjeta=" + tarjeta;
        }


        $(document).ready(function () {

            oTable = $('#example').DataTable({

                "processing": true,
                "serverSide": true,
                "sPaginationType": "full_numbers",
                dom: '<"top"lBf>rt<"bottom"ip><"clear">',
                buttons: [
                    'excel', 'pdf', 'print'
                ],
                "sAjaxSource": "processing_listado_facturas.php?id_facturero=<?php echo $id_facturero;?>",

                "aaSorting": [[ 0, "desc" ]],

                "aoColumns": [
                    {"bVisible": false, "asSorting": ["desc", "asc"]},

                    {"asSorting": ["desc", "asc"]},
                    {"asSorting": ["desc", "asc"]},
                    {"asSorting": ["desc", "asc"]},
                    null,
                    null,
                    null,
                    null,
                    null,
                    null
                ],

                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": "Anterior",
                        "sNext": "Siguiente",
                        "sLast": "Ultima",
                        "sFirst": "Primera"
                    },

                    "sLengthMenu": 'Mostrar <select>' +
                    '<option value="5">5</option>' +
                    '<option value="10">10</option>' +
                    '<option value="15">15</option>' +
                    '<option value="20">25</option>' +
                    '<option value="-1">Todos</option>' +
                    '</select> registros',

                    "sInfo": "Mostrando _START_ a _END_ (de _TOTAL_ resultados)",

                    "sInfoFiltered": " - filtrados de _MAX_ registros",

                    "sInfoEmpty": "No hay resultados de b\xfasqueda",

                    "sZeroRecords": "No hay registros a mostrar",

                    "sProcessing": "Espere, por favor...",

                    "sSearch": "Buscar:"

                }


            });

        });
    </script>
</head>
<body>

<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <form id="formulario" name="formulario" method="post" action="rejilla.php" target="frame_rejilla">
                <table class="fuente8" width="90%" cellspacing=0 cellpadding=3 border=0>
                    <tr>

                        <td colspan="2" align="center"><b>CAJA FECHA: </b><?php echo implota($fechainicio) ?></td>


                    </tr>
                    <tr class="itemImparTabla">
                        <td align="left"><b>VENTAS(cobros)</b></td>
                        <td align="left"><b>COMPRAS(pagos)</b></td>
                    </tr>
                    <tr>
                        <!-- ventas*********************************************************************************** -->
                        <td>
                            <table class="fuente8" width="70%" cellspacing=0 cellpadding=3 border=0>
                                <tr>
                                    <td><b>Total Ret. Iva</b></td>
                                    <td><?php echo number_format($totalretiva, 2, ",", ".") ?> &#36;</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Total Ret. Fuente</b></td>
                                    <td><?php echo number_format($totalretfuente, 2, ",", ".") ?> &#36;</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Neto</b></td>
                                    <td><?php echo number_format($neto, 2, ",", ".") ?> &#36;</td>
                                    <td></td>


                                </tr>
                                <tr>
                                    <td><b>12% IVA</b></td>
                                    <td><?php echo number_format($totaliva, 2, ",", ".") ?> &#36;</td>
                                    <td></td>

                                </tr>
                                <tr class="itemImparTabla">
                                    <td><b>TOTAL en Facturas</b></td>
                                    <td></td>
                                    <td><b><?php echo number_format($total, 2, ",", ".") ?> &#36;</b></td>

                                </tr>

                                <?php
                                $totalcobrado = 0;
                                $contador = 0;
                                $efectivocobros = 0;
                                while ($contador < mysql_num_rows($rs_cobros)) {
                                    if (mysql_result($rs_cobros, $contador, "nombre") == "EFECTIVO")
                                        $efectivocobros = mysql_result($rs_cobros, $contador, "suma");

                                    ?>
                                    <tr>
                                        <td><b><?php echo mysql_result($rs_cobros, $contador, "nombre") ?></b></td>
                                        <td><?php echo number_format(mysql_result($rs_cobros, $contador, "suma"), 2, ",", ".") ?>
                                            &#36;</td>
                                        <td></td>

                                    </tr>

                                    <?php
                                    $totalcobrado = $totalcobrado + mysql_result($rs_cobros, $contador, "suma");
                                    $contador++;
                                }

                                ?>

                                <tr class="itemImparTabla">
                                    <td><strong>TOTAL Cobrado</strong></td>
                                    <td></td>
                                    <td><b><?php echo number_format($totalcobrado, 2, ",", ".") ?> &#36;</b></td>
                                </tr>
                            </table>
                        </td>


                        <!-- compras*********************************************************************************** -->
                        <td>
                            <table class="fuente8" width="70%" cellspacing=0 cellpadding=3 border=0>
                                <tr>
                                    <td><b>Valor de Retenciones</b></td>
                                    <td><?php echo number_format($retencionesp, 2, ",", ".") ?> &#36;</td>
                                    <td>&nbsp;</td>

                                </tr>
                                <tr>
                                    <td><b>Neto</b></td>
                                    <td><?php echo number_format($netop, 2, ",", ".") ?> &#36;</td>
                                    <td></td>


                                </tr>
                                <tr>
                                    <td><b>12% IVA</b></td>
                                    <td><?php echo number_format($totalivap, 2, ",", ".") ?> &#36;</td>
                                    <td></td>

                                </tr>
                                <tr class="itemImparTabla">
                                    <td><b>TOTAL en Facturas</b></td>
                                    <td></td>
                                    <td><b><?php echo number_format($totalp, 2, ",", ".") ?> &#36;</b></td>

                                </tr>

                                <?php
                                $totalpagado = 0;
                                $contadorp = 0;
                                $efectivopagos = 0;
                                while ($contadorp < mysql_num_rows($rs_pagos)) {
                                    if (mysql_result($rs_pagos, $contadorp, "nombre") == "EFECTIVO")
                                        $efectivopagos = mysql_result($rs_pagos, $contadorp, "suma");

                                    ?>
                                    <tr>
                                        <td><b><?php echo mysql_result($rs_pagos, $contadorp, "nombre") ?></b></td>
                                        <td><?php echo number_format(mysql_result($rs_pagos, $contadorp, "suma"), 2, ",", ".") ?>
                                            &#36;</td>
                                        <td></td>

                                    </tr>

                                    <?php
                                    $totalpagado = $totalpagado + mysql_result($rs_pagos, $contadorp, "suma");
                                    $contadorp++;
                                }

                                ?>

                                <tr class="itemImparTabla">
                                    <td><strong>TOTAL Pagado</strong></td>
                                    <td></td>
                                    <td><b><?php echo number_format($totalpagado, 2, ",", ".") ?> &#36;</b></td>
                                </tr>
                            </table>
                        </td>


                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr/>
                        </td>
                    </tr>
                    <tr class="itemImparTabla">
                        <td align="right">(total cobrado - total pagado) <b>TOTAL DIA= </b></td>
                        <td align="left">
                            &#36; <?php echo number_format(($totalcobrado - $totalpagado), 2, ",", ".") ?></td>
                    </tr>
                    <tr class="itemImparTabla">
                        <td align="right"><b>EFECTIVO= </b></td>
                        <td align="left">
                            &#36; <?php echo number_format(($efectivocobros - $efectivopagos), 2, ",", ".") ?></td>
                    </tr>
                </table>

                <hr/>
                <hr/>
                <table class="fuente8" width="90%" cellspacing=0 cellpadding=3 border=0>

                    <tr class="itemImparTabla">
                        <td align="left"><b>FACTURERO:</b></td>
                        <td align="left"><b> <?php echo $leyendafacturero?></b></td>

                    </tr>
                    <tr>
                        <td width="40%">
                            <table class="fuente8" width="70%" cellspacing=0 cellpadding=3 border=0>
                                <tr>
                                    <td><b>Total Ret. Iva</b></td>
                                    <td><?php echo number_format($totalretivacaja, 2, ",", ".") ?> &#36;</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Total Ret. Fuente</b></td>
                                    <td><?php echo number_format($totalretfuentecaja, 2, ",", ".") ?> &#36;</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Neto</b></td>
                                    <td><?php echo number_format($netocaja, 2, ",", ".") ?> &#36;</td>
                                    <td></td>


                                </tr>
                                <tr>
                                    <td><b>12% IVA</b></td>
                                    <td><?php echo number_format($totalivacaja, 2, ",", ".") ?> &#36;</td>
                                    <td></td>

                                </tr>
                                <tr class="itemImparTabla">
                                    <td><b>TOTAL en Facturas</b></td>
                                    <td></td>
                                    <td><b><?php echo number_format($totalcaja, 2, ",", ".") ?> &#36;</b></td>

                                </tr>

                                <?php
                                $totalcobradocaja = 0;
                                $contadorcaja = 0;
                                $efectivocobroscaja = 0;
                                while ($contadorcaja < mysql_num_rows($rs_cobroscaja)) {
                                    if (mysql_result($rs_cobroscaja, $contadorcaja, "nombre") == "EFECTIVO")
                                        $efectivocobroscaja = mysql_result($rs_cobroscaja, $contadorcaja, "suma");

                                    ?>
                                    <tr>
                                        <td><b><?php echo mysql_result($rs_cobroscaja, $contadorcaja, "nombre") ?></b>
                                        </td>
                                        <td><?php echo number_format(mysql_result($rs_cobroscaja, $contadorcaja, "suma"), 2, ",", ".") ?>
                                            &#36;</td>
                                        <td></td>

                                    </tr>

                                    <?php
                                    $totalcobradocaja = $totalcobradocaja + mysql_result($rs_cobroscaja, $contadorcaja, "suma");
                                    $contadorcaja++;
                                }

                                ?>

                                <tr class="itemImparTabla">
                                    <td><strong>TOTAL Cobrado</strong></td>
                                    <td></td>
                                    <td><b><?php echo number_format($totalcobradocaja, 2, ",", ".") ?> &#36;</b></td>
                                </tr>
                            </table>
                        </td>

                        <td width="60%">

                        </td>
                    </tr>

                    <tr>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">

                            <thead>
                            <tr>
                                <th ><span style="font-size: 10px">Id</span></th>
                                <th width="6%"><span style="font-size: 10px">Facturero</span></th>
                                <th width="6%"><span style="font-size: 10px">#Factura</span></th>
                                <th><span style="font-size: 10px">Cliente</span></th>
                                <th width="10%"><span style="font-size: 10px">Fecha</span></th>
                                <th width="10%"><span style="font-size: 10px">Estado</span></th>
                                <th width="10%"><span style="font-size: 10px">Total</span></th>
                                <th width="10%"><span style="font-size: 10px">Ret. IVA</span></th>
                                <th width="10%"><span style="font-size: 10px">Ret. Fuente</span></th>
                                <th width="10%"><span style="font-size: 10px">Pendiente</span></th>
                               
                            </tr>
                            </thead>
                            <tbody style="font-size: 10px; padding: 1px" align="center">
                            <tr>
                                <td colspan="3" class="dataTables_empty">Cargando Datos del Servidor</td>
                            </tr>
                            </tbody>
                        </table>
                    </tr>
                </table>


        </div>
        <div id="botonBusqueda">

        </div>
    </div>
</div>
</body>
</html>
