<?php 
header('Cache-Control: no-cache');
header('Pragma: no-cache');

$op = $_POST["op"];
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
                parent.location.href = "ver_producto.php?idproducto=" + idproducto;
            }

            function modificar_producto(idproducto) {
                parent.location.href = "modificar_producto.php?idproducto=" + idproducto;
            }

            function eliminar_producto(idproducto) {
                parent.location.href = "eliminar_producto.php?idproducto=" + idproducto;
            }


            $(document).ready(function() {

                var oTable = $('#example').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "sPaginationType": "full_numbers",
                   
                    "sAjaxSource": "processing_inventario_productos.php",

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
                     "sMessage": "<H3>Inventario Productos</H3><br/>"
                             
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
                $('input:text').focus();


            });
        </script>
    </head>
    <script language="javascript">

        function pon_prefijo(codarticulo, nombre, precio, idarticulo, costo, stock, stock_consignacion, iva, transformacion, precio_con_iva) {
            var password = null;
            var clave = "a";
            var op =<?php  echo $op ?>;
            if (stock > 0)
            {
                switch (op)
                {
                    case 1:
                        parent.opener.document.formulario.codarticulo1.value = codarticulo;
                        parent.opener.document.formulario.descripcion1.value = nombre;
                        parent.opener.document.formulario.precio1.value = precio;
                        parent.opener.document.formulario.idarticulo1.value = idarticulo;
                        parent.opener.document.formulario.costo1.value = costo;
                        parent.opener.document.formulario.stock1.value = stock;
                        if (iva == 1)
                        {
                            parent.opener.document.formulario.ivaporc1.value = 12;
                            parent.opener.document.formulario.grabaiva1.style.display = 'inherit';

                        }
                        else
                        {
                            parent.opener.document.formulario.ivaporc1.value = 0;
                            parent.opener.document.formulario.grabaiva1.style.display = 'none';
                        }

                        parent.opener.document.formulario.transformacion1.value = transformacion;
                        parent.opener.document.formulario.precio_con_iva1.value = precio_con_iva;


                        break;

                    case 2:
                        parent.opener.document.formulario.codarticulo2.value = codarticulo;
                        parent.opener.document.formulario.descripcion2.value = nombre;
                        parent.opener.document.formulario.precio2.value = precio;
                        parent.opener.document.formulario.idarticulo2.value = idarticulo;
                        parent.opener.document.formulario.costo2.value = costo;
                        parent.opener.document.formulario.stock2.value = stock;
                        if (iva == 1)
                        {
                            parent.opener.document.formulario.ivaporc2.value = 12;
                            parent.opener.document.formulario.grabaiva2.style.display = 'inherit';
                        }
                        else
                        {
                            parent.opener.document.formulario.ivaporc2.value = 0;
                            parent.opener.document.formulario.grabaiva2.style.display = 'none';
                        }
                        parent.opener.document.formulario.transformacion2.value = transformacion;
                        parent.opener.document.formulario.precio_con_iva2.value = precio_con_iva;
                        break;

                    case 3:
                        parent.opener.document.formulario.codarticulo3.value = codarticulo;
                        parent.opener.document.formulario.descripcion3.value = nombre;
                        parent.opener.document.formulario.precio3.value = precio;
                        parent.opener.document.formulario.idarticulo3.value = idarticulo;
                        parent.opener.document.formulario.costo3.value = costo;
                        parent.opener.document.formulario.stock3.value = stock;
                        if (iva == 1)
                        {
                            parent.opener.document.formulario.ivaporc3.value = 12;
                            parent.opener.document.formulario.grabaiva3.style.display = 'inherit';
                        }
                        else
                        {
                            parent.opener.document.formulario.ivaporc3.value = 0;
                            parent.opener.document.formulario.grabaiva3.style.display = 'none';
                        }
                        parent.opener.document.formulario.transformacion3.value = transformacion;
                        parent.opener.document.formulario.precio_con_iva3.value = precio_con_iva;
                        break;

                    case 4:
                        parent.opener.document.formulario.codarticulo4.value = codarticulo;
                        parent.opener.document.formulario.descripcion4.value = nombre;
                        parent.opener.document.formulario.precio4.value = precio;
                        parent.opener.document.formulario.idarticulo4.value = idarticulo;
                        parent.opener.document.formulario.costo4.value = costo;
                        parent.opener.document.formulario.stock4.value = stock;
                        if (iva == 1)
                        {
                            parent.opener.document.formulario.ivaporc4.value = 12;
                            parent.opener.document.formulario.grabaiva4.style.display = 'inherit';
                        }
                        else
                        {
                            parent.opener.document.formulario.ivaporc4.value = 0;
                            parent.opener.document.formulario.grabaiva4.style.display = 'none';
                        }
                        parent.opener.document.formulario.transformacion4.value = transformacion;
                        parent.opener.document.formulario.precio_con_iva4.value = precio_con_iva;
                        break;

                    case 5:
                        parent.opener.document.formulario.codarticulo5.value = codarticulo;
                        parent.opener.document.formulario.descripcion5.value = nombre;
                        parent.opener.document.formulario.precio5.value = precio;
                        parent.opener.document.formulario.idarticulo5.value = idarticulo;
                        parent.opener.document.formulario.costo5.value = costo;
                        parent.opener.document.formulario.stock5.value = stock;
                        if (iva == 1)
                        {
                            parent.opener.document.formulario.ivaporc5.value = 12;
                            parent.opener.document.formulario.grabaiva5.style.display = 'inherit';
                        }
                        else
                        {
                            parent.opener.document.formulario.ivaporc5.value = 0;
                            parent.opener.document.formulario.grabaiva5.style.display = 'none';
                        }
                        parent.opener.document.formulario.transformacion5.value = transformacion;
                        parent.opener.document.formulario.precio_con_iva5.value = precio_con_iva;
                        break;

                    case 6:
                        parent.opener.document.formulario.codarticulo6.value = codarticulo;
                        parent.opener.document.formulario.descripcion6.value = nombre;
                        parent.opener.document.formulario.precio6.value = precio;
                        parent.opener.document.formulario.idarticulo6.value = idarticulo;
                        parent.opener.document.formulario.costo6.value = costo;
                        parent.opener.document.formulario.stock6.value = stock;
                        if (iva == 1)
                        {
                            parent.opener.document.formulario.ivaporc6.value = 12;
                            parent.opener.document.formulario.grabaiva6.style.display = 'inherit';
                        }
                        else
                        {
                            parent.opener.document.formulario.ivaporc6.value = 0;
                            parent.opener.document.formulario.grabaiva6.style.display = 'none';
                        }
                        parent.opener.document.formulario.transformacion6.value = transformacion;
                        parent.opener.document.formulario.precio_con_iva6.value = precio_con_iva;
                        break;

                    case 7:
                        parent.opener.document.formulario.codarticulo7.value = codarticulo;
                        parent.opener.document.formulario.descripcion7.value = nombre;
                        parent.opener.document.formulario.precio7.value = precio;
                        parent.opener.document.formulario.idarticulo7.value = idarticulo;
                        parent.opener.document.formulario.costo7.value = costo;
                        parent.opener.document.formulario.stock7.value = stock;
                        if (iva == 1)
                        {
                            parent.opener.document.formulario.ivaporc7.value = 12;
                            parent.opener.document.formulario.grabaiva7.style.display = 'inherit';
                        }
                        else
                        {
                            parent.opener.document.formulario.ivaporc7.value = 0;
                            parent.opener.document.formulario.grabaiva7.style.display = 'none';
                        }
                        parent.opener.document.formulario.transformacion7.value = transformacion;
                        parent.opener.document.formulario.precio_con_iva7.value = precio_con_iva;
                        break;

                    case 8:
                        parent.opener.document.formulario.codarticulo8.value = codarticulo;
                        parent.opener.document.formulario.descripcion8.value = nombre;
                        parent.opener.document.formulario.precio8.value = precio;
                        parent.opener.document.formulario.idarticulo8.value = idarticulo;
                        parent.opener.document.formulario.costo8.value = costo;
                        parent.opener.document.formulario.stock8.value = stock;
                        if (iva == 1)
                        {
                            parent.opener.document.formulario.ivaporc8.value = 12;
                            parent.opener.document.formulario.grabaiva8.style.display = 'inherit';
                        }
                        else
                        {
                            parent.opener.document.formulario.ivaporc8.value = 0;
                            parent.opener.document.formulario.grabaiva8.style.display = 'none';
                        }
                        parent.opener.document.formulario.transformacion8.value = transformacion;
                        parent.opener.document.formulario.precio_con_iva8.value = precio_con_iva;
                        break;

                    case 9:
                        parent.opener.document.formulario.codarticulo9.value = codarticulo;
                        parent.opener.document.formulario.descripcion9.value = nombre;
                        parent.opener.document.formulario.precio9.value = precio;
                        parent.opener.document.formulario.idarticulo9.value = idarticulo;
                        parent.opener.document.formulario.costo9.value = costo;
                        parent.opener.document.formulario.stock9.value = stock;
                        if (iva == 1)
                        {
                            parent.opener.document.formulario.ivaporc9.value = 12;
                            parent.opener.document.formulario.grabaiva9.style.display = 'inherit';
                        }
                        else
                        {
                            parent.opener.document.formulario.ivaporc9.value = 0;
                            parent.opener.document.formulario.grabaiva9.style.display = 'none';
                        }
                        parent.opener.document.formulario.transformacion9.value = transformacion;
                        parent.opener.document.formulario.precio_con_iva9.value = precio_con_iva;
                        break;

                    case 10:
                        parent.opener.document.formulario.codarticulo10.value = codarticulo;
                        parent.opener.document.formulario.descripcion10.value = nombre;
                        parent.opener.document.formulario.precio10.value = precio;
                        parent.opener.document.formulario.idarticulo10.value = idarticulo;
                        parent.opener.document.formulario.costo10.value = costo;
                        parent.opener.document.formulario.stock10.value = stock;
                        if (iva == 1)
                        {
                            parent.opener.document.formulario.ivaporc10.value = 12;
                            parent.opener.document.formulario.grabaiva10.style.display = 'inherit';
                        }
                        else
                        {
                            parent.opener.document.formulario.ivaporc10.value = 0;
                            parent.opener.document.formulario.grabaiva10.style.display = 'none';
                        }
                        parent.opener.document.formulario.transformacion10.value = transformacion;
                        parent.opener.document.formulario.precio_con_iva10.value = precio_con_iva;
                        break;
                    case 11:
                        parent.opener.document.formulario.codarticulo11.value = codarticulo;
                        parent.opener.document.formulario.descripcion11.value = nombre;
                        parent.opener.document.formulario.precio11.value = precio;
                        parent.opener.document.formulario.idarticulo11.value = idarticulo;
                        parent.opener.document.formulario.costo11.value = costo;
                        parent.opener.document.formulario.stock11.value = stock;
                        if (iva == 1)
                        {
                            parent.opener.document.formulario.ivaporc11.value = 12;
                            parent.opener.document.formulario.grabaiva11.style.display = 'inherit';
                        }
                        else
                        {
                            parent.opener.document.formulario.ivaporc11.value = 0;
                            parent.opener.document.formulario.grabaiva11.style.display = 'none';
                        }
                        parent.opener.document.formulario.transformacion11.value = transformacion;
                        parent.opener.document.formulario.precio_con_iva11.value = precio_con_iva;
                        break;
                }

                parent.opener.actualizar_importe(op);
                parent.window.close();
            }
            else
            {
                if (stock_consignacion > 0)

                {
                    switch (op)
                    {
                        case 1:
                            parent.opener.document.formulario.codarticulo1.value = codarticulo;
                            parent.opener.document.formulario.descripcion1.value = nombre;
                            parent.opener.document.formulario.precio1.value = precio;
                            parent.opener.document.formulario.idarticulo1.value = idarticulo;
                            parent.opener.document.formulario.costo1.value = costo;
                            parent.opener.document.formulario.stock1.value = stock_consignacion;
                            if (iva == 1)
                            {
                                parent.opener.document.formulario.ivaporc1.value = 12;
                                parent.opener.document.formulario.grabaiva1.style.display = 'inherit';

                            }
                            else
                            {
                                parent.opener.document.formulario.ivaporc1.value = 0;
                                parent.opener.document.formulario.grabaiva1.style.display = 'none';
                            }
                            parent.opener.document.formulario.transformacion1.value = transformacion;
                            parent.opener.document.formulario.precio_con_iva1.value = precio_con_iva;
                            break;

                        case 2:
                            parent.opener.document.formulario.codarticulo2.value = codarticulo;
                            parent.opener.document.formulario.descripcion2.value = nombre;
                            parent.opener.document.formulario.precio2.value = precio;
                            parent.opener.document.formulario.idarticulo2.value = idarticulo;
                            parent.opener.document.formulario.costo2.value = costo;
                            parent.opener.document.formulario.stock2.value = stock_consignacion;
                            if (iva == 1)
                            {
                                parent.opener.document.formulario.ivaporc2.value = 12;
                                parent.opener.document.formulario.grabaiva2.style.display = 'inherit';
                            }
                            else
                            {
                                parent.opener.document.formulario.ivaporc2.value = 0;
                                parent.opener.document.formulario.grabaiva2.style.display = 'none';
                            }
                            parent.opener.document.formulario.transformacion2.value = transformacion;
                            parent.opener.document.formulario.precio_con_iva2.value = precio_con_iva;
                            break;

                        case 3:
                            parent.opener.document.formulario.codarticulo3.value = codarticulo;
                            parent.opener.document.formulario.descripcion3.value = nombre;
                            parent.opener.document.formulario.precio3.value = precio;
                            parent.opener.document.formulario.idarticulo3.value = idarticulo;
                            parent.opener.document.formulario.costo3.value = costo;
                            parent.opener.document.formulario.stock3.value = stock_consignacion;
                            if (iva == 1)
                            {
                                parent.opener.document.formulario.ivaporc3.value = 12;
                                parent.opener.document.formulario.grabaiva3.style.display = 'inherit';
                            }
                            else
                            {
                                parent.opener.document.formulario.ivaporc3.value = 0;
                                parent.opener.document.formulario.grabaiva3.style.display = 'none';
                            }
                            parent.opener.document.formulario.transformacion3.value = transformacion;
                            parent.opener.document.formulario.precio_con_iva3.value = precio_con_iva;
                            break;

                        case 4:
                            parent.opener.document.formulario.codarticulo4.value = codarticulo;
                            parent.opener.document.formulario.descripcion4.value = nombre;
                            parent.opener.document.formulario.precio4.value = precio;
                            parent.opener.document.formulario.idarticulo4.value = idarticulo;
                            parent.opener.document.formulario.costo4.value = costo;
                            parent.opener.document.formulario.stock4.value = stock_consignacion;
                            if (iva == 1)
                            {
                                parent.opener.document.formulario.ivaporc4.value = 12;
                                parent.opener.document.formulario.grabaiva4.style.display = 'inherit';
                            }
                            else
                            {
                                parent.opener.document.formulario.ivaporc4.value = 0;
                                parent.opener.document.formulario.grabaiva4.style.display = 'none';
                            }
                            parent.opener.document.formulario.transformacion4.value = transformacion;
                            parent.opener.document.formulario.precio_con_iva4.value = precio_con_iva;
                            break;

                        case 5:
                            parent.opener.document.formulario.codarticulo5.value = codarticulo;
                            parent.opener.document.formulario.descripcion5.value = nombre;
                            parent.opener.document.formulario.precio5.value = precio;
                            parent.opener.document.formulario.idarticulo5.value = idarticulo;
                            parent.opener.document.formulario.costo5.value = costo;
                            parent.opener.document.formulario.stock5.value = stock_consignacion;
                            if (iva == 1)
                            {
                                parent.opener.document.formulario.ivaporc5.value = 12;
                                parent.opener.document.formulario.grabaiva5.style.display = 'inherit';
                            }
                            else
                            {
                                parent.opener.document.formulario.ivaporc5.value = 0;
                                parent.opener.document.formulario.grabaiva5.style.display = 'none';
                            }
                            parent.opener.document.formulario.transformacion5.value = transformacion;
                            parent.opener.document.formulario.precio_con_iva5.value = precio_con_iva;
                            break;

                        case 6:
                            parent.opener.document.formulario.codarticulo6.value = codarticulo;
                            parent.opener.document.formulario.descripcion6.value = nombre;
                            parent.opener.document.formulario.precio6.value = precio;
                            parent.opener.document.formulario.idarticulo6.value = idarticulo;
                            parent.opener.document.formulario.costo6.value = costo;
                            parent.opener.document.formulario.stock6.value = stock_consignacion;
                            if (iva == 1)
                            {
                                parent.opener.document.formulario.ivaporc6.value = 12;
                                parent.opener.document.formulario.grabaiva6.style.display = 'inherit';
                            }
                            else
                            {
                                parent.opener.document.formulario.ivaporc6.value = 0;
                                parent.opener.document.formulario.grabaiva6.style.display = 'none';
                            }
                            parent.opener.document.formulario.transformacion6.value = transformacion;
                            parent.opener.document.formulario.precio_con_iva6.value = precio_con_iva;
                            break;

                        case 7:
                            parent.opener.document.formulario.codarticulo7.value = codarticulo;
                            parent.opener.document.formulario.descripcion7.value = nombre;
                            parent.opener.document.formulario.precio7.value = precio;
                            parent.opener.document.formulario.idarticulo7.value = idarticulo;
                            parent.opener.document.formulario.costo7.value = costo;
                            parent.opener.document.formulario.stock7.value = stock_consignacion;
                            if (iva == 1)
                            {
                                parent.opener.document.formulario.ivaporc7.value = 12;
                                parent.opener.document.formulario.grabaiva7.style.display = 'inherit';
                            }
                            else
                            {
                                parent.opener.document.formulario.ivaporc7.value = 0;
                                parent.opener.document.formulario.grabaiva7.style.display = 'none';
                            }
                            parent.opener.document.formulario.transformacion7.value = transformacion;
                            parent.opener.document.formulario.precio_con_iva7.value = precio_con_iva;
                            break;

                        case 8:
                            parent.opener.document.formulario.codarticulo8.value = codarticulo;
                            parent.opener.document.formulario.descripcion8.value = nombre;
                            parent.opener.document.formulario.precio8.value = precio;
                            parent.opener.document.formulario.idarticulo8.value = idarticulo;
                            parent.opener.document.formulario.costo8.value = costo;
                            parent.opener.document.formulario.stock8.value = stock_consignacion;
                            if (iva == 1)
                            {
                                parent.opener.document.formulario.ivaporc8.value = 12;
                                parent.opener.document.formulario.grabaiva8.style.display = 'inherit';
                            }
                            else
                            {
                                parent.opener.document.formulario.ivaporc8.value = 0;
                                parent.opener.document.formulario.grabaiva8.style.display = 'none';
                            }
                            parent.opener.document.formulario.transformacion8.value = transformacion;
                            parent.opener.document.formulario.precio_con_iva8.value = precio_con_iva;
                            break;

                        case 9:
                            parent.opener.document.formulario.codarticulo9.value = codarticulo;
                            parent.opener.document.formulario.descripcion9.value = nombre;
                            parent.opener.document.formulario.precio9.value = precio;
                            parent.opener.document.formulario.idarticulo9.value = idarticulo;
                            parent.opener.document.formulario.costo9.value = costo;
                            parent.opener.document.formulario.stock9.value = stock_consignacion;
                            if (iva == 1)
                            {
                                parent.opener.document.formulario.ivaporc9.value = 12;
                                parent.opener.document.formulario.grabaiva9.style.display = 'inherit';
                            }
                            else
                            {
                                parent.opener.document.formulario.ivaporc9.value = 0;
                                parent.opener.document.formulario.grabaiva9.style.display = 'none';
                            }
                            parent.opener.document.formulario.transformacion9.value = transformacion;
                            parent.opener.document.formulario.precio_con_iva9.value = precio_con_iva;
                            break;

                        case 10:
                            parent.opener.document.formulario.codarticulo10.value = codarticulo;
                            parent.opener.document.formulario.descripcion10.value = nombre;
                            parent.opener.document.formulario.precio10.value = precio;
                            parent.opener.document.formulario.idarticulo10.value = idarticulo;
                            parent.opener.document.formulario.costo10.value = costo;
                            parent.opener.document.formulario.stock10.value = stock_consignacion;
                            if (iva == 1)
                            {
                                parent.opener.document.formulario.ivaporc10.value = 12;
                                parent.opener.document.formulario.grabaiva10.style.display = 'inherit';
                            }
                            else
                            {
                                parent.opener.document.formulario.ivaporc10.value = 0;
                                parent.opener.document.formulario.grabaiva10.style.display = 'none';
                            }
                            parent.opener.document.formulario.transformacion10.value = transformacion;
                            parent.opener.document.formulario.precio_con_iva10.value = precio_con_iva;
                            break;
                        case 11:
                            parent.opener.document.formulario.codarticulo11.value = codarticulo;
                            parent.opener.document.formulario.descripcion11.value = nombre;
                            parent.opener.document.formulario.precio11.value = precio;
                            parent.opener.document.formulario.idarticulo11.value = idarticulo;
                            parent.opener.document.formulario.costo11.value = costo;
                            parent.opener.document.formulario.stock11.value = stock_consignacion;
                            if (iva == 1)
                            {
                                parent.opener.document.formulario.ivaporc11.value = 12;
                                parent.opener.document.formulario.grabaiva11.style.display = 'inherit';
                            }
                            else
                            {
                                parent.opener.document.formulario.ivaporc11.value = 0;
                                parent.opener.document.formulario.grabaiva11.style.display = 'none';
                            }
                            parent.opener.document.formulario.transformacion11.value = transformacion;
                            parent.opener.document.formulario.precio_con_iva11.value = precio_con_iva;
                            break;
                    }

                    parent.opener.actualizar_importe(op);
                    parent.window.close();
                }


                else {
                    //alert("Producto sin STOCK en bodega.\n No puede ser seleccionado." );
                    password = prompt("Producto sin STOCK en bodega.\n\nPara permitira su seleccion\nIngrese el password ", '');
                    if (password == clave)
                    {
                        switch (op)
                        {
                            case 1:
                                parent.opener.document.formulario.codarticulo1.value = codarticulo;
                                parent.opener.document.formulario.descripcion1.value = nombre;
                                parent.opener.document.formulario.precio1.value = precio;
                                parent.opener.document.formulario.idarticulo1.value = idarticulo;
                                parent.opener.document.formulario.costo1.value = costo;
                                parent.opener.document.formulario.stock1.value = stock;
                                if (iva == 1)
                                {
                                    parent.opener.document.formulario.ivaporc1.value = 12;
                                    parent.opener.document.formulario.grabaiva1.style.display = 'inherit';
                                }
                                else
                                {
                                    parent.opener.document.formulario.ivaporc1.value = 0;
                                    parent.opener.document.formulario.grabaiva1.style.display = 'none';
                                }
                                parent.opener.document.formulario.transformacion1.value = transformacion;
                                parent.opener.document.formulario.precio_con_iva1.value = precio_con_iva;

                                parent.opener.document.formulario.cantidad1.value = 0;
                                break;

                            case 2:
                                parent.opener.document.formulario.codarticulo2.value = codarticulo;
                                parent.opener.document.formulario.descripcion2.value = nombre;
                                parent.opener.document.formulario.precio2.value = precio;
                                parent.opener.document.formulario.idarticulo2.value = idarticulo;
                                parent.opener.document.formulario.costo2.value = costo;
                                parent.opener.document.formulario.stock2.value = stock;
                                if (iva == 1)
                                {
                                    parent.opener.document.formulario.ivaporc2.value = 12;
                                    parent.opener.document.formulario.grabaiva2.style.display = 'inherit';
                                }
                                else
                                {
                                    parent.opener.document.formulario.ivaporc2.value = 0;
                                    parent.opener.document.formulario.grabaiva2.style.display = 'none';
                                }
                                parent.opener.document.formulario.transformacion2.value = transformacion;
                                parent.opener.document.formulario.precio_con_iva2.value = precio_con_iva;

                                parent.opener.document.formulario.cantidad2.value = 0;
                                break;

                            case 3:
                                parent.opener.document.formulario.codarticulo3.value = codarticulo;
                                parent.opener.document.formulario.descripcion3.value = nombre;
                                parent.opener.document.formulario.precio3.value = precio;
                                parent.opener.document.formulario.idarticulo3.value = idarticulo;
                                parent.opener.document.formulario.costo3.value = costo;
                                parent.opener.document.formulario.stock3.value = stock;
                                if (iva == 1)
                                {
                                    parent.opener.document.formulario.ivaporc3.value = 12;
                                    parent.opener.document.formulario.grabaiva3.style.display = 'inherit';
                                }
                                else
                                {
                                    parent.opener.document.formulario.ivaporc3.value = 0;
                                    parent.opener.document.formulario.grabaiva3.style.display = 'none';
                                }
                                parent.opener.document.formulario.transformacion3.value = transformacion;
                                parent.opener.document.formulario.precio_con_iva3.value = precio_con_iva;

                                parent.opener.document.formulario.cantidad3.value = 0;
                                break;

                            case 4:
                                parent.opener.document.formulario.codarticulo4.value = codarticulo;
                                parent.opener.document.formulario.descripcion4.value = nombre;
                                parent.opener.document.formulario.precio4.value = precio;
                                parent.opener.document.formulario.idarticulo4.value = idarticulo;
                                parent.opener.document.formulario.costo4.value = costo;
                                parent.opener.document.formulario.stock4.value = stock;
                                if (iva == 1)
                                {
                                    parent.opener.document.formulario.ivaporc4.value = 12;
                                    parent.opener.document.formulario.grabaiva4.style.display = 'inherit';
                                }
                                else
                                {
                                    parent.opener.document.formulario.ivaporc4.value = 0;
                                    parent.opener.document.formulario.grabaiva4.style.display = 'none';
                                }
                                parent.opener.document.formulario.transformacion4.value = transformacion;
                                parent.opener.document.formulario.precio_con_iva4.value = precio_con_iva;

                                parent.opener.document.formulario.cantidad4.value = 0;
                                break;

                            case 5:
                                parent.opener.document.formulario.codarticulo5.value = codarticulo;
                                parent.opener.document.formulario.descripcion5.value = nombre;
                                parent.opener.document.formulario.precio5.value = precio;
                                parent.opener.document.formulario.idarticulo5.value = idarticulo;
                                parent.opener.document.formulario.costo5.value = costo;
                                parent.opener.document.formulario.stock5.value = stock;
                                if (iva == 1)
                                {
                                    parent.opener.document.formulario.ivaporc5.value = 12;
                                    parent.opener.document.formulario.grabaiva5.style.display = 'inherit';
                                }
                                else
                                {
                                    parent.opener.document.formulario.ivaporc5.value = 0;
                                    parent.opener.document.formulario.grabaiva5.style.display = 'none';
                                }
                                parent.opener.document.formulario.transformacion5.value = transformacion;
                                parent.opener.document.formulario.precio_con_iva5.value = precio_con_iva;

                                parent.opener.document.formulario.cantidad5.value = 0;
                                break;

                            case 6:
                                parent.opener.document.formulario.codarticulo6.value = codarticulo;
                                parent.opener.document.formulario.descripcion6.value = nombre;
                                parent.opener.document.formulario.precio6.value = precio;
                                parent.opener.document.formulario.idarticulo6.value = idarticulo;
                                parent.opener.document.formulario.costo6.value = costo;
                                parent.opener.document.formulario.stock6.value = stock;
                                if (iva == 1)
                                {
                                    parent.opener.document.formulario.ivaporc6.value = 12;
                                    parent.opener.document.formulario.grabaiva6.style.display = 'inherit';
                                }
                                else
                                {
                                    parent.opener.document.formulario.ivaporc6.value = 0;
                                    parent.opener.document.formulario.grabaiva6.style.display = 'none';
                                }
                                parent.opener.document.formulario.transformacion6.value = transformacion;
                                parent.opener.document.formulario.precio_con_iva6.value = precio_con_iva;

                                parent.opener.document.formulario.cantidad6.value = 0;
                                break;

                            case 7:
                                parent.opener.document.formulario.codarticulo7.value = codarticulo;
                                parent.opener.document.formulario.descripcion7.value = nombre;
                                parent.opener.document.formulario.precio7.value = precio;
                                parent.opener.document.formulario.idarticulo7.value = idarticulo;
                                parent.opener.document.formulario.costo7.value = costo;
                                parent.opener.document.formulario.stock7.value = stock;
                                if (iva == 1)
                                {
                                    parent.opener.document.formulario.ivaporc7.value = 12;
                                    parent.opener.document.formulario.grabaiva7.style.display = 'inherit';
                                }
                                else
                                {
                                    parent.opener.document.formulario.ivaporc7.value = 0;
                                    parent.opener.document.formulario.grabaiva7.style.display = 'none';
                                }
                                parent.opener.document.formulario.transformacion7.value = transformacion;
                                parent.opener.document.formulario.precio_con_iva7.value = precio_con_iva;

                                parent.opener.document.formulario.cantidad7.value = 0;
                                break;

                            case 8:
                                parent.opener.document.formulario.codarticulo8.value = codarticulo;
                                parent.opener.document.formulario.descripcion8.value = nombre;
                                parent.opener.document.formulario.precio8.value = precio;
                                parent.opener.document.formulario.idarticulo8.value = idarticulo;
                                parent.opener.document.formulario.costo8.value = costo;
                                parent.opener.document.formulario.stock8.value = stock;
                                if (iva == 1)
                                {
                                    parent.opener.document.formulario.ivaporc8.value = 12;
                                    parent.opener.document.formulario.grabaiva8.style.display = 'inherit';
                                }
                                else
                                {
                                    parent.opener.document.formulario.ivaporc8.value = 0;
                                    parent.opener.document.formulario.grabaiva8.style.display = 'none';
                                }
                                parent.opener.document.formulario.transformacion8.value = transformacion;
                                parent.opener.document.formulario.precio_con_iva8.value = precio_con_iva;

                                parent.opener.document.formulario.cantidad8.value = 0;
                                break;

                            case 9:
                                parent.opener.document.formulario.codarticulo9.value = codarticulo;
                                parent.opener.document.formulario.descripcion9.value = nombre;
                                parent.opener.document.formulario.precio9.value = precio;
                                parent.opener.document.formulario.idarticulo9.value = idarticulo;
                                parent.opener.document.formulario.costo9.value = costo;
                                parent.opener.document.formulario.stock9.value = stock;
                                if (iva == 1)
                                {
                                    parent.opener.document.formulario.ivaporc9.value = 12;
                                    parent.opener.document.formulario.grabaiva9.style.display = 'inherit';
                                }
                                else
                                {
                                    parent.opener.document.formulario.ivaporc9.value = 0;
                                    parent.opener.document.formulario.grabaiva9.style.display = 'none';
                                }
                                parent.opener.document.formulario.transformacion9.value = transformacion;
                                parent.opener.document.formulario.precio_con_iva9.value = precio_con_iva;

                                parent.opener.document.formulario.cantidad9.value = 0;
                                break;

                            case 10:
                                parent.opener.document.formulario.codarticulo10.value = codarticulo;
                                parent.opener.document.formulario.descripcion10.value = nombre;
                                parent.opener.document.formulario.precio10.value = precio;
                                parent.opener.document.formulario.idarticulo10.value = idarticulo;
                                parent.opener.document.formulario.costo10.value = costo;
                                parent.opener.document.formulario.stock10.value = stock;
                                if (iva == 1)
                                {
                                    parent.opener.document.formulario.ivaporc10.value = 12;
                                    parent.opener.document.formulario.grabaiva10.style.display = 'inherit';
                                }
                                else
                                {
                                    parent.opener.document.formulario.ivaporc10.value = 0;
                                    parent.opener.document.formulario.grabaiva10.style.display = 'none';
                                }
                                parent.opener.document.formulario.transformacion10.value = transformacion;
                                parent.opener.document.formulario.precio_con_iva10.value = precio_con_iva;

                                parent.opener.document.formulario.cantidad10.value = 0;
                                break;
                            case 11:
                                parent.opener.document.formulario.codarticulo11.value = codarticulo;
                                parent.opener.document.formulario.descripcion11.value = nombre;
                                parent.opener.document.formulario.precio11.value = precio;
                                parent.opener.document.formulario.idarticulo11.value = idarticulo;
                                parent.opener.document.formulario.costo11.value = costo;
                                parent.opener.document.formulario.stock11.value = stock;
                                if (iva == 1)
                                {
                                    parent.opener.document.formulario.ivaporc11.value = 12;
                                    parent.opener.document.formulario.grabaiva11.style.display = 'inherit';
                                }
                                else
                                {
                                    parent.opener.document.formulario.ivaporc11.value = 0;
                                    parent.opener.document.formulario.grabaiva11.style.display = 'none';
                                }
                                parent.opener.document.formulario.transformacion11.value = transformacion;
                                parent.opener.document.formulario.precio_con_iva11.value = precio_con_iva;

                                parent.opener.document.formulario.cantidad11.value = 0;
                                break;
                        }

                        parent.opener.actualizar_importe(op);
                        parent.window.close();
                    }
                }
            }
        }


    </script>

    <body onload="load()" >

        <div id="pagina">
            <div id="zonaContenido">
                <form id="form1" name="form1">

                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">

                        <thead>
                            <tr>
<!--                                        <th><span style="font-size: 10px">Codigo</span></th>-->
                                <th width="70%"><span style="font-size: 12px">Nombre</span></th>
                                <th width="10%"><span style="font-size: 12px">Stock</span></th>
                                <th width="10%"><span style="font-size: 12px">Consig.</span></th>
                                <th width="10%"><span style="font-size: 12px">Pvp</span></th>
<!--                                        <th ><span style="font-size: 10px">Exp</span></th>                                        -->
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
