<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
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


		<script language="javascript">

		function ver_producto(idproducto) {
			parent.location.href="ver_producto.php?idproducto=" + idproducto;
		}

		function modificar_producto(idproducto) {
			parent.location.href="modificar_producto.php?idproducto=" + idproducto;
		}

		function eliminar_producto(idproducto) {
			parent.location.href="eliminar_producto.php?idproducto=" + idproducto;
		}


        $(document).ready(function() {

                oTable = $('#example').dataTable( {

                    "processing": true,
                    "serverSide": true,
                    "sPaginationType": "full_numbers",
                   
                   
                        "sAjaxSource": "processing_inventario_productos.php",



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
<script language="javascript">

function pon_prefijo(codarticulo,nombre,idarticulo,iva) {
	parent.opener.document.formulario_lineas.codarticulo.value=codarticulo;
	parent.opener.document.formulario_lineas.descripcion.value=nombre;
	parent.opener.document.formulario_lineas.idarticulo.value=idarticulo;
        if(iva==1)
        {
            parent.opener.document.formulario_lineas.ivaporc.value=12;
        }
        else
        {
             parent.opener.document.formulario_lineas.ivaporc.value=0;
        }
	parent.opener.actualizar_importe();
	parent.window.close();
}

</script>

<body>
<div id="pagina">
<div id="zonaContenido">
<form id="form1" name="form1">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">

                                <thead>
                                    <tr>
                                        <th width="70%"><span style="font-size: 12px">Nombre</span></th>
                                        <th width="10%"><span style="font-size: 12px">Stock</span></th>
                                        <th width="10%"><span style="font-size: 12px">Consig.</span></th>
                                        <th width="10%"><span style="font-size: 12px">Pvp</span></th>
<!--                                                                          -->
                                        <th width="10%"><span style="font-size: 12px">&nbsp;</span></th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 10px; padding: 1px" align="center">
                                            <tr>
                                                    <td colspan="3" class="dataTables_empty">Cargando Datos del Servidor</td>
                                            </tr>

                                    </tbody>

                            </table>

</form>
</div>
</div>
</body>
</html>
