<?php
error_reporting(0);
include("../conexion/conexion.php");

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

//porcentaje iva parametrizable*****************************************
$sel_iva = "select porcentaje FROM iva where activo=1 AND borrado=0";
$rs_iva = mysql_query($sel_iva, $conn);
$ivaporcetaje = mysql_result($rs_iva, 0, "porcentaje");
//**********************************************************************

$fechahoy = date("Y-m-d");
$sel_fact = "INSERT INTO facturasptmp (codfactura,fecha) VALUE (null,'$fechahoy')";
$rs_fact = mysql_query($sel_fact, $conn);
$codfacturatmp = mysql_insert_id();

$query = "DELETE FROM factulineaptmp WHERE codfactura='$codfacturatmp'";
$rs = mysql_query($query, $conn);

//get datos SESSION***************************************************
session_start();
$id_bodega = $_SESSION['id_bodega'];
$tipo = $_SESSION['tipo'];

//SERIE OBLIGATORIO***************************************************
$sel_obli = "select serie_unica FROM param_item where  borrado=0";
$rs_obli = mysql_query($sel_obli, $conn);
$obligatorio_serie = mysql_result($rs_obli, 0, "serie_unica");

?>
<html>
<head>
    <title>Principal</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
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

            $( "#fecha_caducidad" ).datepicker({
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
        var obligatorio_serie = <?php echo $obligatorio_serie;?>;

        var cursor;
        if (document.all) {
            // Está utilizando EXPLORER
            cursor = 'hand';
        } else {
            // Está utilizando MOZILLA/NETSCAPE
            cursor = 'pointer';
        }

        var miPopup;
        function abreVentana() {
            var codfactura = document.getElementById("codfactura").value;
            var serie1 = document.getElementById("serie1").value;
            var serie2 = document.getElementById("serie2").value;

            if ((codfactura == "") || (serie1 == "") || (serie2 == "") ) {
                alert("Debe ingresar el No.  de la FACTURA");
            }
            else {
                miPopup = window.open("ver_proveedores.php", "miwin", "width=880,height=650,scrollbars=yes");
                miPopup.focus();
            }
        }

        function ventanaArticulos() {
//			var codigo=document.getElementById("codproveedor").value;
//			if (codigo=="") {
//				alert ("Debe seleccionar el proveedor");
//			} else {
            miPopup = window.open("ver_articulos.php", "miwin", "width=700,height=580,scrollbars=yes");
            miPopup.focus();
//			}
        }

        function validarcliente() {
            var codigo = document.getElementById("codproveedor").value;
            miPopup = window.open("comprobarcliente.php?codproveedor=" + codigo, "frame_datos", "width=700,height=80,scrollbars=yes");
        }

        function cancelar() {
            location.href = "index.php";
        }

        function limpiarcaja() {
            document.getElementById("codproveedor").value = "";
            document.getElementById("nombre").value = "";
            document.getElementById("nif").value = "";
        }

        function actualizar_importe() {
            var precio = document.getElementById("precio").value;
            var cantidad = document.getElementById("cantidad").value;
            var descuento_porc = document.getElementById("descuento_porc").value;

            var total = precio * cantidad;
            var descuento = total * (descuento_porc / 100);

            var originaldesc = parseFloat(descuento);
            var resultdesc = Math.round(originaldesc * 10000) / 10000;
            document.getElementById("descuento").value = resultdesc;


            var original = parseFloat(total - descuento);
            var result = Math.round(original * 10000) / 10000;
            document.getElementById("importe").value = result;

            suma_iva();
        }

        var credit = 0;

        function validar_cabecera() {
            var mensaje = "";
            if (document.getElementById("codfactura").value == "") mensaje += "  - No. Factura no ingresado\n";
            if (document.getElementById("serie1").value == "") mensaje += "  - Datos No. Factura no ingresado\n";
            if (document.getElementById("serie2").value == "") mensaje += "  - Datos No. Factura no ingresado\n";
            if (document.getElementById("autorizacion").value == "") mensaje += "  - Autorizacion Factura no ingresado\n";
            if (document.getElementById("nombre").value == "") mensaje += "  - Cliente no ingresado\n";
            if (document.getElementById("fecha").value == "") mensaje += "  - Fecha\n";
            //if (credit =="0") mensaje+="  - Credito no seleccionado\n";
            if (document.getElementById("cbocredito").value == "2") mensaje += "  - Credito no seleccionado\n";
            if (document.getElementById("cboretencion").value == "2") mensaje += "  - Retencion no seleccionado\n";


            if (mensaje != "") {
                alert("Atencion, se han detectado las siguientes incorrecciones:\n\n" + mensaje);
            } else {
                document.getElementById("formulario").submit();
            }
        }

        function validar() {
            var mensaje = "";
            var enteroo = 0;

            if (document.getElementById("codarticulo").value == "") mensaje = "  - Codigo Producto\n";
            if (document.getElementById("descripcion").value == "") mensaje += "  - Descripcion Producto\n";
            if (document.getElementById("cbobodega").value == 0) mensaje += "  - Bodega\n";
            if (document.getElementById("precio").value == "0") {
                mensaje += "  - Falta el Costo\n";
            } else {
                if (isNaN(document.getElementById("precio").value) == true) {
                    mensaje += "  - El Costo debe ser numerico\n";
                }
            }

            if (document.getElementById("cantidad").value == "") {
                mensaje += "  - Falta la cantidad\n";
            } else {
                enteroo = parseInt(document.getElementById("cantidad").value);
                if (isNaN(enteroo) == true) {
                    mensaje += "  - La cantidad debe ser numerica\n";
                } else {
                    document.getElementById("cantidad").value = enteroo;
                }
            }
//
            if (document.getElementById("importe").value == "") mensaje += "  - Falta el importe\n";

            if (obligatorio_serie == 1)
            {
                var theSelect = document.getElementById('series');
                var options = theSelect.getElementsByTagName('OPTION');
                var numProducto = document.getElementById("cantidad").value;
                var numSeries = options.length;

                if (numProducto != numSeries) {
                    mensaje += "  - Cantidad de producto, no concuerda con cantidad Series ingresadas\n";
                }
            }

            if (mensaje != "") {
                alert("Atencion, se han detectado las siguientes incorrecciones:\n\n" + mensaje);
            } else {
                document.getElementById("baseimponible").value = parseFloat(document.getElementById("baseimponible").value) + parseFloat(document.getElementById("importe").value)
                    + parseFloat(document.getElementById("descuento").value);
                var original1 = parseFloat(document.getElementById("baseimponible").value);
                var result1 = Math.round(original1 * 10000) / 10000;
                document.getElementById("baseimponible").value = result1;

                actualizar_totales();

                if (obligatorio_serie == 1)
                {
                    var theSelect1 = document.getElementById('series');
                    var options1 = theSelect1.getElementsByTagName('OPTION');
                    var numSeries1 = options1.length;
                    for (var i = 0; i < numSeries1; i++) {
                        options1[i].selected = true;
                    }
                }

                document.getElementById("formulario_lineas").submit();
                document.getElementById("codarticulo").value = "";
                document.getElementById("descripcion").value = "";
                document.getElementById("precio").value = "0";
                document.getElementById("cantidad").value = 1;
                document.getElementById("importe").value = "";
                document.getElementById("descuento_porc").value = 0;
                document.getElementById("descuento").value = 0;
                document.getElementById("iva").value = "0";
                document.getElementById("pvp").value = "0";
                document.getElementById("pvpb").value = "0";
                document.getElementById("pvpc").value = "0";
                document.getElementById("pvpd").value = "0";
                document.getElementById("lector").value = "";
                if (obligatorio_serie == 1
            )
                {
                    var theSelect = document.getElementById('series');
                    theSelect.innerHTML = "";
                }
            }
        }


        function actualizar_totales() {
            document.getElementById("descuentototal").value = parseFloat(document.getElementById("descuentototal").value) + parseFloat(document.getElementById("descuento").value);
            var original1 = parseFloat(document.getElementById("descuentototal").value);
            var result1 = Math.round(original1 * 10000) / 10000;
            document.getElementById("descuentototal").value = result1;
            document.getElementById("descuentototal2").value = result1;


            document.getElementById("iva0").value = parseFloat(document.getElementById("iva0").value) + parseFloat(document.getElementById("iva02").value);
            var original2 = parseFloat(document.getElementById("iva0").value);
            var result2 = Math.round(original2 * 10000) / 10000;
            document.getElementById("iva0").value = result2;
            document.getElementById("iva0final").value = result2;
            document.getElementById("iva02").value = 0;


            document.getElementById("iva12").value = parseFloat(document.getElementById("iva12").value) + parseFloat(document.getElementById("iva122").value);
            var original3 = parseFloat(document.getElementById("iva12").value);
            var result3 = Math.round(original3 * 10000) / 10000;
            document.getElementById("iva12").value = result3;
            document.getElementById("iva12final").value = result3;
            document.getElementById("iva122").value = 0;


            document.getElementById("importeiva").value = parseFloat(document.getElementById("importeiva").value) + parseFloat(document.getElementById("iva").value);
            var original4 = parseFloat(document.getElementById("importeiva").value);
            var result4 = Math.round(original4 * 10000) / 10000;
            document.getElementById("importeiva").value = result4;
            document.getElementById("importeiva2").value = result4;


            var original5 = parseFloat(document.getElementById("flete").value);
            var result5 = Math.round(original5 * 10000) / 10000;
            document.getElementById("flete2").value = result5;

            var original6 = parseFloat(document.getElementById("baseimponible").value);
            var result6 = Math.round(original6 * 10000) / 10000;
            document.getElementById("baseimponible2").value = result6;


            document.getElementById("preciototal").value = result6 - result1 + result4 + result5;
            var original7 = parseFloat(document.getElementById("preciototal").value);
            var result7 = Math.round(original7 * 100) / 100;
            document.getElementById("preciototal").value = result7;
            document.getElementById("preciototal2").value = result7;
        }


        function suma_iva() {
            var original = parseFloat(document.getElementById("importe").value);
            var result = Math.round(original * 10000) / 10000;
            document.getElementById("importe").value = result;

            document.getElementById("iva").value = parseFloat(result * parseFloat(document.getElementById("ivaporc").value / 100));
            var original1 = parseFloat(document.getElementById("iva").value);
            var result1 = Math.round(original1 * 10000) / 10000;
            document.getElementById("iva").value = result1;

            if (result1 == 0) {
                document.getElementById("iva02").value = result;
            }
            else {
                document.getElementById("iva122").value = result;
            }


            //var original2=parseFloat(result + result1);
            //var result2=Math.round(original2*10000)/10000 ;
            //document.getElementById("importe").value=result2;
        }


        function actualizar_descuento() {
            var original = parseFloat(document.getElementById("importe").value);
            var result = Math.round(original * 10000) / 10000;

            document.getElementById("descuento").value = parseFloat(result * parseFloat(document.getElementById("descuentoporc").value / 100));
            var original1 = parseFloat(document.getElementById("descuento").value);
            var result1 = Math.round(original1 * 10000) / 10000;
            document.getElementById("descuento").value = result1;
            suma_iva();
        }

        function activar_plazo(indice) {
            with (document.formulario) {
                value = cbocredito.options[indice].value;
                switch (value) {
                    case "0":
                        credit = 1;
                        cboplazo.selectedIndex = 0;
                        cboplazo.readonly = true;
                        break;
                    case "2":
                        credit = 0;
                        cboplazo.selectedIndex = 0;
                        cboplazo.readonly = true;
                        break;
                    default:
                        credit = 1;
                        cboplazo.readonly = false;
                        cboplazo.selectedIndex = 1;
                        break;
                }
            }
        }

        function sumar_flete() {
            var original = parseFloat(document.getElementById("flete").value);
            if (isNaN(original) == true) {

                alert("Atencion, el valor del Flete debe ser numerico");
                document.getElementById("flete").value = 0;
                actualizar_totales();
            } else {
                var result = Math.round(original * 10000) / 10000;
                document.getElementById("flete").value = result;

                actualizar_totales();
            }


        }

        function restar_descuento() {
            var original = parseFloat(document.getElementById("descuentototal").value);
            if (isNaN(original) == true) {

                alert("Atencion, el valor del Descuento debe ser numerico");
                document.getElementById("descuentototal").value = 0;
                actualizar_totales();
            } else {
                var result = Math.round(original * 10000) / 10000;
                document.getElementById("descuentototal").value = result;

                actualizar_totales();
            }
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

        function AddItem() {

            var Text = document.getElementById("serieaux").value;
            //var Text = encodeURIComponent(document.getElementById("serieaux").value);
            if (Text != "") {
                // Create an Option object
                var opt = document.createElement("option");
                // Add an Option object to Drop Down/List Box
                document.getElementById("series").options.add(opt);
                // Assign text and value to Option object
                opt.text = (Text);
                opt.value = Text;
                document.getElementById("serieaux").value = "";
            }

            var theSelect = document.getElementById('series');
            var options = theSelect.getElementsByTagName('OPTION');
            var numSeries = options.length;
            for (var i = 0; i < numSeries; i++) {
                options[i].selected = true;
            }

        }

        function DeleteItem() {


            var theSelect = document.getElementById('series');

            var item = theSelect.options[theSelect.selectedIndex].value;
            var options = theSelect.getElementsByTagName('OPTION');
            for (var i = 0; i < options.length; i++) {
                if (options[i].innerHTML == item) {
                    theSelect.removeChild(options[i]);
                    i--; // options have now less element, then decrease i
                }
                options[i].selected = true;
            }


        }


        function limpiarLector(){
            document.getElementById("lector").value="";
        }

        function handleKeyPress(e){
            var key=e.keyCode || e.which;
            if ((key==13)){
                document.getElementById("lector").blur();
            }
        }

    </script>
</head>
<body>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header">INSERTAR FACTURA COMPRA <?php echo $fechahoy; ?></div>
            <div id="frmBusqueda">
                <form id="formulario" name="formulario" method="post" action="guardar_factura.php">
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                        <tr>
                            <td width="6%">No. Factura</td>

                            <td>
                                <input NAME="serie1" type="text" class="cajaMinima" id="serie1" maxlength="3">
                                <input NAME="serie2" type="text" class="cajaMinima" id="serie2" maxlength="3">
                                <input NAME="codfactura" type="text" class="cajaMedia" id="codfactura" maxlength="16">

                            </td>
                            <td width="6%">Autorizaci&oacute;n</td>
                            <td colspan="2">
                                <input NAME="autorizacion" type="text" class="cajaMedia" id="autorizacion"
                                       maxlength="12">
                                <input type="text" name="fecha_caducidad" id="fecha_caducidad" class="cajaPequena" readonly>
                            </td>


                        </tr>
                        <tr>
                            <td width="6%">Proveedor</td>
                            <td width="35%"><input NAME="nombre" type="text" class="cajaGrande" id="nombre" size="45"
                                                   maxlength="45" onClick="abreVentana()" readonly>
                                <img src="../img/ver.png" width="16" height="16" onClick="abreVentana()"
                                     title="Buscar cliente" onMouseOver="style.cursor=cursor"></td>

                            <td width="3%">CI/RUC</td>
                            <td colspan="2"><input NAME="ci_ruc" type="text" class="cajaMedia" id="ci_ruc" size="20"
                                                   maxlength="15" readonly></td>

                        </tr>
                        <tr>
                            <td width="6%">Cod. Proveedor</td>
                            <td><input NAME="codproveedor" type="text" class="cajaPequena" id="codproveedor" size="6"
                                       maxlength="5" readonly></td>
                            <td width="6%">Tipo Comprobante</td>
                            <td>
                                <select name="cbotipocomprobante" id="cbotipocomprobante" class="comboMedio">
                                    <option value="1">Factura</option>
                                    <option value="2">Liquidaciones de Compra</option>
                                    <option value="3">Nota de Venta</option>
                                </select>
                            </td>
                            <td>CUENTA:
                                <select name="cbocuenta" id="cbocuenta" class="comboMedio">
                                    <?php
                                    $query_cuenta = "SELECT id_cuenta, nombre FROM cuenta WHERE gasto=0";
                                    $sel_query = mysql_query($query_cuenta, $conn);
                                    while ($row = mysql_fetch_array($sel_query)) {

                                        ?>
                                        <option
                                            value="<?php echo $row['id_cuenta'] ?>"><?php echo $row['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td width="6%">Fecha</td>
                            <td width="27%">
                                <input type="text" id="fecha" name="fecha" value="<?php echo date("d/m/Y") ?>"  readonly>
                            </td>


                            <td width="6%">CREDITO</td>
                            <td>
                                <select name="cbocredito" id="cbocredito" class="comboPequeno"
                                        onchange="activar_plazo(this.selectedIndex)">
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                    <option value="2" selected></option>
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

                            <td>SUJETA A RETENCION:
                                <select name="cboretencion" id="cboretencion" class="comboPequeno">
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                    <option value="2" selected></option>
                                </select>
                            </td>
                            
                        </tr>
                    </table>
            </div>
            <!--<input id="codfacturatmp" name="codfacturatmp" value="<?php echo $codfacturatmp ?>" type="hidden">
			  <input id="baseimpuestos2" name="baseimpuestos2" value="<?php echo $baseimpuestos ?>" type="hidden">
			  <input id="baseimponible2" name="baseimponible2" value="<?php echo $baseimponible ?>" type="hidden">
			  <input id="preciototal2" name="preciototal2" value="<?php echo $preciototal ?>" type="hidden">
                          <input id="baseretencion2" name="baseretencion2" value="<?php echo $baseretencion ?>" type="hidden">-->
            <input id="codfacturatmp" name="codfacturatmp" value="<?php echo $codfacturatmp ?>" type="hidden">
            <input id="iva02" name="iva02" value="0" type="hidden">
            <input id="iva122" name="iva122" value="0" type="hidden">
            <input id="iva0final" name="iva0final" value="0" type="hidden">
            <input id="iva12final" name="iva12final" value="0" type="hidden">
            <input id="descuentototal2" name="descuentototal2" value="0" type="hidden">
            <input id="importeiva2" name="importeiva2" value="0" type="hidden">
            <input id="baseimponible2" name="baseimponible2" value="0" type="hidden">
            <input id="flete2" name="flete2" value="0" type="hidden">
            <input id="preciototal2" name="preciototal2" value="0" type="hidden">

            <input id="accion" name="accion" value="alta" type="hidden">
            </form>
            <br>
            <div id="frmBusqueda">
                <form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas.php"
                      target="frame_lineas">
                    <div id="tituloForm" class="header">PRODUCTOS</div>
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>

                        <tr>
                            <td colspan="6">
                                <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                    <tr>
                                        <td>C&oacute;digo Producto</td>
                                        <td><input NAME="codarticulo" type="text" class="cajaMedia" id="codarticulo"
                                                   size="15" maxlength="15" onClick="ventanaArticulos()" readonly> <img
                                                src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos()"
                                                onMouseOver="style.cursor=cursor" title="Buscar articulos"></td>
                                        <td>Descripci&oacute;n</td>
                                        <td><input NAME="descripcion" type="text" class="cajaGrande" id="descripcion"
                                                   size="30" maxlength="30" readonly></td>
                                        <td>Bodega</td>
                                        <td>
                                            <?php

                                            $queryb = "SELECT b.id_bodega as idbodega, b.nombre as nombre FROM bodega b  WHERE b.id_bodega ='$id_bodega'";
                                            $resb = mysql_query($queryb, $conn); ?>

                                            <select name="cbobodega" id="cbobodega" class="comboMedio">

                                                <?php

                                                $contador = 0;
                                                while ($contador < mysql_num_rows($resb)) {
                                                    if (mysql_result($resb, $contador, "idbodega") == $bodega1) {
                                                        ?>
                                                        <option selected
                                                                value="<?php echo mysql_result($resb, $contador, "idbodega") ?>"><?php echo mysql_result($resb, $contador, "nombre"); ?></option>

                                                    <?php } else { ?>
                                                        <option
                                                            value="<?php echo mysql_result($resb, $contador, "idbodega") ?>"><?php echo mysql_result($resb, $contador, "nombre"); ?></option>
                                                    <?php }
                                                    $contador++;
                                                } ?>


                                            </select>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>

                            <td>
                                Costo: <input NAME="precio" type="text" class="cajaPequena2" id="precio" size="10"
                                              maxlength="10" onChange="actualizar_importe()" value="0"> &#36;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cantidad: <input
                                    NAME="cantidad" type="text" class="cajaMinima" id="cantidad" size="10"
                                    maxlength="10" value="1" onChange="actualizar_importe()">
                            </td>
                            <td>
                                Dcto.: <input NAME="descuento_porc" type="text" class="cajaMinima" id="descuento_porc"
                                              size="10" maxlength="10" onChange="actualizar_importe()" value="0"> %
                                <input NAME="descuento" type="text" class="cajaPequena2" id="descuento" size="10"
                                       maxlength="10" value="0" readonly="yes">&#36;
                            </td>
                            <td>Subtotal:</td>
                            <td><input NAME="importe" type="text" class="cajaPequena2" id="importe" size="10"
                                       maxlength="10" value="0" readonly> &#36;</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Pvp A: &nbsp;&nbsp;&nbsp;<input NAME="pvp" type="text" class="cajaPequena2" id="pvp"
                                                              size="10" maxlength="10"> &#36;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Pvp B: &nbsp;&nbsp;&nbsp;<input NAME="pvpb" type="text" class="cajaPequena2" id="pvpb"
                                                                size="10" maxlength="10"> &#36;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Pvp C: &nbsp;&nbsp;&nbsp;<input NAME="pvpc" type="text" class="cajaPequena2" id="pvpc"
                                                                size="10" maxlength="10"> &#36;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Pvp D: &nbsp;&nbsp;&nbsp;<input NAME="pvpd" type="text" class="cajaPequena2" id="pvpd"
                                                                size="10" maxlength="10"> &#36;

                            </td>
                            <td>
                                Iva
                                <input NAME="ivaporc" type="text" class="cajaMinima" id="ivaporc" size="10"
                                       maxlength="10" onChange="suma_iva()" readonly>%
                            </td>
                            <td>
                                <input NAME="iva" type="text" class="cajaPequena2" id="iva" size="10" maxlength="10"
                                       value="0" readonly> &#36;
                            </td>
                            <td><img src="../img/botonagregar.jpg" width="72" height="22" border="1" onClick="validar()"
                                     onMouseOver="style.cursor=cursor" title="Agregar articulo"></td>
                        </tr>


                        <?php if ($obligatorio_serie == 1) { ?>
                            <tr>
                                <td>
                                    Serie Obligatorio
                                    <?php if ($obligatorio_serie == 2) { ?>
                                        <input type="radio" name="obligatorio" value="2" checked> NO
                                    <?php } else { ?>
                                        <input type="radio" name="obligatorio" value="1" checked> SI
                                    <?php } ?>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    SERIES:
                                    <input id="serieaux" name="serieaux" type="text" class="cajaGrande1"/>
                                    <input type="button" onclick="AddItem()" value="Agregar Serie"/>
                                    <br/><br/>
                                    <select name="series[]" id="series" size="8" style="width: 100%"
                                            multiple="multiple">
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="button" onclick="DeleteItem()" value="Quitar Serie" />
                                </td>

                            </tr>
                        <?php } ?>

                        <tr>
                            <td>
                                Utilidad: <input
                                    NAME="utilidad" type="text" class="cajaMinima" id="utilidad" size="10"
                                    maxlength="10" value="0.00">%   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                BARRA CODIGOS:
                           <input type="text" name="lector" id="lector" onclick="limpiarLector()" onkeypress="handleKeyPress(event)" class="cajaGrande1"></td>
                        </tr>
                    </table>
            </div>
            <input name="idarticulo" value="<?php echo $idarticulo ?>" type="hidden" id="idarticulo">
            <!-- <input name="costo" value="<?php //echo $costo?>" type="hidden" id="costo">-->
            <br>
            <div id="frmBusqueda">
                <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                    <tr class="cabeceraTabla">

                        <td width="5%">CODIGO</td>
                        <td width="35%">DESCRIPCION</td>
                        <td width="10%">COD BARR</td>
                        <td width="8%">Bodega</td>
                        <td width="5%">CANT</td>
                        <td width="7%">COSTO</td>
                        <td width="7%">DCTO.</td>
                        <td width="7%">SUBT.</td>
                        <td width="7%">IVA</td>
                        <td width="3%">&nbsp;</td>
                        <td width="3%">&nbsp;</td>
                    </tr>
                </table>
                <div id="lineaResultado">
                    <iframe width="100%" height="250" id="frame_lineas" name="frame_lineas" frameborder="0">
                        <ilayer width="100%" height="250" id="frame_lineas" name="frame_lineas"></ilayer>
                    </iframe>
                </div>
            </div>
            <div id="frmBusqueda">
                <table width="25%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
                    <tr>
                        <td width="27%" class="busqueda" align="right">Subtotal</td>
                        <td width="73%" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="baseimponible" type="text" id="baseimponible" size="12"
                                       value=0 align="right" readonly>
                                &#36;</div>
                        </td>
                    </tr>

                    <tr>
                        <td width="27%" class="busqueda" align="right">Descuento</td>
                        <td width="73%" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="descuentototal" type="text" id="descuentototal"
                                       size="12" value=0 align="right" onchange="restar_descuento()">
                                &#36;</div>
                        </td>
                    </tr>

                    <tr>
                        <td width="27%" class="busqueda" align="right">IVA 0%</td>
                        <td width="73%" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="iva0" type="text" id="iva0" size="12" value=0
                                       align="right" readonly>
                                &#36;</div>
                        </td>
                    </tr>


                    <tr>
                        <td class="busqueda" align="right">IVA <?php echo $ivaporcetaje; ?>%</td>
                        <td align="right">
                            <div align="center">
                                <input class="cajaTotales" name="iva12" type="text" id="iva12" size="12" align="right"
                                       value=0 readonly>
                                &#36;</div>
                        </td>
                    </tr>

                    <tr>
                        <td width="27%" class="busqueda" align="right">Total IVA</td>
                        <td width="73%" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="importeiva" type="text" id="importeiva" size="12"
                                       value=0 align="right" readonly>
                                &#36;</div>
                        </td>
                    </tr>
                    <tr>
                        <td width="27%" class="busqueda" align="right">Flete</td>
                        <td width="73%" align="right">
                            <div align="center">
                                <input class="cajaTotales" name="flete" type="text" id="flete" size="12" value=0
                                       align="right" onchange="sumar_flete()">
                                &#36;</div>
                        </td>
                    </tr>


                    <tr>
                        <td class="busqueda" align="right">Precio Total</td>
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
                                     border="1" onMouseOver="style.cursor=cursor">
                                <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()"
                                     border="1" onMouseOver="style.cursor=cursor">
                                <!--<input id="codfamilia" name="codfamilia" value="<?php echo $codfamilia ?>" type="hidden">-->
                                <input id="codfacturatmp" name="codfacturatmp" value="<?php echo $codfacturatmp ?>"
                                       type="hidden">
                                <input id="preciototal2" name="preciototal2" value="<?php echo $preciototal ?>"
                                       type="hidden">
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <!--<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
          <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
          </iframe>-->
            </form>
        </div>
    </div>
</div>
</body>
</html>
