<?php 

include ("../js/fechas.php");
include_once '../conexion/conexion.php';
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);



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



$where.=" ORDER BY fecha DESC";
$query_busqueda="SELECT count(*) as filas FROM librodiario WHERE ".$where;

$rs_busqueda=mysql_query($query_busqueda);
$filas=mysql_result($rs_busqueda,0,"filas");


$query_totreten="SELECT SUM(a.iva0) as total_iva0, SUM(a.iva12) as total_iva12, SUM(a.iva) as total_iva, SUM(a.totalfactura) as total_factura
		FROM   facturasp a
                WHERE (a.anulado = 0) AND (a.fecha BETWEEN '$fechainicio' AND '$fechafin') ";
$rs_totreten=mysql_query($query_totreten);
$total_iva0=mysql_result($rs_totreten,0,"total_iva0");
$total_iva12=mysql_result($rs_totreten,0,"total_iva12");
$total_iva=mysql_result($rs_totreten,0,"total_iva");
$total_factura=mysql_result($rs_totreten,0,"total_factura");

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
                        "sAjaxSource": "processing_ventas_iva0_12.php?fecha_inicio=<?php echo $fechainicio?>&fecha_fin=<?php echo $fechafin?>",
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
                                        <?php  if($fechainicio != $fechafin) {?>
                                        <th colspan="11"><span style="font-size: 12px">PERIODO DESDE: <?php  echo implota($fechainicio)?> ----- HASTA: <?php  echo implota($fechafin)?></span></th>
                                                                                                    
                                        <?php  } else {?>
                                        <th colspan="7"><span style="font-size: 12px">FECHA: <?php  echo implota($fechafin)?></span></th>
                                        <th colspan="4"><span style="font-size: 12px">TOTAL RETENCIONES: $ <?php  echo $total_retenciones?></span></th>
                                        <?php  }?>
                                    </tr>
                                    <tr>
                                        
                                        <th width="7%"><span style="font-size: 10px">Fecha</span></th>
                                        <th width="7%"><span style="font-size: 10px">RUC</span></th>
                                        <th ><span style="font-size: 10px">Proveedor</span></th>
                                        <th width="7%"><span style="font-size: 10px">Autoriz</span></th>
                                        <th width="4%"><span style="font-size: 10px">Serie1</span></th>
                                        <th width="4%"><span style="font-size: 10px">Serie2</span></th>
                                        <th width="7%"><span style="font-size: 10px">#Factura</span></th>                                                                                                                       
                                        <th width="9%"><span style="font-size: 10px">Iva 0%</span></th>
                                        <th width="9%"><span style="font-size: 10px">Iva 12%</span></th>
                                        <th width="9%"><span style="font-size: 10px">IVA</span></th>
                                       <th width="9%"><span style="font-size: 10px">$Factura</span></th>                                        
                                    </tr>
                                </thead>
                                <tbody style="font-size: 10px; padding: 1px" align="center">
                                            <tr>
                                                    <td colspan="3" class="dataTables_empty">Cargando Datos del Servidor</td>
                                            </tr>
                                </tbody>
                                <tfoot>
                                    <tr >
                                        <td colspan="4" align="right">
                                            <b><span style="font-size: 10px">TOTALES ($)</span></b>
                                        </td>
                                        <td align="center">
                                            <b><span style="font-size: 10px;"><?php  echo $total_iva0?></span></b>
                                        </td>
                                        <td align="center">
                                           <b> <span style="font-size: 10px;"><?php  echo $total_iva12?></span></b>
                                        </td>
                                        <td align="center">
                                            <b><span style="font-size: 10px;"><?php  echo $total_iva?></span></b>
                                        </td>
                                        <td align="center">
                                            <b><span style="font-size: 10px"><?php  echo $total_factura?></span></b>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                    </div>
                </div>
            </div>

	</body>
</html>
