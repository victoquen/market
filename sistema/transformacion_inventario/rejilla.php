<?php
//include ("../conectar.php");
error_reporting(0);
?>
<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Inventario de Productos</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
                
                <!-- INICIO archivos para DATA TABLES-->
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


                

                <!-- FIN archivos para DATA TABLES-->


		<script language="javascript">
		
		function ver_producto(idproducto) {
			parent.location.href="ver_producto.php?idproducto=" + idproducto;
		}
		
		function modificar_producto(idproducto) {
			parent.location.href="modificar_producto.php?idproducto=" + idproducto;
		}
		
		function eliminar_producto(idproducto) {
                    if (confirm("Atencion va a proceder a la baja de un producto. Desea continuar?")) {
			parent.location.href="eliminar_producto.php?idproducto=" + idproducto;
                    }
		}

                var asInitVals = new Array();
        $(document).ready(function() {

                oTable = $('#example').dataTable( {

                        
                        "sDom": 'TC<"clear">lfrtip',

                        "oColVis": {
                                    "buttonText": "Ocultar Columnas"

                        },



                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "processing_inventario_productos_transformados.php",
                        "sPaginationType": "full_numbers",


                        

                      
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
                                        "sMessage": "<H3>Inventario Productos</H3><br/>"

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
                                       
                                        <th width="5%"><span style="font-size: 10px">Codigo</span></th>
                                     
                                        <th width="30%"><span style="font-size: 10px">Nombre</span></th>
                                        <th width="5%"><span style="font-size: 10px">Stock</span></th>

                                        <th width="5%"><span style="font-size: 10px">Consig.</span></th>

                                        <th width="5%"><span style="font-size: 10px">Costo</span></th>
                                        <th width="5%"><span style="font-size: 10px">Pvp</span></th>
                                        <th ><span style="font-size: 10px">Provee.</span></th>
                                        <th ><span style="font-size: 10px">Grupo</span></th>
                                        <th ><span style="font-size: 10px">Subgrupo</span></th>
                                        <th ><span style="font-size: 10px">Compos.</span></th>
                                        <th ><span style="font-size: 10px">Aplicac.</span></th>
                                        
                                    </tr>
                                </thead>

                                
                                
                                <tbody style="font-size: 10px; padding: 1px" align="center">
                                            <tr>
                                                    <td colspan="3" class="dataTables_empty">Cargando Datos del Servidor</td>
                                            </tr>

                                </tbody>


                               <tfoot>
                                    <tr>
                                        <th width="5%"><input type="text" name="codigo" value="codigo" class="search_init" /></th>
                                        <th width="30%"><input type="text" name="codigo" value="nombre" class="search_init" /></th>
                                        <th width="5%"><input type="text" name="codigo" value="stock" class="search_init" /></th>
                                        <th width="5%"><input type="text" name="codigo" value="costo" class="search_init" /></th>
                                        <th width="5%"><input type="text" name="codigo" value="pvp" class="search_init" /></th>
                                        <th ><input type="text" name="codigo" value="provee" class="search_init" /></th>
                                        <th ><input type="text" name="codigo" value="grupo" class="search_init" /></th>
                                        <th ><input type="text" name="codigo" value="subgrupo" class="search_init" /></th>
                                        <th ><input type="text" name="codigo" value="compos" class="search_init" /></th>
                                        <th ><input type="text" name="codigo" value="aplica" class="search_init" /></th>


                                    </tr>
                                </tfoot>

                            </table>





			</div>
		  </div>			
		</div>
	</body>
</html>
