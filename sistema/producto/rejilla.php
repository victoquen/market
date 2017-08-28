<?php
//include ("../conectar.php");
//error_reporting(0);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
    <title>Inventario de Productos</title>
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


    <!-- INICIO archivos para DATA TABLES
    <style type="text/css" title="currentStyle">

@import "../css/demo_table.css";
            @import "TableTools-2.0.1/media/css/TableTools.css";
            @import "ColVis/css/ColVis.css";
</style>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>




    <script type="text/javascript" charset="utf-8" src="TableTools-2.0.1/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="TableTools-2.0.1/media/js/TableTools.js"></script>


    <script type="text/javascript" language="javascript" src="ColVis/js/ColVis.js"></script>

    <script src="jsEdit/jquery.jeditable.js" type="text/javascript"></script>
    <script src="jsEdit/jquery-ui.js" type="text/javascript"></script>
    <script src="jsEdit/jquery.validate.js" type="text/javascript"></script>
    <script src="jsEdit/jquery.dataTables.editable.js" type="text/javascript"></script>


     FIN archivos para DATA TABLES-->


    <script language="javascript">

        function ver_producto(idproducto) {
            parent.location.href = "ver_producto.php?idproducto=" + idproducto;
        }

        function modificar_producto(idproducto) {
            parent.location.href = "modificar_producto.php?idproducto=" + idproducto;
        }

        function eliminar_producto(idproducto) {
            if (confirm("Atencion va a proceder a la baja de un producto. Desea continuar?")) {
                parent.location.href = "eliminar_producto.php?idproducto=" + idproducto;
            }
        }

        var asInitVals = new Array();
        $(document).ready(function () {

            oTable = $('#example').dataTable({

                "processing": true,
                "serverSide": true,
                "sAjaxSource": "processing_inventario_productos.php",
                "sPaginationType": "full_numbers",
                dom: '<"top"lBf>rt<"bottom"ip><"clear">',
                buttons: [
                    'excel', 'pdf', 'print'
                ],

                "aoColumns": [
                    {"bVisible": true, "bSearchable": false, "bSortable": true},
                    {"asSorting": ["asc", "desc"]},
                    null,
                    null,
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
                    '<option value="25">25</option>' +
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

    <style type="text/css">
        .textarea {
            width: 100px;
            height: 50px;
            border: 1px dotted #000099;

        }
    </style>

</head>

<body>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">

            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">

                <thead>
                <tr>
                    <th><span style="font-size: 10px">Id</span></th>
                    <th><span style="font-size: 10px">Codigo</span></th>
                    <th><span style="font-size: 10px">Nombre</span></th>
                    <th><span style="font-size: 10px">Stock</span></th>
                    <th><span style="font-size: 10px">Costo</span> </th>
                    <th><span style="font-size: 10px">Pvp</span> </th>
                    <th><span style="font-size: 10px">Pvp2</span> </th>
                    <th><span style="font-size: 10px">Pvp3</span> </th>
                    <th><span style="font-size: 10px">Pvp4</span> </th>
                    <th><span style="font-size: 10px">Gasto</span></th>

                </tr>
                </thead>


                <tbody style="font-size: 10px; padding: 1px; " align="center">
                <tr>
                    <td colspan="7" class="dataTables_empty">Cargando Datos del Servidor</td>
                </tr>

                </tbody>




            </table>


        </div>
    </div>
</div>
</body>
</html>
