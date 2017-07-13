<?php
//include ("../conectar.php");
error_reporting(0);
?>
<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Listado de Retenciones</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
                
                <!-- INICIO archivos para DATA TABLES-->
                <style type="text/css" title="currentStyle">
			
			@import "../css/demo_table.css";
                        @import "TableTools-2.0.1/media/css/TableTools.css";
		</style>
		<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>

                <script type="text/javascript" charset="utf-8" src="TableTools-2.0.1/media/js/ZeroClipboard.js"></script>
                <script type="text/javascript" charset="utf-8" src="TableTools-2.0.1/media/js/TableTools.js"></script>
                <!-- FIN archivos para DATA TABLES-->


		<script language="javascript">
		
		function ver_retencion(idretencion) {
			parent.location.href="ver_retencion.php?idretencion=" + idretencion;
		}
		
		function modificar_retencion(idretencion) {
			parent.location.href="modificar_retencion.php?idretencion=" + idretencion;
		}
                
                function anular_retencion(idretencion){
                    if(confirm("Atencion va a proceder a la anulacion de una retencion. Desea continuar?")){
                        parent.location.href = "guardar_retencion.php?idretencion=" + idretencion + "&accion=baja";
                    }                        
                }
		
//		function eliminar_retencion(idretencion) {
//                    if (confirm("Atencion va a proceder a la anulacion de una retencion. Desea continuar?")) {
//			parent.location.href="eliminar_retencion.php?idretencion=" + idretencion;
//                    }
//		}


        $(document).ready(function() {

                oTable = $('#example').dataTable( {
                        
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "processing_listado_retenciones.php",
                        "sPaginationType": "full_numbers",

                        "aoColumns": [                                        
                                        { "asSorting": [ "desc", "asc" ] },
                                        null,
                                        null,
                                        null,                                        
                                        null,
                                        { "bSearchable": false, "bSortable": false }
                                        
                                    ],

                        

                       "sDom": 'T<"clear">lfrtip',
                        "oTableTools": {
                            "sSwfPath": "TableTools-2.0.1/media/swf/copy_cvs_xls_pdf.swf",
                            "aButtons": [

                                "xls",
                                {
                                        "sExtends": "pdf",
                                        "sPdfOrientation": "landscape",
                                        "sPdfMessage": " Agro "

                                },
                                /*{
                                        "sExtends": "print",
                                        "sButtonText": "Imprimir",
                                        "sInfo": "<h6>Vista Impresi&oacute;n</h6>Por favor use las funciones de impresi&oacute;n de su navegador para imprimir la tabla.<br/> Presione ESCAPE cuando haya finalizado.",
                                        "sMessage": "<H3>Inventario facturas</H3><br/>"

                                }*/
                            ]
                        },
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
                                        <th width="10%"><span style="font-size: 10px">Retencion</span></th>
                                        <th width="10%"><span style="font-size: 10px">Fecha</span></th>
                                        <th width="34%"><span style="font-size: 10px">Proveedor</span></th>
                                        <th width="10%"><span style="font-size: 10px">Factura</span></th>
                                        <th width="15%"><span style="font-size: 10px">Total Retencion</span></th>
                                        <th width="7%"><span style="font-size: 10px">&nbsp;</span></th>
                                        
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
