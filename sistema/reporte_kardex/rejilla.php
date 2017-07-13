<?php

include ("../js/fechas.php");
include_once '../conexion/conexion.php';
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);


$idproducto=$_POST["idarticulo"];
$fechainicio=$_POST["fechainicio"];
$fechafin=$_POST["fechafin"];
if ($fechafin<>"") { $fechafin=explota($fechafin); }
if ($fechainicio<>"")
{ 
    $fechainicio=explota($fechainicio);
}
else
{
    $fechainicio=$fechafin;
}



?>
<html>
	<head>
		<title>Clientes</title>
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

		$(document).ready(function() {

                oTable = $('#example').dataTable( {
                        "bFilter": false,
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "processing_kardex.php?fecha_inicio=<?php echo $fechainicio?>&fecha_fin=<?php echo $fechafin?>&idproducto=<?php echo $idproducto?>",
                        "sPaginationType": "full_numbers",
                        
                        "aoColumns": [
                                        { "bSearchable": false, "bSortable": false },                                   
                                        { "bSearchable": false, "bSortable": false },
                                        { "bSearchable": false, "bSortable": false },
                                        { "bSearchable": false, "bSortable": false },
                                        { "bSearchable": false, "bSortable": false },
                                        { "bSearchable": false, "bSortable": false },                                   
                                        { "bSearchable": false, "bSortable": false },
                                        { "bSearchable": false, "bSortable": false },
                                        { "bSearchable": false, "bSortable": false },
                                        { "bSearchable": false, "bSortable": false },
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
                                        <?php if($fechainicio != $fechafin) {?>
                                        <th colspan="11"><span style="font-size: 12px">PERIODO DESDE: <?php echo implota($fechainicio)?> ----- HASTA: <?php echo implota($fechafin)?></span></th>
                                                                                                    
                                        <?php } else {?>
                                        <th colspan="7"><span style="font-size: 12px">FECHA: <?php echo implota($fechafin)?></span></th>
                                        <th colspan="4"><span style="font-size: 12px">TOTAL RETENCIONES: $ <?php echo $total_retenciones?></span></th>
                                        <?php }?>
                                    </tr>
                                    
                                    <tr>
                                        <th colspan="2">&nbsp;</th>
                                        <th colspan="3" align="center"><span style="font-size: 10px">ENTRADAS</span></th>
                                        <th colspan="3" align="center"><span style="font-size: 10px">SALIDAS</span></th>
                                        <th colspan="3" align="center"><span style="font-size: 10px">SALDOS</span></th>
                                    </tr>
                                    <tr>
                                        
                                        <th width="7%"><span style="font-size: 10px">Fecha</span></th>
                                        <th ><span style="font-size: 10px">Detalle</span></th>
                                        
                                        
                                        <th width="5%" align="center"><span style="font-size: 10px">Cant.</span></th>
                                        <th width="10%" align="center"><span style="font-size: 10px">P.U.</span></th>
                                        <th width="10%" align="center"><span style="font-size: 10px">P.T.</span></th>
                                                   
                                        
                                        <th width="5%" align="center"><span style="font-size: 10px">Cant.</span></th>
                                        <th width="10%" align="center"><span style="font-size: 10px">P.U.</span></th>
                                        <th width="10%" align="center"><span style="font-size: 10px">P.T.</span></th>


                                        <th width="5%" align="center"><span style="font-size: 10px">Cant.</span></th>
                                        <th width="10%" align="center"><span style="font-size: 10px">V.T</span></th>
                                        <th width="10%" align="center"><span style="font-size: 10px">V.Prom</span></th>

                                                                             
                                    </tr>
                                </thead>
                                <tbody style="font-size: 10px; padding: 1px" align="center">
                                            <tr>
                                                    <td colspan="11" class="dataTables_empty">Cargando Datos del Servidor</td>
                                            </tr>
                                </tbody>
                                
                            </table>
                    </div>
                </div>
            </div>

	</body>
</html>
