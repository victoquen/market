<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
                <title>Listado de Clientes</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">

                <!-- INICIO archivos para DATA TABLES-->
                <style type="text/css" title="currentStyle">

			@import "../css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="js/jquery.js"></script>

		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
                <!-- FIN archivos para DATA TABLES-->


		<script language="javascript">
        $(document).ready(function() {

                oTable = $('#example').dataTable( {

                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "processing_listado_clientes.php",
                        "sPaginationType": "full_numbers",

                       /*"sDom": 'T<"clear">lfrtip',
                        "oTableTools": {
                            "sSwfPath": "TableTools-2.0.1/media/swf/copy_cvs_xls_pdf.swf",
                            "aButtons": [

                                "xls",
                                {
                                        "sExtends": "pdf",
                                        "sPdfOrientation": "landscape",
                                        "sPdfMessage": " Agro "

                                },
                                {
                                        "sExtends": "print",
                                        "sButtonText": "Imprimir",
                                        "sInfo": "<h6>Vista Impresi&oacute;n</h6>Por favor use las funciones de impresi&oacute;n de su navegador para imprimir la tabla.<br/> Presione ESCAPE cuando haya finalizado.",
                                        "sMessage": "<H3>Inventario clientes</H3><br/>"

                                }
                            ]
                        },*/
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

function pon_prefijo(pref,nombre,ci_ruc,tipo) {
	parent.opener.document.formulario.codcliente.value=pref;
	parent.opener.document.formulario.nombre.value=nombre;
	parent.opener.document.formulario.ci_ruc.value=ci_ruc;
        if(tipo=='CF')
        {
            parent.opener.document.formulario.tipo_cliente.value="CLIENTE FINAL";           
        }
        else
        {
            parent.opener.document.formulario.tipo_cliente.value="DISTRIBUIDOR";            
        }     
	parent.window.close();
}

</script>

<body>
<!--<div id="tituloForm2" class="header">-->
<div id="pagina">
<div id="zonaContenido">
<form id="form1" name="form1">
      <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">

                                <thead>
                                    <tr>
                                        <th width="70%"><span style="font-size: 12px">Nombre</span></th>
                                        <th width="20%"><span style="font-size: 12px">Ci/Ruc</span></th>
                                        
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
