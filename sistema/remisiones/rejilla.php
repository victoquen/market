<?php
//include ("../conectar.php");
error_reporting(0);
?>
<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Listado de remisiones</title>
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
		
		function ver_remision(idremision) {
			parent.location.href="ver_remision.php?idremision=" + idremision;
		}
		
		function modificar_remision(idremision) {
			parent.location.href="modificar_remision.php?idremision=" + idremision;
		}
		
//		function eliminar_remision(idremision) {
//                    if (confirm("Atencion va a proceder a la anulacion de una remision. Desea continuar?")) {
//			parent.location.href="eliminar_remision.php?idremision=" + idremision;
//                    }
//		}


        $(document).ready(function() {

                oTable = $('#example').dataTable( {

                    "processing": true,
                    "serverSide": true,
                    "sPaginationType": "full_numbers",
                    dom: '<"top"lBf>rt<"bottom"ip><"clear">',
                    buttons: [
                        'excel', 'pdf', 'print'
                    ],
                        "sAjaxSource": "processing_listado_remisiones.php",


                        "aoColumns": [                                        
                                        { "asSorting": [ "desc", "asc" ] },
                                        null,
                                        null,
                                        null,                                        
                                        null,
                                        { "bSearchable": false, "bSortable": false },
                                        { "bSearchable": false, "bSortable": false }
                                    ],

                        


                        "oLanguage": {
                            "oPaginate": {
                            "sPrevious": "Anterior",
                            "sNext": "Siguiente",
                            "sLast": "Ultima",
                            "sFirst": "Primera"
                            },

                            "sLengthMenu": 'Mostrar <select>'+
                            '<option value="5">5</option>'+
                            '<option value="10">10</option>'+
                            '<option value="15">15</option>'+
                            '<option value="20">25</option>'+
                            '<option value="-1">Todos</option>'+
                            '</select> registros',

                            "sInfo": "Mostrando _START_ a _END_ (de _TOTAL_ resultados)",

                            "sInfoFiltered": " - filtrados de _MAX_ registros",

                            "sInfoEmpty": "No hay resultados de b\xfasqueda",

                            "sZeroRecords": "No hay registros a mostrar",

                            "sProcessing": "Espere, por favor...",

                            "sSearch": "Buscar:"

                        }


                } );

        } );
		</script>
	</head>

	<body>	
		<div id="pagina">
			<div id="zonaContenido">
			<div align="center">

                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">

                                <thead>
                                    <tr>
                                        <th width="10%"><span style="font-size: 10px">remision</span></th>                                        
                                        <th width="35%"><span style="font-size: 10px">Cliente</span></th>
                                        <th width="10%"><span style="font-size: 10px">Factura</span></th>
                                        <th width="10%"><span style="font-size: 10px">Fecha Inicio</span></th>
                                        <th width="15%"><span style="font-size: 10px">Fecha Entrega</span></th>
                                        <th width="10%"><span style="font-size: 10px">&nbsp;</span></th>
                                        <th width="10%"><span style="font-size: 10px">&nbsp;</span></th>
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
