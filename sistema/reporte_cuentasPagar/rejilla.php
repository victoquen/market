<?php

include ("../js/fechas.php");
include_once '../conexion/conexion.php';
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);


$fechainicio=$_POST["fechainicio"];
$fechafin=$_POST["fechafin"];


//$fechainicio="01/01/2012";
//$fechafin="19/08/2013";

if ($fechafin<>"") { 
    $fechafin=explota($fechafin); 
    
}
if ($fechainicio<>"")
{ 
    $fechainicio=explota($fechainicio);
}
else
{
    $fechainicio=$fechafin;
}



$where.=" ORDER BY fecha DESC";
$query_busqueda="SELECT count(*) as filas FROM librodiario WHERE ".$where;

$rs_busqueda=mysql_query($query_busqueda);
$filas=mysql_result($rs_busqueda,0,"filas");


$query_totfact="SELECT SUM(f.totalfactura) as total 
		FROM   facturasp f INNER JOIN proveedor p ON f.id_proveedor=p.id_proveedor
                WHERE (f.anulado = 0) AND (f.fecha BETWEEN '$fechainicio' AND '$fechafin') AND (f.estado=0)  ";
$rs_totfact=mysql_query($query_totfact);
$total_facturas=mysql_result($rs_totfact,0,"total");


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

                function ver_pagos(idfactura) {
			parent.location.href="../pagos/ver_pagos.php?idfactura=" + idfactura;
		}

		$(document).ready(function() {

                oTable = $('#example').dataTable( {
                        "bFilter": false,
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "processing_cuentasCobrar.php?fecha_inicio=<?echo $fechainicio?>&fecha_fin=<?echo $fechafin?>",
                        "sPaginationType": "full_numbers",
                        "aoColumns": [
                                        { "asSorting": [ "desc", "asc" ] },
                                        null,
                                        null,
                                        null,
                                        null,
                                        null,
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
                                        <th colspan="3"><span style="font-size: 12px">PERIODO DESDE: <?php echo implota($fechainicio)?> ----- HASTA: <?php echo implota($fechafin)?></span></th>
                                        <th colspan="6"><span style="font-size: 12px">TOTAL FACTURAS: $ <?php echo $total_facturas?></span></th>
                                        <?php } else {?>
                                        <th colspan="3"><span style="font-size: 12px">FECHA: <?php echo implota($fechafin)?></span></th>
                                        <th colspan="6"><span style="font-size: 12px">TOTAL $ FACTURAS: $ <?php echo $total_facturas?></span></th>
                                        <?php }?>
                                    </tr>
                                    <tr>
                                        
                                        <th width="10%"><span style="font-size: 10px">Fecha</span></th>
                                        <th width="15%"><span style="font-size: 10px">Lugar</span></th>
                                        <th ><span style="font-size: 10px">Proveedor</span></th>
                                        <th width="7%"><span style="font-size: 10px">#Factura</span></th>                                                                                                                       
                                        <th width="7%"><span style="font-size: 10px">FechaVenc</span></th>
                                        <th width="7%"><span style="font-size: 10px">Total</span></th> 
                                        <th width="7%"><span style="font-size: 10px">Retenci&oacute;n</span></th> 
                                        <th width="7%"><span style="font-size: 10px">Pendiente</span></th> 
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
