<?php
include("../js/fechas.php");
include("../conexion/conexion.php");

//get datos SESSION
session_start();
$id_bodega = $_SESSION['id_bodega'];
//*********************************************************************


$idruc = 1;

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

//porcentaje iva parametrizable*****************************************
$sel_iva = "select porcentaje FROM iva where activo=1 AND borrado=0";
$rs_iva = mysql_query($sel_iva, $conn);
$ivaporcetaje = mysql_result($rs_iva, 0, "porcentaje");
//**********************************************************************


//error_reporting(0);

$idfactura = $_REQUEST["idfactura"];

$query = "SELECT *, DATE_ADD(fecha,INTERVAL (plazo*30) DAY) as fecha_venc FROM facturas WHERE id_factura='$idfactura'";
$rs_query = mysql_query($query, $conn);

$idfactura = mysql_result($rs_query, 0, "id_factura");

$codfactura = mysql_result($rs_query, 0, "codigo_factura");
$serie1 = mysql_result($rs_query, 0, "serie1");
$serie2 = mysql_result($rs_query, 0, "serie2");
$autorizacion = mysql_result($rs_query, 0, "autorizacion");
$idcliente = mysql_result($rs_query, 0, "id_cliente");
$fecha = mysql_result($rs_query, 0, "fecha");
$fecha_venc = mysql_result($rs_query, 0, "fecha_venc");
$credito = mysql_result($rs_query, 0, "credito");
$plazo = mysql_result($rs_query, 0, "plazo");
$remision = mysql_result($rs_query, 0, "remision");

$codigo_retencion = mysql_result($rs_query, 0, "codigo_retencion");
$ret_iva = mysql_result($rs_query, 0, "ret_iva");
$ret_fuente = mysql_result($rs_query, 0, "ret_fuente");


$descuento = mysql_result($rs_query, 0, "descuento");
$iva0 = mysql_result($rs_query, 0, "iva0");
$iva12 = mysql_result($rs_query, 0, "iva12");
$importeiva = mysql_result($rs_query, 0, "iva");
$flete = mysql_result($rs_query, 0, "flete");
$totalfactura = mysql_result($rs_query, 0, "totalfactura");
$baseimponible = $totalfactura - $flete - $importeiva + $descuento;

$idfacturero = mysql_result($rs_query, 0, "id_facturero");


//datos factureros existentes
$query_o = "SELECT * FROM facturero WHERE id_facturero= $idfacturero";
$res_o = mysql_query($query_o, $conn);


//lista de productos de la factura
$sel_lineas = "SELECT a.id_bodega as idbodega,  a.id_factulinea as id_factulinea, a.id_producto as id_producto, b.stock as stock, b.costo as costo, b.codigo as codigo, b.nombre as nombre, b.transformacion as transformacion, a.cantidad as cantidad, a.precio as precio, a.subtotal as subtotal, a.dcto as dcto, a.iva as iva 
    FROM factulinea a INNER JOIN producto b ON a.id_producto=b.id_producto 
    WHERE a.id_factura = '$idfactura'";
$rs_lineas = mysql_query($sel_lineas, $conn);

//AJAX data table edit ********************
require_once("ajax_table.class_modificar.php");
$obj = new ajax_table();
$records = $obj->getRecords($idfactura);
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
        $( function() {
            $( "#fecha" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'dd/mm/yy',
                showOn: "button",
                buttonImage: "../img/calendario.png",
                buttonImageOnly: true,
                buttonText: "Seleccionar Fecha"

            });

        } );


    </script>
    <!-- FIN ARCHIVOS CALENDARIO -->
    <script language="javascript">
        var cursor;
        if (document.all) {
            // Está utilizando EXPLORER
            cursor = 'hand';
        } else {
            // Está utilizando MOZILLA/NETSCAPE
            cursor = 'pointer';
        }

        function inicio(aceptacion, mensaje) {
            if (aceptacion == 0) {
                alert(mensaje);
                location.href = "index.php";
            }
        }

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

    </script>


    <!-- INICIO AJAX EDIT DATA TABLE -->
    <script>
        // Column names must be identical to the actual column names in the database, if you dont want to reveal the column names, you can map them with the different names at the server side.


        localStorage.setItem('codtmp', <?php echo $idfactura;?>);
        localStorage.setItem('id_bodega',<?php echo $id_bodega;?>);
        localStorage.setItem('iva_porcentaje',<?php echo $ivaporcetaje;?>);

        localStorage.setItem('descuento', '1');
        localStorage.setItem('total_records', '0');

        var columns = new Array("dproducto", "cantidad", "precio", "dcto", "subtotal", "iva", "id_bodega", "id_factura", "id_producto", "costo");
        var columns_edit = new Array("cantidad", "precio", "dcto", "subtotal", "iva");
        var columns_totales = new Array("baseimponible", "iva0", "iva12", "importeiva", "descuentototal", "preciototal");
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
    <script src="js/script_modificar.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <!-- FIN  AJAX EDIT DATA TABLE -->

</head>
<body>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header">MODIFICAR FACTURA VENTA</div>
            <div id="frmBusqueda">
                <form id="formulario" name="formulario" method="post" action="guardar_factura.php">
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                        <!--                                                <tr>
                                        <td width="6%">No. Factura</td>
                                        <td width="35%">                                                       
                                            <input NAME="codfactura" type="text" class="cajaPequena" id="codfactura" value="<?php echo $maximo ?>" readonly>
                                        </td>                                                    
                                    </tr>-->
                        <?php
                        $sel_cliente = "SELECT * FROM cliente WHERE id_cliente='$idcliente'";
                        $rs_cliente = mysql_query($sel_cliente, $conn);
                        ?>
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
                                                   size="6" maxlength="5" value="<?php echo $idcliente ?>" readonly>
                            </td>

                            <td width="6%"><b>FACTURERO:</b></td>
                            <td>
                                <select id="facturero" class="comboMedio" NAME="facturero">
                                    <?php
                                    $contador = 0;
                                    while ($contador < mysql_num_rows($res_o)) {
                                        if (mysql_result($res_o, $contador, "id_facturero") == $idfacturero) {
                                            ?>
                                            <option selected
                                                    value="<?php echo mysql_result($res_o, $contador, "id_facturero") ?>"><?php echo mysql_result($res_o, $contador, "serie1") . '-' . mysql_result($res_o, $contador, "serie2") ?></option>


                                        <?php } else { ?>
                                            <option
                                                value="<?php echo mysql_result($res_o, $contador, "id_facturero") ?>"><?php echo mysql_result($res_o, $contador, "serie1") . '-' . mysql_result($res_o, $contador, "serie2") ?></option>
                                        <?php }
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
                                                   readonly></td>

                            <td rowspan="2">FACTURA</td>
                            <td rowspan="2">
                                <input NAME="codfactura" type="text" class="cajaMinimaFactura" id="codfactura"
                                       value="<?php echo $codfactura; ?>">
                            </td>
                        </tr>
                        <tr>
                            <?php
                            $codtipo = mysql_result($rs_cliente, 0, "codigo_tipocliente");
                            $sel_tipocliente = "SELECT nombre FROM tipo_cliente WHERE codigo_tipocliente='$codtipo'";
                            $rs_tipocliente = mysql_query($sel_tipocliente, $conn);

                            ?>
                            <td>Tipo Cliente</td>
                            <td>
                                <input NAME="tipo_cliente" type="text" class="cajaPequena" id="tipo_cliente" size="20"
                                       maxlength="15" value="<?php echo mysql_result($rs_tipocliente, 0, "nombre"); ?>"
                                       readonly>
                            </td>
                            <td>Guia Remisi&oacute;n:</td>
                            <td>
                                <?php if ($remision == 0) { ?>
                                    <select name="cboremision" id="cboremision" class="comboPequeno">
                                        <option selected value="0">No</option>
                                        <option value="1">Si</option>
                                    </select>
                                <?php } else { ?>
                                    <select name="cboremision" id="cboremision" class="comboPequeno">
                                        <option value="0">No</option>
                                        <option selected value="1">Si</option>
                                    </select>
                                <?php } ?>
                            </td>
                        </tr>


                        <tr>
                            <td width="15%" align="left">Fecha:</td>
                            <td width="43%"><input type="text" id="fecha" name="fecha" value="<?php echo implota($fecha) ?>" readonly></td>


                            <td>CREDITO</td>
                            <td>
                                <?php if ($credito == 0) { ?>
                                    <!--<select name="cbocredito" id="cbocredito" class="comboPequeno" onchange="activar_plazo(this.selectedIndex)">
                                        <option selected value="0">No</option>
                                        <option value="1">Si</option>

                                    </select>-->
                                    <b>No</b> ---
                                <?php } else { ?>
                                    <!--<select name="cbocredito" id="cbocredito" class="comboPequeno" onchange="activar_plazo(this.selectedIndex)">
                                        <option value="0">No</option>
                                        <option selected value="1">Si</option>

                                    </select>-->
                                    <b>Si</b> ---
                                <?php } ?>
                                Fech. Venc.: <?php echo implota($fecha_venc) ?>
                                <!--
                                <select name="cboplazo" id="cboplazo" class="comboPequeno" disabled="true">
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
                                -->
                            </td>


                        </tr>
                    </table>
            </div>
            <input name="cbocredito" type="hidden" id="cbocredito" value="<?php echo $credito ?>">
            <input NAME="serie1" type="hidden" id="serie1" value="<?php echo $serie1 ?>">
            <input NAME="serie2" type="hidden" id="serie2" value="<?php echo $serie2 ?>">
            <input NAME="autorizacion" type="hidden" id="autorizacion" value="<?php echo $autorizacion ?>">
            <input NAME="idfactura" type="hidden" id="idfactura" value="<?php echo $idfactura; ?>">
            <!--

            <input id="accion" name="accion" value="alta" type="hidden">-->
            <!-- </form>-->

            <div id="frmBusqueda">
                <div id="advertencias">
                    <table class="fuente8">
                        <tr>
                            <td style="width: 40%; text-align: center; background-color: skyblue">DATOS RETENCION</td>

                            <td style="width: 60%">
                                <table class="fuente8">
                                    <tr>
                                        <td>
                                            C&oacute;digo Retenci&oacute;n
                                        </td>
                                        <td>
                                            <input type="text" class="cajaGrande" id="codigo_retencion"
                                                   name="codigo_retencion" value="<?php echo $codigo_retencion ?>"/>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Valor Retenci&oacute;n IVA:
                                        </td>
                                        <td>
                                            <input type="text" id="ret_iva" name="ret_iva" class="cajaPequena"
                                                   value="<?php echo $ret_iva ?>"/>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Valor Retenci&oacute;n Fuente:
                                        </td>
                                        <td>
                                            <input type="text" id="ret_fuente" name="ret_fuente" class="cajaPequena"
                                                   value="<?php echo $ret_fuente ?>"/>
                                        </td>
                                    </tr>

                                </table>
                            </td>


                            <td style="width: 50%">
                                <table style="background: #ff9999">
                                    <tr>
                                        <td>ADVERTENCIA! DEUDOR</td>

                                        <td><textarea id="facturasCadena" name="facturasCadena" cols="40" rows="3"
                                                      readonly="true"></textarea></td>
                                    </tr>
                                </table>
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
                                                   id="tipo_precio" value="1" checked>PVP A</br>

                                            <input onchange="onChangeDescuento()" type="radio" name="tipo_precio"
                                                   id="tipo_precio" value="2">PVP B</br>
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
                                            <input type="radio" name="forma_pago" id="forma_pago" value="1" checked>EFECTIVO</br>

                                            <input type="radio" name="forma_pago" id="forma_pago" value="2">CHEQUE</br>
                                        </td>
                                        <td>
                                            <input type="radio" name="forma_pago" id="forma_pago" value="5">TARJETA DE
                                            CREDITO</br>

                                            <input type="radio" name="forma_pago" id="forma_pago" value="6">DINERO
                                            ELECTRONICO</br>
                                        </td>
                                    </tr>
                                </table>
                            </td>

                        </tr>
                    </table>
                </div>
            </div>


            <br>
            <div id="frmBusqueda">
                <!--	<form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas.php" target="frame_lineas">-->
                <div id="tituloForm" class="header">PRODUCTOS</div>

                <table border="0" class="tableDemo bordered" style="font-size: 10px">
                    <thead>
                    <tr class="ajaxTitle">
                        <th width="2%">#</th>
                        <th width="40%">Producto</th>
                        <th width="11%">Cantidad</th>
                        <th width="11%">Precio $</th>
                        <th width="11%">Descuento</th>
                        <th width="11%">SubTotal &#36;</th>
                        <th width="11%">IVA <?php echo $ivaporcetaje ?>%</th>
                        <th width="10%">Action</th>
                    </tr>

                    </thead>
                    <?php
                    if (count($records)) {

                        foreach ($records as $key => $eachRecord) {
                            ?>
                            <tr id="<?php echo $eachRecord['id_factulinea']; ?>">
                                <td width="2%"></td>
                                <td width="45%" class="dproducto"><?php echo $eachRecord['dproducto']; ?></td>
                                <td width="10%" class="cantidad"><?php echo $eachRecord['cantidad']; ?> </td>
                                <td width="10%" class="precio"><?php echo $eachRecord['precio']; ?></td>
                                <td width="10%" class="dcto"><?php echo $eachRecord['dcto']; ?></td>
                                <td width="10%" class="subtotal"><?php echo $eachRecord['subtotal']; ?></td>
                                <td width="10%" class="iva"><?php echo $eachRecord['iva']; ?></td>
                                <td width="10%">
                                    <a href="javascript:;" id="<?php echo $eachRecord['id_factulinea']; ?>"
                                       class="ajaxDelete"><img
                                            src="" class="dimage"></a>
                                </td>

                            </tr>
                        <?php }
                    }
                    ?>

                </table>


                <br/>

            </div>

            <div id="frmBusqueda">
                <table width="27%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
                    <tr>
                        <td width="" class="busqueda">Subtotal</td>
                        <td width="" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="baseimponible" type="text" id="baseimponible"
                                       value="<?php echo number_format($baseimponible, 2); ?>" size="12" value=0
                                       align="right" readonly>
                                &#36;</div>
                        </td>
                    </tr>

                    <tr>
                        <td width="" class="busqueda">Descuento
                        </td>

                        <td width="" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="descuentototal" type="text" id="descuentototal"
                                       value="<?php echo number_format($descuento, 2); ?>" size="12" value=0
                                       align="right" readonly>
                                &#36;</div>
                        </td>

                    </tr>

                    <tr>
                        <td width="" class="busqueda">IVA 0%</td>
                        <td width="" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="iva0" type="text" id="iva0"
                                       value="<?php echo number_format($iva0, 2); ?>" size="12" value=0 align="right"
                                       readonly>
                                &#36;</div>
                        </td>
                    </tr>


                    <tr>
                        <td class="busqueda">IVA 12%</td>
                        <td align="right">
                            <div align="center">
                                <input class="cajaTotales" name="iva12" type="text" id="iva12"
                                       value="<?php echo number_format($iva12, 2); ?>" size="12" align="right" value=0
                                       readonly>
                                &#36;</div>
                        </td>
                    </tr>

                    <tr>
                        <td width="" class="busqueda">Total IVA</td>
                        <td width="" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="importeiva" type="text" id="importeiva"
                                       value="<?php echo number_format($importeiva, 2); ?>" size="12" value=0
                                       align="right" readonly>
                                &#36;</div>
                        </td>
                    </tr>
                    <tr>
                        <td width="" class="busqueda">Flete</td>
                        <td width="" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="flete" type="text" id="flete"
                                       value="<?php echo $flete ?>" size="12" value=0 align="right"
                                       onchange="sumar_flete()">
                                &#36;</div>
                        </td>
                    </tr>


                    <tr>
                        <td class="busqueda">Precio Total</td>
                        <td align="right">
                            <div align="center">
                                <input class="cajaTotales" name="preciototal" type="text" id="preciototal"
                                       value="<?php echo $totalfactura ?>" size="12" align="right" value=0 readonly>
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
            <input id="accion" name="accion" value="modificar" type="hidden">
            </form>
        </div>
    </div>
</div>
</body>
</html>