<?php

$idproducto = $_GET["idproducto"];

include_once '../conexion/conexion.php';
include_once 'class/producto.php';

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$producto = new Producto();
$row = $producto->get_producto_id($conn, $idproducto);

?>
<html>
<head>
    <title>Principal</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">

    <link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
    <script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
    <script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
    <script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>


    <script type="text/javascript" src="../js/validar.js"></script>

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

        function cancelar() {
            location.href = "index.php";
        }

        var cursor;
        if (document.all) {
            // Está utilizando EXPLORER
            cursor = 'hand';
        } else {
            // Está utilizando MOZILLA/NETSCAPE
            cursor = 'pointer';
        }

        function limpiar() {
            document.getElementById("formulario").reset();
        }


        // creando objeto XMLHttpRequest de Ajax
        var obXHR;
        try {
            obXHR = new XMLHttpRequest();
        } catch (err) {
            try {
                obXHR = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (err) {
                try {
                    obXHR = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (err) {
                    obXHR = false;
                }
            }
        }


        function activar_subgrupo(url, obId) {
            document.getElementById(obId).disabled = false;

            var obCon = document.getElementById(obId);
            obXHR.open("GET", url);
            obXHR.onreadystatechange = function () {
                if (obXHR.readyState == 4 && obXHR.status == 200) {
                    obXML = obXHR.responseXML;
                    obCod = obXML.getElementsByTagName("id");
                    obDes = obXML.getElementsByTagName("nombre");
                    obCon.length = obCod.length;
                    for (var i = 0; i < obCod.length; i++) {
                        obCon.options[i].value = obCod[i].firstChild.nodeValue;
                        obCon.options[i].text = obDes[i].firstChild.nodeValue;
                    }
                }
            }
            obXHR.send(null);

        }

        function cargainicio(idgrupo) {
            url = "subgrupo.php?grupo=" + idgrupo;
            obId = "subgrupo";
            activar_subgrupo(url, obId);
        }


        $(document).ready(function () {

            oTable = $('#example').dataTable({


                "processing": true,
                "serverSide": true,
                "sAjaxSource": "processing_bodega_producto.php?idproducto=<?php echo $idproducto;?>",
                "sPaginationType": "full_numbers",
                dom: '<"top"lBf>rt<"bottom"ip><"clear">',
                buttons: [
                    'excel', 'pdf', 'print'
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


            })

        });


    </script>
</head>
<body>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header">MODIFICAR PRODUCTO</div>
            <div id="frmBusqueda">
                <form id="formulario" name="formulario" method="post" action="save_producto.php">
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                        <tr>
                            <td>ID</td>
                            <td><?php echo $idproducto ?></td>
                            <td width="42%" rowspan="14" align="left" valign="top">
                                <ul id="lista-errores"></ul>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%">Producto Gasto:</td>
                            <td width="43%">
                                <select NAME="Agasto" id="gasto" class="comboGrande">
                                    <?php if ($row['gasto'] == 0) { ?>

                                        <option value="no" selected>No</option>
                                        <option value="si">Si</option>
                                    <?php } else { ?>
                                        <option value="no">No</option>
                                        <option value="si" selected>Si</option>
                                    <?php } ?>
                                </select>
                            </td>

                        </tr>
                        <tr>
                            <td width="15%">Codigo</td>
                            <td width="43%"><input NAME="Acodigo" type="text" class="cajaGrande" id="cogigo"
                                                   value="<?php echo $row['codigo'] ?>" size="45" maxlength="45"></td>
                        </tr>

                        <tr>
                            <td width="15%">Nombre</td>
                            <td width="43%"><input NAME="Anombre" type="text" class="cajaGrande" id="nombre"
                                                   value="<?php echo $row['nombre'] ?>" size="45"></td>
                        </tr>

                        <tr>
                            <td width="15%">GRAVA IVA</td>
                            <td width="43%">
                                <select NAME="iva" id="iva" class="comboPequeno">
                                    <?php if ($row["iva"] == 0) { ?>
                                        <option selected value="0">No</option>
                                        <option value="1">Si</option>
                                    <?php } else { ?>
                                        <option value="0">No</option>
                                        <option selected value="1">Si</option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td width="15%">PRODUCTO ESPECIAL</td>
                            <td width="43%">
                                <select NAME="especial" id="especial" class="comboPequeno">
                                    <?php if ($row["moto"] == 0) { ?>
                                        <option selected value="0">No</option>
                                        <option value="1">Si</option>
                                    <?php } else { ?>
                                        <option value="0">No</option>
                                        <option selected value="1">Si</option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%">Stock</td>
                            <td width="43%"> <?php echo $row['stock'] ?></td>
                        </tr>
                        <tr>
                            <td width="15%">Stock Consignacion</td>
                            <td width="43%"><input NAME="astock_consignacion" type="text" class="cajaPequena"
                                                   id="stock_consignacion"
                                                   value="<?php echo $row['stock_consignacion'] ?>" size="15"
                                                   maxlength="45"></td>
                        </tr>
                        <tr>
                            <td width="15%">Costo</td>
                            <td width="43%"><input NAME="qcosto" type="text" class="cajaPequena" id="costo"
                                                   value="<?php echo $row['costo'] ?>" size="15" maxlength="45"
                                                   value="0"></td>
                        </tr>
                        <tr>
                            <td width="15%">PVP</td>
                            <td width="43%"><input NAME="Qpvp" type="text" class="cajaPequena" id="pvp"
                                                   value="<?php echo $row['pvp'] ?>" size="15" maxlength="45"></td>
                        </tr>

                        <tr>
                            <td width="15%">PVP2</td>
                            <td width="43%"><input NAME="Qpvp2" type="text" class="cajaPequena" id="pvp2"
                                                   value="<?php echo $row['pvp2'] ?>" size="15" maxlength="45"></td>
                        </tr>

                        <tr>
                            <td width="15%">PVP3</td>
                            <td width="43%"><input NAME="Qpvp3" type="text" class="cajaPequena" id="pvp3"
                                                   value="<?php echo $row['pvp3'] ?>" size="15" maxlength="45"></td>
                        </tr>

                        <tr>
                            <td width="15%">PVP4</td>
                            <td width="43%"><input NAME="Qpvp4" type="text" class="cajaPequena" id="pvp4"
                                                   value="<?php echo $row['pvp4'] ?>" size="15" maxlength="45"></td>
                        </tr>

                        <tr>
                            <td width="15%">UNIDAD</td>
                            <td width="43%"><input NAME="aunidad" type="text" class="cajaPequena" id="unidad" size="15"
                                                   maxlength="45" value="<?php echo $row['unidad'] ?>"></td>
                        </tr>
                        <tr>
                            <td width="15%">UNIDAD X PACA</td>
                            <td width="43%"><input NAME="auxpaca" type="text" class="cajaPequena" id="uxpaca" size="15"
                                                   maxlength="45" value="<?php echo $row['uxpaca'] ?>"></td>
                        </tr>
                        <tr>
                            <td width="15%">CODIGO DE BARRAS</td>
                            <td width="43%"><input NAME="alector" type="text" class="cajaGrande" id="lector" size="15"
                                                   maxlength="45" ></td>
                        </tr>
                        <tr>
                            <td width="15%">Utilidad</td>
                            <td width="43%"><input NAME="qutilidad" type="text" class="cajaPequena" id="utilidad"
                                                   size="15" maxlength="45" value="<?php echo $row['utilidad'] ?>">%
                            </td>
                        </tr>

                        <tr>
                            <td width="17%">Composici&oacute;n</td>
                            <td><textarea name="acomposicion" cols="41" rows="2" id="composicion"
                                          class="areaTexto"><?php echo $row['composicion'] ?></textarea></td>
                        </tr>
                        <tr>
                            <td width="17%">Aplicaci&oacute;n</td>
                            <td><textarea name="aplicacion" cols="41" rows="2" id="aplicacion"
                                          class="areaTexto"><?php echo $row['aplicacion'] ?></textarea></td>
                        </tr>
                        <tr>
                            <td width="15%">Proveedor</td>
                            <?php
                            $query_prov = "SELECT id_proveedor, empresa FROM proveedor";
                            $result_prov = mysql_query($query_prov, $conn);
                            ?>
                            <td width="43%">
                                <select name="Aproveedor" id="proveedor" class="comboGrande">
                                    <option value="0">Seleccionar Proveedor</option>
                                    <?php
                                    $contador = 0;
                                    while ($contador < mysql_num_rows($result_prov)) {
                                        if ($row['proveedor'] == mysql_result($result_prov, $contador, "id_proveedor")) {
                                            ?>
                                            <option selected
                                                    value="<?php echo mysql_result($result_prov, $contador, "id_proveedor") ?>"><?php echo mysql_result($result_prov, $contador, "empresa") ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option
                                                value="<?php echo mysql_result($result_prov, $contador, "id_proveedor") ?>"><?php echo mysql_result($result_prov, $contador, "empresa") ?></option>
                                            <?php
                                        }
                                        $contador++;
                                    }
                                    ?>
                                </select>

                            </td>

                        </tr>


                        <tr>
                            <td>Grupo</td>
                            <?php
                            $query_grupo = "SELECT id_grupo, nombre FROM grupo";
                            $result_grupo = mysql_query($query_grupo, $conn);
                            ?>
                            <td>
                                <select name="Agrupo" id="grupo" class="comboGrande"
                                        onchange="activar_subgrupo('subgrupo.php?grupo='+this.value,'subgrupo')">
                                    <option value="0">Seleccionar Grupo</option>
                                    <?php
                                    $contador1 = 0;
                                    while ($contador1 < mysql_num_rows($result_grupo)) {
                                        if ($row['grupo'] == mysql_result($result_grupo, $contador1, "id_grupo")) {

                                            ?>
                                            <option selected
                                                    value="<?php echo mysql_result($result_grupo, $contador1, "id_grupo") ?>"><?php echo mysql_result($result_grupo, $contador1, "nombre") ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option
                                                value="<?php echo mysql_result($result_grupo, $contador1, "id_grupo") ?>"><?php echo mysql_result($result_grupo, $contador1, "nombre") ?></option>
                                            <?php
                                        }
                                        $contador1++;
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>


                        <tr>
                            <td>Subgrupo</td>
                            <td>
                                <?php
                                $query_subgrupo = "SELECT id_subgrupo, nombre FROM subgrupo WHERE id_grupo=" . $row['grupo'];
                                $result_subgrupo = mysql_query($query_subgrupo, $conn);
                                ?>
                                <select name="Asubgrupo" id="subgrupo" class="comboGrande">

                                    <?php
                                    $contador2 = 0;
                                    while ($contador2 < mysql_num_rows($result_subgrupo)) {
                                        if ($row['subgrupo'] == mysql_result($result_subgrupo, $contador2, "id_subgrupo")) {

                                            ?>
                                            <option selected
                                                    value="<?php echo mysql_result($result_subgrupo, $contador2, "id_subgrupo") ?>"><?php echo mysql_result($result_subgrupo, $contador2, "nombre") ?></option>
                                            <?php
                                        } else {
                                            ?>
                                            <option
                                                value="<?php echo mysql_result($result_subgrupo, $contador2, "id_grupo") ?>"><?php echo mysql_result($result_subgrupo, $contador2, "nombre") ?></option>
                                            <?php
                                        }
                                        $contador2++;
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>


                    </table>
            </div>
            <div id="botonBusqueda">
                <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1"
                     onMouseOver="style.cursor=cursor">
                <img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1"
                     onMouseOver="style.cursor=cursor">
                <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1"
                     onMouseOver="style.cursor=cursor">
                <input id="accion" name="accion" value="modificar" type="hidden">
                <input id="id" name="id" value="" type="hidden">
                <input id="idproducto" name="idproducto" value="<?php echo $idproducto ?>" type="hidden">
                <input NAME="Rstock" id="stock" value="<?php echo $row['stock'] ?>" type="hidden">
            </div>
            </form>

            <!-- Inicio PRODUCTOS BODEGA--------------------------------------------------------->
            <div style="width:40%">

                <div id="tituloForm" class="header" style="background: #024769">STOCK EN BODEGAS</div>

                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                    <tr>
                        <th width=""><span style="font-size: 10px">BODEGA</span></th>
                        <th width=""><span style="font-size: 10px">STOCK</span></th>

                    </tr>
                    </thead>
                    <tbody style="font-size: 10px; padding: 1px" align="center">
                    <tr>
                        <td colspan="2" class="dataTables_empty">Cargando Datos del Servidor</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- Fin PRODUCTOS BODEGA------------------------------------------------------------>

        </div>
    </div>
</div>
</body>
</html>
