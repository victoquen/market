<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache');


//$op = $_POST["op"];

$text_search = $_POST["text_search"];


include("../conexion/conexion.php");
error_reporting(0);
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();
$sel_iva = "select porcentaje FROM iva where activo=1 AND borrado=0";
$rs_iva = mysql_query($sel_iva, $conn);
$ivaporcetaje = mysql_result($rs_iva, 0, "porcentaje");

$sel_tar = "select porcentaje FROM porcentaje_tarjetacredito where  borrado=0 limit 1";
$rs_tar = mysql_query($sel_tar, $conn);
$prorrateo_porcentaje = mysql_result($rs_tar, 0, "porcentaje");

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
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
            parent.location.href = "ver_producto.php?idproducto=" + idproducto;
        }

        function modificar_producto(idproducto) {
            parent.location.href = "modificar_producto.php?idproducto=" + idproducto;
        }

        function eliminar_producto(idproducto) {
            parent.location.href = "eliminar_producto.php?idproducto=" + idproducto;
        }


        $(document).ready(function () {

            var oTable = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "sPaginationType": "full_numbers",

                "sAjaxSource": "processing_inventario_productos.php",

                "aoColumns": [
                    {"bVisible": false, "aSorting": ["desc", "asc"]},
                    null,
                    null,
                    null,
                    {"bSearchable": false, "bSortable": false}
                ],

                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": "Anterior",
                        "sNext": "Siguiente",
                        "sLast": "Ultima",
                        "sFirst": "Primera"
                    },
                    "sLengthMenu": 'Mostrar <select>' +
                    '<option value="5">5</option>' +
                    '<option value="10">10</option>' +
                    '</select> registros',
                    "sInfo": "Mostrando _START_ a _END_ (de _TOTAL_ resultados)",
                    "sInfoFiltered": " - filtrados de _MAX_ registros",
                    "sInfoEmpty": "No hay resultados de b\xfasqueda",
                    "sZeroRecords": "No hay registros a mostrar",
                    "sProcessing": "Espere, por favor...",
                    "sSearch": "Buscar:"

                }


            });
            var txtSearch = parent.opener.document.getElementById("dproducto").value;

            $('div.dataTables_filter input').value = txtSearch;
            oTable.search(txtSearch).draw();
            $('div.dataTables_filter input').focus();


        });
    </script>
</head>
<script language="javascript">


    function removeOptions(obj) {
        while (obj.options.length) {
            obj.remove(0);
        }
    }


    function pon_prefijo(codarticulo, nombre, precio, idarticulo, costo, stock, iva, transformacion, precio_con_iva, series, pvp2, pvp3, pvp4) {
        var origen = parent.opener.document.getElementById("accion").value;
        var codtmp = localStorage.getItem('codtmp');
        var id_bodega = localStorage.getItem('id_bodega');
        var password = null;
        var clave = "a";
        var arrayJSindice = null;
        var arrayJSnombre = null;
        var porcentaje_iva = <?php echo $ivaporcetaje;?>;

        var imp_aux = 0;

        var op_formapago = localStorage.getItem('forma_pago');
        var prorrateo_porcentaje = 0;
        if (op_formapago == 5) {
            prorrateo_porcentaje = <?php echo $prorrateo_porcentaje?>
        }

        parent.opener.document.getElementById("id_bodega").value = id_bodega;


        parent.opener.document.getElementById("dproducto").value = nombre;
        parent.opener.document.getElementById("cantidad").value = 1;



        precio_prorrateado = precio_alone * (1 + prorrateo_porcentaje / 100);
        original = parseFloat(precio_prorrateado);
        result = Math.round(original * 100) / 100;



        var precio_prorrateado1 = precio * (1 + prorrateo_porcentaje / 100);
        var original1 = parseFloat(precio_prorrateado1);
        var result1 = Math.round(original1 * 100) / 100;
        parent.opener.document.getElementById("pvpa").value =  result1.toFixed(2);
        var precio_prorrateado2 = pvp2 * (1 + prorrateo_porcentaje / 100);
        var original2 = parseFloat(precio_prorrateado2);
        var result2 = Math.round(original2 * 100) / 100;
        parent.opener.document.getElementById("pvpb").value =  result2.toFixed(2);
        var precio_prorrateado3 = pvp3 * (1 + prorrateo_porcentaje / 100);
        var original3 = parseFloat(precio_prorrateado3);
        var result3 = Math.round(original3 * 100) / 100;
        parent.opener.document.getElementById("pvpc").value =  result3.toFixed(2);
        var precio_prorrateado4 = pvp4 * (1 + prorrateo_porcentaje / 100);
        var original4 = parseFloat(precio_prorrateado4);
        var result4 = Math.round(original4 * 100) / 100;
        parent.opener.document.getElementById("pvpd").value =  result4.toFixed(2);

        var op_des = localStorage.getItem('descuento');
        var precio_alone = 0;
        
        switch (op_des) {
            case '1':
                precio_alone = precio;
                parent.opener.document.getElementById("tipo_pvp").innerHTML = "A";
                break;
            case '2':
                precio_alone = pvp2;
                parent.opener.document.getElementById("tipo_pvp").innerHTML = "B";
                break;
            case '3':
                precio_alone = pvp3;
                parent.opener.document.getElementById("tipo_pvp").innerHTML = "C";
                break;
            case '4':
                precio_alone = pvp4;
                parent.opener.document.getElementById("tipo_pvp").innerHTML = "D";
                break;
        }

        var precio_prorrateado = precio_alone * (1 + prorrateo_porcentaje / 100);
        var original = parseFloat(precio_prorrateado);
        var result = Math.round(original * 100) / 100;
        parent.opener.document.getElementById("precio").value = result.toFixed(2);
        imp_aux = parent.opener.actualizar_importe_individual(1, result.toFixed(2));



        var iva_aux = parent.opener.actualizar_iva_individual(imp_aux, porcentaje_iva, iva);

        parent.opener.document.getElementById("dcto").value = 0;

        parent.opener.document.getElementById("costo").value = costo;
        parent.opener.document.getElementById("iva").value = iva_aux;

        if (origen == "alta") {
            parent.opener.document.getElementById("codtmp").value = codtmp;
            parent.opener.document.getElementById("id_articulo").value = idarticulo;
            parent.opener.document.getElementById("importe").value = imp_aux;
        } else if (origen == "modificar") {
            parent.opener.document.getElementById("id_factura").value = codtmp;
            parent.opener.document.getElementById("id_producto").value = idarticulo;
            parent.opener.document.getElementById("subtotal").value = imp_aux;
        }


        if (iva == 1) {

            parent.opener.document.getElementById("dproducto").style.background = 'orange';

        }
        else {

            parent.opener.document.getElementById("dproducto").style.background = 'white';
        }


        /*parent.opener.document.formulario.fname.value = nombre;
         parent.opener.document.formulario.lname.value = precio;
         parent.opener.document.formulario.tech.value = idarticulo;
         parent.opener.document.formulario.email.value = costo;
         parent.opener.document.formulario.address.value = stock;
         */
        /*
         removeOptions(parent.opener.document.formulario.series1);
         for (obj in series) {
         // Create an Option object
         var opt = document.createElement("option");
         // Add an Option object to Drop Down/List Box
         parent.opener.document.formulario.series1.options.add(opt);
         // Assign text and value to Option object
         opt.text = series[obj];
         opt.value = obj;
         }

         if (iva == 1) {
         parent.opener.document.formulario.ivaporc1.value = <?php //echo $ivaporcetaje;?>;
         parent.opener.document.formulario.grabaiva1.style.display = 'inherit';

         }
         else {

         parent.opener.document.formulario.ivaporc1.value = 0;
         parent.opener.document.formulario.grabaiva1.style.display = 'none';
         }
         parent.opener.document.formulario.transformacion1.value = transformacion;
         parent.opener.document.formulario.precio_con_iva1.value = precio_con_iva;
         parent.opener.activar_subgrupo('bodegas.php?idproducto=' + idarticulo, 'cbobodega1');


         //password = prompt("Producto sin STOCK en bodega.\n\nPara permitira su seleccion\nIngrese el password ", '');
         parent.opener.actualizar_importe();
         */
        parent.window.close();

    }


</script>

<body onload="load()">

<div id="pagina">
    <div id="zonaContenido">
        <form id="form1" name="form1">

            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">

                <thead>
                <tr>
                    <th width="1%"><span style="font-size: 12px">Barras</span></th>
                    <th width="69%"><span style="font-size: 12px">Nombre</span></th>
                    <th width="10%"><span style="font-size: 12px">Stock</span></th>
                    <th width="10%"><span style="font-size: 12px">Pvp</span></th>
                    <th width="5%"><span style="font-size: 12px">&nbsp;</span></th>
                </tr>
                </thead>
                <tbody style="font-size: 10px; padding: 1px" align="center">
                <tr>
                    <td colspan="3" class="dataTables_empty">Cargando Datos del Servidor</td>
                </tr>

                </tbody>

            </table>
            <!--<a href="#" style="font-size: 10px; font-style: normal"></a>-->
        </form>
    </div>
</div>
</body>
</html>
