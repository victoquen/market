<?php 

include ("../js/fechas.php");
include_once '../conexion/conexion.php';
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);


$tipoCliente=$_POST["tipoCliente"];
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


$query_totfact="SELECT SUM(f.totalfactura) as total 
		FROM   facturas f INNER JOIN cliente cl ON f.id_cliente=cl.id_cliente
                WHERE (f.anulado = 0) AND (f.fecha BETWEEN '$fechainicio' AND '$fechafin')AND (cl.codigo_tipocliente='$tipoCliente') AND (f.estado=0)  ";
$rs_totfact=mysql_query($query_totfact);
$total_facturas=mysql_result($rs_totfact,0,"total");


?>
<html>
	<head>
		<title>Clientes</title>
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

                function ver_cobros(idfactura) {
			parent.location.href="../cobros/ver_cobros.php?idfactura=" + idfactura;
		}

		$(document).ready(function() {

                oTable = $('#example').dataTable( {

                    "processing": true,
                    "serverSide": true,
                    "sPaginationType": "full_numbers",
                    dom: '<"top"lBf>rt<"bottom"ip><"clear">',
                    buttons: [
                        'excel', 'pdf', 'print'
                    ],
                        "sAjaxSource": "processing_historialclienteventas.php?fecha_inicio=<?php  echo $fechainicio?>&fecha_fin=<?php  echo $fechafin?>&tipoCliente=<?php  echo $tipoCliente?>",

                        "aoColumns": [
                                        { "asSorting": [ "desc", "asc" ] },
                                        null,
                                        null,
                                        null,
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
                            '<option value="20">20</option>'+
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
                                        <th colspan="3"><span style="font-size: 12px">PERIODO DESDE: <?php  echo implota($fechainicio)?> ----- HASTA: <?php  echo implota($fechafin)?></span></th>
                                        <th colspan="7"><span style="font-size: 12px">TOTAL FACTURAS: $ <?php  echo $total_facturas?></span></th>
                                        <?php  } else {?>
                                        <th colspan="3"><span style="font-size: 12px">FECHA: <?php  echo implota($fechafin)?></span></th>
                                        <th colspan="7"><span style="font-size: 12px">TOTAL $ FACTURAS: $ <?php  echo $total_facturas?></span></th>
                                        <?php  }?>
                                    </tr>
                                    <tr>
                                        
                                        <th width="10%"><span style="font-size: 10px">Fecha</span></th>
                                        <th width="15%"><span style="font-size: 10px">Lugar</span></th>
                                        <th width="25%"><span style="font-size: 10px">Cliente</span></th>
                                        <th width="7%"><span style="font-size: 10px">#Factura</span></th>                                                                                                                       
                                        <th width="7%"><span style="font-size: 10px">FechaVenc</span></th>
                                        <th width="7%"><span style="font-size: 10px">Total</span></th> 
                                        <th width="7%"><span style="font-size: 10px">Ret. Iva</span></th> 
                                        <th width="7%"><span style="font-size: 10px">Ret. Fuente</span></th> 
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
