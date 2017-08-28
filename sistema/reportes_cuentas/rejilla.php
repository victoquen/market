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

$cbocuenta=$_POST["cbocuenta"];

$querycuenta="SELECT nombre FROM cuenta WHERE id_cuenta=$cbocuenta";
$rNombrecuenta=mysql_query($querycuenta,$conn);
$cuenta=mysql_result($rNombrecuenta, 0, "nombre");


$where.=" ORDER BY fecha DESC";
$query_busqueda="SELECT count(*) as filas FROM librodiario WHERE ".$where;

$rs_busqueda=mysql_query($query_busqueda);
$filas=mysql_result($rs_busqueda,0,"filas");

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

		$(document).ready(function() {

                oTable = $('#example').dataTable( {
                        "bFilter": false,
                    "processing": true,
                    "serverSide": true,
                    "sPaginationType": "full_numbers",
                    dom: '<"top"lBf>rt<"bottom"ip><"clear">',
                    buttons: [
                        'excel', 'pdf', 'print'
                    ],
                        "sAjaxSource": "processing_librodiario.php?fecha_inicio=<?php echo $fechainicio?>&fecha_fin=<?php echo $fechafin?>&cuenta=<?php  echo $cbocuenta?>",



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
                                        <th colspan="8"><span style="font-size: 12px">CUENTA: <?php  echo $cuenta?> ---------- PERIODO DESDE: <?php  echo implota($fechainicio)?> ---------- HASTA: <?php  echo implota($fechafin)?></span></th>
                                        <?php  } else {?>
                                        <th colspan="8"><span style="font-size: 12px">CUENTA: <?php  echo $cuenta?> ---------- FECHA: <?php  echo implota($fechafin)?></span></th>
                                        <?php  }?>
                                    </tr>
                                    <tr>
                                        
                                        <th width="10%"><span style="font-size: 10px">Fecha</span></th>
                                        <th width="10%"><span style="font-size: 10px">C/V</span></th>
                                        <th width="6%"><span style="font-size: 10px">#Factura</span></th>
                                        <th width="30%"><span style="font-size: 10px">Nombre</span></th>
                                        <th width="10%"><span style="font-size: 10px">Forma Pago</span></th>
                                        <th width="25%"><span style="font-size: 10px">Entidad Bancaria</span></th>
                                        <th width="5%"><span style="font-size: 10px">Importe</span></th>
                                        <th width="5%"><span style="font-size: 10px">Cuenta</span></th>
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
