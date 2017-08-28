<?php 
include("../conexion/conexion.php");

//get datos SESSION
session_start();
$id_bodega = $_SESSION['id_bodega'];
$tipo = $_SESSION['tipo'];

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$fechahoy = date("Y-m-d");
$sel_fact = "INSERT INTO transferenciatmp (id_transferencia,fecha) VALUE (null,'$fechahoy')";
$rs_fact = mysql_query($sel_fact, $conn);
$transferenciatmp = mysql_insert_id();

$query = "DELETE FROM transferencialineatmp WHERE id_transferencia='$transferenciatmp'";
            $rs = mysql_query($query, $conn);

//SERIE OBLIGATORIO***************************************************
$obligatorio_serie = 1;
?>
<html>
<head>
    <title>Principal</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
    <link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
    <script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
    <script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
    <script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>
    <script language="javascript">
        var cursor;
        if (document.all) {
            // Está utilizando EXPLORER
            cursor = 'hand';
        } else {
            // Está utilizando MOZILLA/NETSCAPE
            cursor = 'pointer';
        }

        var miPopup
        function abreVentana() {
            var codfactura = document.getElementById("codfactura").value;
            var codfactura = document.getElementById("serie1").value;
            var codfactura = document.getElementById("serie2").value;
            var codfactura = document.getElementById("autorizacion").value;
            if ((codfactura == "") || (serie1 == "") || (serie2 == "") || (autorizacion == "")) {
                alert("Debe ingresar el No. y Autorizacion de la FACTURA");
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


        function validar_cabecera() {

            document.getElementById("formulario").submit();

        }

        function validar() {
            var mensaje = "";


            if (document.getElementById("codarticulo").value == "") mensaje = "  - Escojer Producto\n";
            if (document.getElementById("cantidad").value == 0) mensaje += "  - Ingresar Cantidad\n";
            if (document.getElementById("cbobodegaorigen").value == 0) mensaje += "  - Escoger Bodega Origen\n";
            if (document.getElementById("cbobodegadestino").value == 0) mensaje += "  - Escoger Bodega Destinossss\n";

            if(<?php  echo $obligatorio_serie?> == 1){

                var numProducto = document.getElementById("cantidad").value;
                var theSelect = document.getElementById('series');
                var options = theSelect.getElementsByTagName('option');

                var numSeries = 0;
                for(var i =0; i<options.length; i++){
                    if(options[i].selected ==true){
                       numSeries ++;
                    }
                }
                
                if(numProducto != numSeries){
                    mensaje += "  - Cantidad de producto, no concuerda con cantidad Series ingresadas\n";
                }
            }

            if (mensaje != "") {
                alert("Atencion, se han detectado las siguientes incorrecciones:\n\n" + mensaje);
            } else {


                document.getElementById("formulario_lineas").submit();
                document.getElementById("codarticulo").value = "";
                document.getElementById("descripcion").value = "";
                document.getElementById("cantidad").value = 0;
                document.getElementById("cbobodegaorigen").value = 0;
                document.getElementById("cbobodegadestino").value = 0;

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
    </script>
</head>
<body>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header">TRANSFERENCIA DE PRODUCTOS ENTRE BODEGAS</div>
            <div id="frmBusqueda">
                <form id="formulario" name="formulario" method="post" action="guardar_transferencia.php">
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>


                        <?php  $hoy = date("d/m/Y"); ?>
                        <tr>
                            <td>Fecha</td>
                            <td>
                                <input NAME="fecha" type="text" class="cajaPequena" id="fecha" size="10" maxlength="10"
                                       value="<?php  echo $hoy ?>" readonly> <img src="../img/calendario.png"
                                                                                 name="Image1" id="Image1" width="16"
                                                                                 height="16" border="0" id="Image1"
                                                                                 onMouseOver="this.style.cursor='pointer'">
                                <script type="text/javascript">
                                    Calendar.setup(
                                        {
                                            inputField: "fecha",
                                            ifFormat: "%d/%m/%Y",
                                            button: "Image1"
                                        }
                                    );
                                </script>
                            </td>

                        </tr>
                    </table>
            </div>

            <input id="transferenciatmp" name="transferenciatmp" value="<?php  echo $transferenciatmp ?>" type="hidden">


            <input id="accion" name="accion" value="alta" type="hidden">
            </form>
            <br>
            <div id="frmBusqueda">
                <form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas.php"
                      target="frame_lineas">
                    <div id="tituloForm" class="header">PRODUCTOS</div>
                    <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>

                        <tr>

                            <td width="10%">C&oacute;digo Producto</td>
                            <td width="15%"><input NAME="codarticulo" type="text" class="cajaMedia" id="codarticulo"
                                                   size="15" maxlength="15" onClick="ventanaArticulos()" readonly> <img
                                    src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos()"
                                    onMouseOver="style.cursor=cursor" title="Buscar articulos"></td>
                            <td>Descripci&oacute;n
                                <input NAME="descripcion" type="text" class="cajaGrande" id="descripcion" size="30"
                                       maxlength="30" readonly>
                            </td>
                        </tr>
                        <tr>

                            <td>Cantidad</td>
                            <td>

                                <input NAME="cantidad" type="text" class="cajaMinima" id="cantidad" size="10"
                                       maxlength="10" value="0">

                            </td>
                            <td>
                               Series: <select name="series[]" id="series" size="3" style="width: 100%"
                                        multiple="multiple"></select>

                            </td>

                        </tr>
                        <tr>
                            <td>
                                Bodega Origen:
                            </td>
                            <td>
                                <select name="cbobodegaorigen" id="cbobodegaorigen" class="comboMedio"></select>
                            </td>
                            <td>
                                <?php 
                                $queryb = "SELECT b.id_bodega as idbodega, b.nombre as nombre FROM bodega b ";
                                $resb = mysql_query($queryb, $conn); ?>

                                Bodega Destino:
                                <select name="cbobodegadestino" id="cbobodegadestino" class="comboMedio">
                                    <option value="0">Escoger</option>
                                    <?php 

                                    $contador = 0;
                                    while ($contador < mysql_num_rows($resb)) {
                                        if (mysql_result($resb, $contador, "idbodega") != $id_bodega) {
                                            ?>
                                            <option
                                                value="<?php  echo mysql_result($resb, $contador, "idbodega") ?>"><?php  echo mysql_result($resb, $contador, "nombre"); ?></option>

                                        <?php  }
                                        $contador++;
                                    } ?>


                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><img src="../img/botonagregar.jpg" width="72" height="22" border="1" onClick="validar()"
                                     onMouseOver="style.cursor=cursor" title="Agregar articulo"></td>
                        </tr>
                    </table>
            </div>
            <input name="idarticulo" value="<?php  echo $idarticulo ?>" type="hidden" id="idarticulo">

            <br>
            <div id="frmBusqueda">
                <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                    <tr class="cabeceraTabla">

                        <td width="5%">CODIGO</td>
                        <td width="40%">DESCRIPCION</td>
                        <td width="5%">CANT</td>
                        <td width="22%">Origen</td>
                        <td width="22%">Destino</td>

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

                                <input id="transferenciatmp" name="transferenciatmp"
                                       value="<?php  echo $transferenciatmp ?>" type="hidden">

                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            </form>
        </div>
    </div>
</div>
</body>
</html>
