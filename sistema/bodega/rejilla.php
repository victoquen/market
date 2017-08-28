<?php
//include ("../conectar.php");
error_reporting(0);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>Listado BODEGAS</title>
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

        function ver_bodega(idbodega) {
            parent.location.href = "ver_bodega.php?idbodega=" + idbodega;
        }

        function modificar_bodega(idbodega) {

            parent.location.href = "modificar_bodega.php?idbodega=" + idbodega;
        }

        function eliminar_bodega(idbodega) {
            if (confirm("Atencion va a proceder a la baja de una bodega. Desea continuar?")) {
                parent.location.href = "eliminar_bodega.php?idbodega=" + idbodega;
            }
        }


        $(document).ready(function () {

            oTable = $('#example').dataTable({

                "processing": true,
                "serverSide": true,
                "sPaginationType": "full_numbers",
                dom: '<"top"lBf>rt<"bottom"ip><"clear">',
                buttons: [
                    'excel', 'pdf', 'print'
                ],
                "sAjaxSource": "processing_listado_bodega.php",


                "aoColumns": [
                    null,
                    null,

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
                    <th><span style="font-size: 10px">Nombre</span></th>
                    <th><span style="font-size: 10px">Direcci&oacute;n</span></th>
                    <th><span style="font-size: 10px">&nbsp;</span></th>
                    <th><span style="font-size: 10px">&nbsp;</span></th>
                    <th><span style="font-size: 10px">&nbsp;</span></th>
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
