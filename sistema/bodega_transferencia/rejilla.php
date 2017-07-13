<?php


error_reporting(0);
?>
<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Listado de Ventas</title>
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
		
		function ver_transferencia(idtransferencia) {
			parent.location.href="ver_transferencia.php?idtransferencia=" + idtransferencia;
		}
		
		function modificar_factura(idtransferencia) {
			parent.location.href="modificar_facturacompra.php?idtransferencia=" + idtransferencia;
		}
		
		function eliminar_factura(idtransferencia) {
                    if (confirm("Atencion va a proceder a la anulacion de una factura de compra. Desea continuar?")) {
			parent.location.href="eliminar_factura.php?idtransferencia=" + idtransferencia;
                    }
		}
                function retencion(idtransferencia)
                {                    
                    parent.location.href="../retenciones/comprobar_retencion.php?idtransferencia="+idtransferencia;
                }


        $(document).ready(function() {

                oTable = $('#example').dataTable( {
                        
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "processing_listado_transferencias.php",
                        "sPaginationType": "full_numbers",


                        "aoColumns": [
                                        { "asSorting": [ "desc", "asc" ] },
                                        null,
                                        null,
  
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
                                        <th width="14%"><span style="font-size: 10px">Id</span></th>
                                        <th width="10%"><span style="font-size: 10px">Fecha</span></th>                                        
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
