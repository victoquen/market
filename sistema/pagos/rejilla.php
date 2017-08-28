<?php
//include ("../conectar.php");
error_reporting(0);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>Listado de Facturas Compras</title>
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


    <script language="javascript">

        function ver_factura(idfactura) {
            parent.location.href = "ver_factura.php?idfactura=" + idfactura;
        }

        function ver_pagos(idfactura) {
            parent.location.href = "ver_pagos.php?idfactura=" + idfactura;
        }

        function retencion(idfactura) {
            parent.location.href = "../retenciones/comprobar_retencion.php?idfactura=" + idfactura;
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
                "sAjaxSource": "processing_listado_facturas.php",

                "aaSorting": [[ 0, "desc" ]],
                "aoColumns": [
                    {"bVisible": false, "asSorting": ["desc", "asc"]},
                    {"asSorting": ["desc", "asc"]},
                    null,
                    {"asSorting": ["desc", "asc"]},
                    null,
                    null,
                    {"bSearchable": false, "bSortable": false},
                    {"bSearchable": false, "bSortable": false},
                    {"bSearchable": false, "bSortable": false},
                    {"bSearchable": false, "bSortable": false}
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

            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">

                <thead>
                <tr>
                    <th><span style="font-size: 10px">Id</span></th>
                    <th width="6%"><span style="font-size: 10px">#Factura</span></th>
                    <th width="14%"><span style="font-size: 10px">Fecha</span></th>
                    <th width="20%"><span style="font-size: 10px">Proveedor</span></th>

                    <th width="14%"><span style="font-size: 10px">Estado</span></th>
                    <th width="14%"><span style="font-size: 10px">Total</span></th>
                    <th width="14%"><span style="font-size: 10px">Pendiente</span></th>
                    <th width="10%"><span style="font-size: 10px">Retenci&oacute;n</span></th>
                    <th width="5%"><span style="font-size: 10px">&nbsp;</span></th>
                    <th width="5%"><span style="font-size: 10px">&nbsp;</span></th>
                </tr>
                </thead>
                <tbody style="font-size: 10px; padding: 1px" align="center">
                <tr>
                    <td colspan="3" class="dataTables_empty">Cargando Datos del Servidor</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
