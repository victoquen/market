<?php
//get datos SESSION
session_start();
$id_bodega = $_SESSION['id_bodega'];
//*********************************************************************

include("../conexion/conexion.php");
error_reporting(0);
$db = new ServidorBaseDatos();
$conn = $db->getConexion();

//porcentaje iva parametrizable*****************************************
$sel_iva = "select porcentaje FROM iva where activo=1 AND borrado=0";
$rs_iva = mysql_query($sel_iva, $conn);
$ivaporcetaje = mysql_result($rs_iva, 0, "porcentaje");
//**********************************************************************

//numero items parametrizable*****************************************
$sel_items = "select item FROM param_item where borrado=0";
$rs_items = mysql_query($sel_items, $conn);
$totalitems = mysql_result($rs_items, 0, "item");
//**********************************************************************

$fechahoy = date("Y-m-d");

$idruc = 1;

//tabla temporal articulos**********************************************************************************************
$sel_fact = "INSERT INTO facturastmp (codfactura,fecha) VALUE (null,'$fechahoy')";
$rs_fact = mysql_query($sel_fact, $conn);
$codfacturatmp = mysql_insert_id();

$query = "DELETE FROM factulineaptmp WHERE codtmp='$codfacturatmp'";
$rs = mysql_query($query, $conn);
//**********************************************************************************************************************


//datos factureros existentes
$query_o = "SELECT * FROM facturero WHERE id_ruc= $idruc";
$res_o = mysql_query($query_o, $conn);


//id facturero por defecto segun EL USUARIO
$idfacturero_seleccionado = $_REQUEST["idfacturero"];
$tipo = $_REQUEST["tipo"];


//numero factura
$sel_facturero = "select serie1, serie2, autorizacion, inicio, fin, fecha_caducidad FROM facturero where id_facturero=$idfacturero_seleccionado";
$rs_facturero = mysql_query($sel_facturero, $conn);
$serie1 = mysql_result($rs_facturero, 0, "serie1");
$serie2 = mysql_result($rs_facturero, 0, "serie2");
$autorizacion = mysql_result($rs_facturero, 0, "autorizacion");
$inicio = mysql_result($rs_facturero, 0, "inicio");
$fin = mysql_result($rs_facturero, 0, "fin");
$fecha_caducidad = mysql_result($rs_facturero, 0, "fecha_caducidad");

//numero de factura maximo
$sel_max = "SELECT max(codigo_factura)as maximo FROM facturas WHERE id_facturero = $idfacturero_seleccionado";
$rs_max = mysql_query($sel_max, $conn);
$maximo = mysql_result($rs_max, 0, "maximo");

if (($maximo == 0) || ($maximo < $inicio)) {

    $maximo = $inicio;
} else {
    $maximo = $maximo + 1;
}

$fechah = strtotime($fechahoy, 0);
$fechac = strtotime($fecha_caducidad, 0);

if (($maximo >= $inicio) && ($maximo <= $fin) && ($fechah <= $fechac)) {
    $aceptacion = 1;
    $mensaje_aceptacion = "todo valido";
} else {
    $aceptacion = 0;
    $mensaje_aceptacion = "Numeracion de Facturero Caducado, no se podra facturar. Por Favor Actualizar datos del Facturero." . $idfacturero_seleccionado;
}


//CLIENTE POR DEFECTO CONSUMIDOR FINAL 9999999999999
$sel_cliente = "SELECT * FROM cliente WHERE ci_ruc ='9999999999999'";
$rs_cliente = mysql_query($sel_cliente, $conn);

$codtipo = mysql_result($rs_cliente, 0, "codigo_tipocliente");
$sel_tipocliente = "SELECT nombre FROM tipo_cliente WHERE codigo_tipocliente='$codtipo'";
$rs_tipocliente = mysql_query($sel_tipocliente, $conn);

//AJAX data table edit ********************
require_once("ajax_table.class.php");
$obj = new ajax_table();
$records = array();
//************************************

?>


<html>
<head>
    <title>Principal</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
    <script type="text/JavaScript" language="javascript" src="js/articulos_factura.js"></script>
    <!-- INICIO ARCHIVOS CALENDARIO -->
    <link rel="stylesheet" href="../css/jquery-ui.css"/>
    <link rel="stylesheet" href="../css/jquery-ui.min.css"/>
    <link rel="stylesheet" href="../css/jquery-ui.structure.css"/>
    <link rel="stylesheet" href="../css/jquery-ui.structure.min.css"/>
    <script src="../js/jquery-1.12.4.js"></script>
    <script src="../js/1.12.1_jquery-ui..js"></script>

    <script language="javascript">
        $(function () {
            $("#fecha").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd/mm/yy',
                showOn: "button",
                buttonImage: "../img/calendario.png",
                buttonImageOnly: true,
                buttonText: "Seleccionar Fecha"
            });
        });
    </script>
    <!-- FIN ARCHIVOS CALENDARIO -->

    <!-- INICIO AJAX EDIT DATA TABLE -->
    <script>
        // Column names must be identical to the actual column names in the database, if you dont want to reveal the column names, you can map them with the different names at the server side.

        localStorage.clear();

        localStorage.setItem('codtmp', <?php echo $codfacturatmp;?>);
        localStorage.setItem('id_bodega',<?php echo $id_bodega;?>);
        localStorage.setItem('iva_porcentaje',<?php echo $ivaporcetaje;?>);

        localStorage.setItem('descuento', '1');
        localStorage.setItem('descuento', '2');
        localStorage.setItem('itemstotal', <?php echo $totalitems;?>);
        localStorage.setItem('totalrecord', '0');

        var columns = new Array("dproducto", "cantidad", "precio", "dcto", "importe", "iva", "id_bodega", "codtmp", "id_articulo", "costo");
        var columns_edit = new Array("cantidad", "precio", "dcto", "importe", "iva");
        var columns_totales = new Array("baseimponible", "iva0", "iva12", "importeiva", "descuentototal", "preciototal", "preciototal_c");
        var placeholder = new Array("Producto", "Cantidad", "$ 0.00", "Dcto.", "SubTotal", "Imp IVA", "id_bodega", "codtmp", "id_articulo", "costo");
        var inputType = new Array("text", "text", "text", "text", "text", "text", "hidden", "hidden", "hidden", "hidden");
        var table = "tableDemo";


        // Set button class names
        var savebutton = "ajaxSave";
        var deletebutton = "ajaxDelete";
        var editbutton = "ajaxEdit";
        var updatebutton = "ajaxUpdate";
        var cancelbutton = "cancel";

        var saveImage = "images/save.png"
        var editImage = "images/edit.png"
        var deleteImage = "images/remove.png"
        var cancelImage = "images/back.png"
        var updateImage = "images/save.png"

        // Set highlight animation delay (higher the value longer will be the animation)
        //var saveAnimationDelay = 3000;
        //var deleteAnimationDelay = 1000;
        var saveAnimationDelay = 100;
        var deleteAnimationDelay = 100;

        // 2 effects available available 1) slide 2) flash
        var effect = "flash";


    </script>
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <!-- FIN  AJAX EDIT DATA TABLE -->


    <script language="javascript">
        var cursor;
        var idf;


        if (document.all) {
            // Está utilizando EXPLORER
            cursor = 'hand';
        } else {
            // Está utilizando MOZILLA/NETSCAPE
            cursor = 'pointer';
        }

        function inicio(aceptacion, mensaje) {
            if (aceptacion == 0) {
                alert(mensaje + " max: " +<?php echo $idfacturero_seleccionado?>);
                location.href = "index.php";
            }
        }

        function getIdf() {
            return idf;
        }

        function cambio_facturero() {

            var op = document.getElementById("facturero").value;
            location.href = "new_facturaventa.php?idfacturero=" + op;
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


        function removeOptionss(obj) {
            while (obj.options.length) {
                obj.remove(0);
            }
        }

        function limpiar_articulo(op) {

            actualizar_totales();
        }

        function temporal() {

        }
    </script>
</head>
<body onload="inicio('<?php echo $aceptacion ?>', '<?php echo $mensaje_aceptacion ?>')">
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header">INSERTAR FACTURA VENTA</div>
            <div id="frmBusqueda">
                <form id="formulario" name="formulario" method="post" action="guardar_factura.php">
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>

                        <tr>
                            <td width="6%">Nombre</td>
                            <td width="25%"><input NAME="nombre" type="text" class="cajaGrande" id="nombre" size="45"
                                                   maxlength="45" onClick="abreVentana()" readonly
                                                   value="<?php echo utf8_decode(mysql_result($rs_cliente, 0, "nombre")); ?>">
                                <img src="../img/ver.png" width="16" height="16" onClick="abreVentana()"
                                     title="Buscar cliente" onMouseOver="style.cursor = cursor">
                            </td>
                            <td width="6%">C&oacute;digo Cliente</td>
                            <td width="20%"><input NAME="codcliente" type="text" class="cajaPequena" id="codcliente"
                                                   size="6" maxlength="5"
                                                   value="<?php echo mysql_result($rs_cliente, 0, "id_cliente"); ?>" readonly>
                            </td>

                            <td width="6%"><b>FACTURERO:</b></td>
                            <td>
                                <select id="facturero" class="comboMedio" NAME="facturero"
                                        onchange="cambio_facturero()">
                                    <?php
                                    $contador = 0;
                                    while ($contador < mysql_num_rows($res_o)) {
                                        if (mysql_result($res_o, $contador, "id_facturero") == $idfacturero_seleccionado) {
                                            ?>
                                            <option selected
                                                    value="<?php echo mysql_result($res_o, $contador, "id_facturero") ?>"><?php echo mysql_result($res_o, $contador, "serie1") . '-' . mysql_result($res_o, $contador, "serie2") ?></option>


                                        <?php } else {
                                            if ($tipo == "administrador") {
                                                ?>
                                                <option
                                                    value="<?php echo mysql_result($res_o, $contador, "id_facturero") ?>"><?php echo mysql_result($res_o, $contador, "serie1") . '-' . mysql_result($res_o, $contador, "serie2") ?></option>
                                            <?php }
                                        }
                                        $contador++;
                                    } ?>
                                </select>

                            </td>


                        </tr>
                        <tr>

                            <td>CI/RUC</td>
                            <td colspan="3"><input NAME="ci_ruc" type="text" class="cajaMedia" id="ci_ruc" size="20"
                                                   maxlength="15"
                                                   value="<?php echo mysql_result($rs_cliente, 0, "ci_ruc"); ?>"
                                                   readonly>

                            </td>

                            <td rowspan="2"><b>FACTURA</b></td>
                            <td rowspan="2">
                                <input NAME="codfactura" type="text" class="cajaMinimaFactura" id="codfactura"
                                       value="<?php echo $maximo ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>Tipo Cliente</td>
                            <td>
                                <input NAME="tipo_cliente" type="text" class="cajaPequena" id="tipo_cliente" size="20"
                                       maxlength="15" value="<?php echo mysql_result($rs_tipocliente, 0, "nombre"); ?>"
                                       readonly>
                            </td>
                            <td>
                                Gu&iacute;a Remisi&oacute;n:
                            </td>
                            <td>
                                <select name="cboremision" id="cboremision" class="comboPequeno">
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                            </td>


                        </tr>


                        <tr>

                            <td width="15%" align="left">Fecha:</td>
                            <td width="43%">

                                <input type="text" id="fecha" name="fecha" value="<?php echo date("d/m/Y") ?>" readonly>
                            </td>


                            <td>CREDITO</td>
                            <td>
                                <select name="cbocredito" id="cbocredito" class="comboPequeno"
                                        onchange="activar_plazo(this.selectedIndex)">
                                    <option value="0" selected>No</option>
                                    <option value="1">Si</option>
                                    <option value="2"></option>
                                </select>

                                <select name="cboplazo" id="cboplazo" class="comboPequeno" readonly="true">
                                    <option value="0">0 d&iacute;as</option>
                                    <option value="1">30 d&iacute;as</option>
                                    <option value="2">60 d&iacute;as</option>
                                    <option value="3">90 d&iacute;as</option>
                                    <option value="4">120 d&iacute;as</option>
                                    <option value="5">150 d&iacute;as</option>
                                    <option value="6">180 d&iacute;as</option>
                                    <option value="7">210 d&iacute;as</option>
                                    <option value="8">240 d&iacute;as</option>
                                    <option value="9">270 d&iacute;as</option>
                                    <option value="10">300 d&iacute;as</option>
                                    <option value="11">330 d&iacute;as</option>
                                    <option value="12">360 d&iacute;as</option>
                                </select>

                            </td>


                        </tr>
                    </table>
            </div>

            <input NAME="serie1" type="hidden" id="serie1" value="<?php echo $serie1 ?>">
            <input NAME="serie2" type="hidden" id="serie2" value="<?php echo $serie2 ?>">
            <input NAME="autorizacion" type="hidden" id="autorizacion" value="<?php echo $autorizacion ?>">
            <input name="idfact" id="idfact" type="hidden" value="<?php echo $idfacturero_seleccionado ?>">
            <input id="codfacturatmp" name="codfacturatmp" value="<?php echo $codfacturatmp ?>" type="hidden">


            <br>


            <div id="frmBusqueda">
                <div id="advertencias">
                    <table style="width: 100%">
                        <tr>
                            <td style="width: 50%">
                                <table class="fuente8" style="width: 100%">
                                    <tr>
                                        <td style=" text-align: center; background-color: skyblue">DATOS RETENCION</td>

                                        <td style="width: 70%">
                                            <table class="fuente8" style="width: 100%">
                                                <tr>
                                                    <td style="width: 30%">
                                                        # Retenci&oacute;n
                                                    </td>
                                                    <td style="width: 70%">
                                                        <input type="text" class="cajaMediana" id="codigo_retencion"
                                                               name="codigo_retencion"/>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Ret. IVA:
                                                    </td>
                                                    <td>
                                                        <input type="text" id="ret_iva" name="ret_iva"
                                                               class="cajaPequena2" value="0"/>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Ret. Fuente:
                                                    </td>
                                                    <td>
                                                        <input type="text" id="ret_fuente" name="ret_fuente"
                                                               class="cajaPequena2" value="0"/>
                                                    </td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>

                            <td style="width: 50%">
                                <table style="background: #ff9999">
                                    <tr>
                                        <td>ADVERTENCIA! DEUDOR</td>

                                        <td><textarea id="facturasCadena" name="facturasCadena" cols="40" rows="3"
                                                      readonly="true"><?php echo $debe ?></textarea></td>
                                    </tr>
                                </table>
                            </td>


                            <td rowspan="2">
                                <b>TOTAL</b><br/>
                                <input class="cajaMinimaTotalFactura" name="preciototal_c" type="text"
                                       id="preciototal_c" size="12"
                                       align="right" value=0 readonly>
                            </td>
                        </tr>
                    </table>
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                        <tr>
                            <td style=" text-align: center; background-color: skyblue">
                                DESCUENTO GENERAL
                            </td>
                            <td>
                                <table class="fuente8" width="80%" cellspacing=0 cellpadding=3 border=0>
                                    <tr>
                                        <td>
                                            <input onchange="onChangeDescuento()" type="radio" name="tipo_precio"
                                                   id="tipo_precio" value="1">PVP A</br>

                                            <input onchange="onChangeDescuento()" type="radio" name="tipo_precio"
                                                   id="tipo_precio" value="2" checked>PVP B</br>
                                        </td>
                                        <td>
                                            <input onchange="onChangeDescuento()" type="radio" name="tipo_precio"
                                                   id="tipo_precio" value="3">PVP C</br>

                                            <input onchange="onChangeDescuento()" type="radio" name="tipo_precio"
                                                   id="tipo_precio" value="4">PVP D</br>
                                        </td>
                                    </tr>
                                </table>

                            </td>
                            <td style=" text-align: center; background-color: lightgreen">
                                FORMA DE PAGO
                            </td>
                            <td>
                                <table class="fuente8" width="80%" cellspacing=0 cellpadding=3 border=0>
                                    <tr>
                                        <td>
                                            <input onchange="onChangeDescuento()" type="radio" name="forma_pago"
                                                   id="forma_pago" value="1" checked>EFECTIVO</br>

                                            <input onchange="onChangeDescuento()" type="radio" name="forma_pago"
                                                   id="forma_pago" value="5">TARJETA DE
                                            CREDITO</br>
                                        </td>
                                        <td>
                                            <input onchange="onChangeDescuento()" type="radio" name="forma_pago"
                                                   id="forma_pago" value="100">OTROS</br>
                                        </td>
                                    </tr>
                                </table>
                            </td>


                        </tr>
                    </table>
                </div>
            </div>


            <br/>


            <div id="frmBusqueda">
                <!--	<form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas.php" target="frame_lineas">-->
                <div id="tituloForm" class="header">PRODUCTOS (doble click para editar)</div>


                <table border="0" class="tableDemo bordered" style="font-size: 10px">
                    <thead>
                    <tr class="ajaxTitle">
                        <th width="2%">#</th>
                        <th width="40%">Producto</th>
                        <th width="11%">Cantidad</th>
                        <th width="11%">Precio $ <label id="tipo_pvp"></label></th>
                        <th width="11%">Descuento</th>
                        <th width="11%">SubTotal &#36;</th>
                        <th width="11%">IVA <?php echo $ivaporcetaje ?>%</th>
                        <th width="10%">Action</th>
                    </tr>

                    </thead>
                    <?php
                    if (count($records)) {
                        //$i = 1;
                        $i = count($records);
                        foreach ($records as $key => $eachRecord) {
                            ?>
                            <tr id="<?php echo $eachRecord['numlinea']; ?>">
                                <td width="2%"><?php echo $i--; ?></td>
                                <td width="45%" class="fname"><?php echo $eachRecord['dproducto']; ?></td>
                                <td width="10%" class="lname"><?php echo $eachRecord['cantidad']; ?> </td>
                                <td width="10%" class="tech"><?php echo $eachRecord['precio']; ?></td>
                                <td width="10%" class="email"><?php echo $eachRecord['descuento']; ?></td>
                                <td width="10%" class="address"><?php echo $eachRecord['subtotal']; ?></td>
                                <td width="10%">

                                    <a href="javascript:;" id="<?php echo $eachRecord['id']; ?>" class="ajaxDelete"><img
                                            src=""
                                            class="dimage"></a>


                                </td>
                            </tr>
                        <?php }
                    }
                    ?>

                </table>
                <br/>

            </div>

            <input id="pvpa" name="pvpa" value="" type="hidden">
            <input id="pvpb" name="pvpb" value="" type="hidden">
            <input id="pvpc" name="pvpc" value="" type="hidden">
            <input id="pvpd" name="pvpd" value="" type="hidden">


            <div id="frmBusqueda">


                <table width="27%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">


                    <tr>
                        <td width="" class="busqueda">Subtotal</td>
                        <td width="" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="baseimponible" type="text" id="baseimponible" size="12"
                                       value=0 align="right" readonly>
                                &#36;</div>
                        </td>
                    </tr>

                    <tr>
                        <td width="" class="busqueda">Descuento
                            <!--<input class="cajaTotales" name="descuentomanual" type="text" id="descuentomanual" size="12" value=0 align="right" onchange="prorratear()"> =-->
                        </td>

                        <td width="" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="descuentototal" type="text" id="descuentototal"
                                       size="12" value=0 align="right" readonly>
                                &#36;</div>
                        </td>

                    </tr>

                    <tr>
                        <td width="" class="busqueda">IVA 0%</td>
                        <td width="" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="iva0" type="text" id="iva0" size="12" value=0
                                       align="right" readonly>
                                &#36;</div>
                        </td>
                    </tr>


                    <tr>
                        <td class="busqueda">IVA <?php echo $ivaporcetaje; ?>%</td>
                        <td align="right">
                            <div align="center">
                                <input class="cajaTotales" name="iva12" type="text" id="iva12" size="12" align="right"
                                       value=0 readonly>
                                &#36;</div>
                        </td>
                    </tr>

                    <tr>
                        <td width="" class="busqueda">Total IVA</td>
                        <td width="" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="importeiva" type="text" id="importeiva" size="12"
                                       value=0 align="right" readonly>
                                &#36;</div>
                        </td>
                    </tr>
                    <tr>
                        <td width="" class="busqueda">Flete</td>
                        <td width="" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="flete" type="text" id="flete" size="12" value=0
                                       align="right"
                                       onfocus="this.oldvalue = this.value;"
                                       onchange="sumarFlete(this);this.oldvalue = this.value;">
                                &#36;</div>
                        </td>
                    </tr>


                    <tr>
                        <td class="busqueda">Precio Total</td>
                        <td align="right">
                            <div align="center">
                                <input class="cajaTotales" name="preciototal" type="text" id="preciototal" size="12"
                                       align="right" value=0 readonly>
                                &#36;</div>
                        </td>
                    </tr>


                </table>
            </div>
            <table width="50%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
                <tr>
                    <td>
                        <div id="botonBusqueda">
                            <div align="center">
                                <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar_cabecera()"
                                     border="1" onMouseOver="style.cursor = cursor">
                                <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()"
                                     border="1" onMouseOver="style.cursor = cursor">


                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <!--<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
            <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
            </iframe>-->
            <input id="accion" name="accion" value="alta" type="hidden">
            </form>
        </div>
    </div>
</div>
</body>
</html>
