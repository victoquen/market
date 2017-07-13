<?php
//include ("../conectar.php");
error_reporting(0);
?>
<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
                <title>Listado de Categor&iacute;as</title>
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
		
		function ver_grupo(idgrupo) {
			parent.location.href="ver_grupo.php?idgrupo=" + idgrupo;
		}
		
		function modificar_grupo(idgrupo) {
			parent.location.href="modificar_grupo.php?idgrupo=" + idgrupo;
		}
		
		function eliminar_grupo(idgrupo) {
			parent.location.href="eliminar_grupo.php?idgrupo=" + idgrupo;
		}

                var asInitVals = new Array();
        $(document).ready(function() {

                var oTable = $('#example').dataTable( {
                        
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "processing_listado_grupos.php",
                        "sPaginationType": "full_numbers",


                       

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
                                        "sMessage": "<H3>Inventario grupos</H3><br/>"

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


                $("tfoot input").keyup( function () {
                        /* Filter on the column (the index) of this element */
                        oTable.fnFilter( this.value, $("tfoot input").index(this) );
                } );



                /*
                 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in
                 * the footer
                 */
                $("tfoot input").each( function (i) {
                        asInitVals[i] = this.value;
                } );

                $("tfoot input").focus( function () {
                        if ( this.className == "search_init" )
                        {
                                this.className = "";
                                this.value = "";
                        }
                } );

                $("tfoot input").blur( function (i) {
                        if ( this.value == "" )
                        {
                                this.className = "search_init";
                                this.value = asInitVals[$("tfoot input").index(this)];
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
                                        <th><span style="font-size: 10px">Codigo</span></th>
                                        <th ><span style="font-size: 10px">Nombre</span></th>
<!--                                        <th><span style="font-size: 10px">&nbsp;</span></th>
                                        <th><span style="font-size: 10px">&nbsp;</span></th>
                                        <th><span style="font-size: 10px">&nbsp;</span></th>-->
                                    </tr>
                                </thead>

                                


                                <tbody style="font-size: 10px; padding: 1px" align="center">
                                            <tr>
                                                    <td colspan="3" class="dataTables_empty">Cargando Datos del Servidor</td>
                                            </tr>

                                    </tbody>


                                 <tfoot>
                                    <tr>

                                        <th><input type="text" name="codigo" value="Search codigos" class="search_init" /></th>
                                        <th><input type="text" name="nombre" value="Search nombres" class="search_init" /></th>
<!--                                        <th><span style="font-size: 10px">&nbsp;</span></th>
                                        <th><span style="font-size: 10px">&nbsp;</span></th>
                                        <th><span style="font-size: 10px">&nbsp;</span></th>-->
                                    </tr>
                                </tfoot>

                            </table>





			</div>
		  </div>			
		</div>
	</body>
</html>
