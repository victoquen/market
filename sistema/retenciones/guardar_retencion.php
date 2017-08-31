<?php

include("../js/fechas.php");
include("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);

$accion = $_POST["accion"];
if (!isset($accion)) {
    $accion = $_GET["accion"];
}
if ($accion != "baja") {

    //inicio datos no guardables
    $empresa = $_POST["empresa"];
    $ci_ruc = $_POST["ci_ruc"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $tipocomprobante = $_POST["tipocomprobante"];
    $numerocomprobante = $_POST["numero_comprobante"];
    //fin datos no guardables


    $idfactura = $_POST["idfactura"];
    $codretencion = $_POST["codretencion"];
    $serie1 = $_POST["serie1"];
    $serie2 = $_POST["serie2"];
    $autorizacion = $_POST["autorizacion"];
    $concepto = $_POST["concepto"];
    $totalretencion = $_POST["totalretencion"];
    $fecha = explota($_POST["fecha"]);


    $array_productos = array();
    $cont_array = 0;

    if (($_POST["impuesto1"] != "") && ($_POST["codigoimpuesto1"] != "") && ($_POST["porcretencion1"] > 0) && ($_POST["base1"] > 0)) {
        $array_productos[$cont_array]["ejercicio"] = $_POST["ejercicio1"];
        $array_productos[$cont_array]["base"] = $_POST["base1"];

        $codaux = $_POST["codigoimpuesto1"];
        $query_codret = "SELECT nombre FROM codretencion WHERE codigo = $codaux";
        $res_codret = mysql_query($query_codret, $conn);
        $array_productos[$cont_array]["impuesto"] = mysql_result($res_codret, 0, "nombre");

        $array_productos[$cont_array]["codigoimpuesto"] = $_POST["codigoimpuesto1"];
        $array_productos[$cont_array]["porcretencion"] = $_POST["porcretencion1"];
        $array_productos[$cont_array]["valorretenido"] = $_POST["valorretenido1"];
        $cont_array++;
    }
    if (($_POST["impuesto2"] != "") && ($_POST["codigoimpuesto2"] != "") && ($_POST["porcretencion2"] > 0) && ($_POST["base2"] > 0)) {
        $array_productos[$cont_array]["ejercicio"] = $_POST["ejercicio2"];
        $array_productos[$cont_array]["base"] = $_POST["base2"];

        $codaux = $_POST["codigoimpuesto2"];
        $query_codret = "SELECT nombre FROM codretencion WHERE codigo = $codaux";
        $res_codret = mysql_query($query_codret, $conn);
        $array_productos[$cont_array]["impuesto"] = mysql_result($res_codret, 0, "nombre");

        $array_productos[$cont_array]["codigoimpuesto"] = $_POST["codigoimpuesto2"];
        $array_productos[$cont_array]["porcretencion"] = $_POST["porcretencion2"];
        $array_productos[$cont_array]["valorretenido"] = $_POST["valorretenido2"];
        $cont_array++;
    }
    if (($_POST["impuesto3"] != "") && ($_POST["codigoimpuesto3"] != "") && ($_POST["porcretencion3"] > 0) && ($_POST["base3"] > 0)) {
        $array_productos[$cont_array]["ejercicio"] = $_POST["ejercicio3"];
        $array_productos[$cont_array]["base"] = $_POST["base3"];

        $codaux = $_POST["codigoimpuesto3"];
        $query_codret = "SELECT nombre FROM codretencion WHERE codigo = $codaux";
        $res_codret = mysql_query($query_codret, $conn);
        $array_productos[$cont_array]["impuesto"] = mysql_result($res_codret, 0, "nombre");

        $array_productos[$cont_array]["codigoimpuesto"] = $_POST["codigoimpuesto3"];
        $array_productos[$cont_array]["porcretencion"] = $_POST["porcretencion3"];
        $array_productos[$cont_array]["valorretenido"] = $_POST["valorretenido3"];
        $cont_array++;
    }
    if (($_POST["impuesto4"] != "") && ($_POST["codigoimpuesto4"] != "") && ($_POST["porcretencion4"] > 0) && ($_POST["base4"] > 0)) {
        $array_productos[$cont_array]["ejercicio"] = $_POST["ejercicio4"];
        $array_productos[$cont_array]["base"] = $_POST["base4"];

        $codaux = $_POST["codigoimpuesto4"];
        $query_codret = "SELECT nombre FROM codretencion WHERE codigo = $codaux";
        $res_codret = mysql_query($query_codret, $conn);
        $array_productos[$cont_array]["impuesto"] = mysql_result($res_codret, 0, "nombre");

        $array_productos[$cont_array]["codigoimpuesto"] = $_POST["codigoimpuesto4"];
        $array_productos[$cont_array]["porcretencion"] = $_POST["porcretencion4"];
        $array_productos[$cont_array]["valorretenido"] = $_POST["valorretenido4"];
        $cont_array++;
    }
    if (($_POST["impuesto5"] != "") && ($_POST["codigoimpuesto5"] != "") && ($_POST["porcretencion5"] > 0) && ($_POST["base5"] > 0)) {
        $array_productos[$cont_array]["ejercicio"] = $_POST["ejercicio5"];
        $array_productos[$cont_array]["base"] = $_POST["base5"];

        $codaux = $_POST["codigoimpuesto5"];
        $query_codret = "SELECT nombre FROM codretencion WHERE codigo = $codaux";
        $res_codret = mysql_query($query_codret, $conn);
        $array_productos[$cont_array]["impuesto"] = mysql_result($res_codret, 0, "nombre");

        $array_productos[$cont_array]["codigoimpuesto"] = $_POST["codigoimpuesto5"];
        $array_productos[$cont_array]["porcretencion"] = $_POST["porcretencion5"];
        $array_productos[$cont_array]["valorretenido"] = $_POST["valorretenido5"];
        $cont_array++;
    }
}
$minimo = 0;
//INSERT REGISTRO DE RETENCION Y RETENLINEA
if ($accion == "alta") {


    include("class/retencion.php");
    $retencion = new Retencion();
    $idretencion = $retencion->save_retencion($conn, $idfactura, $serie1, $serie2, $codretencion, $autorizacion, $concepto, $totalretencion, $fecha);


    if ($idretencion) {

        $mensaje = "La retencion ha sido dada de alta correctamente";
        $validacion = 0;


        $contador = 0;

        include("class/retenlinea.php");
        $retenlinea = new Retenlinea();


        while ($contador < $cont_array) {

            $ejercicio = strtoupper($array_productos[$contador]["ejercicio"]);
            $base = $array_productos[$contador]["base"];
            $impuesto = $array_productos[$contador]["impuesto"];
            $codigoimpuesto = $array_productos[$contador]["codigoimpuesto"];
            $porcretencion = $array_productos[$contador]["porcretencion"];
            $valorretenido = $array_productos[$contador]["valorretenido"];


            $result = $retenlinea->save_retenlinea($conn, $idretencion, $ejercicio, $base, $impuesto, $codigoimpuesto, $porcretencion, $valorretenido);
            $contador++;
        }

        echo "
        <script language='javascript'>

            var ajax_url = 'http://127.0.0.1:9876/printRetencion*'+$idretencion;
            var ajax_request = new XMLHttpRequest();
            ajax_request.open( 'GET', ajax_url, true );
            ajax_request.send();                   
        </script>
        ";

    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al ingresar la retencion</span>";
        $validacion = 1;
    }

    $cabecera1 = "Inicio >> Retencion ";
    $cabecera2 = "INSERTAR retencion ";
}


//UPDATE REGISTRO DE RETENCION Y RETENLINEA
if ($accion == "modificar") {

    $idretencion = $_POST["idretencion"];
    include("class/retencion.php");
    $retencion = new Retencion();
    $result = $retencion->update_retencion($conn, $idretencion, $concepto, $totalretencion, $codretencion);


    if ($result) {

        $mensaje = "La retencion ha sido modificada correctamente";
        $validacion = 0;


        $contador = 0;

        include("class/retenlinea.php");
        $retenlinea = new Retenlinea();
        $res = $retenlinea->delete_retenlineas($conn, $idretencion);

        while ($contador < $cont_array) {

            $ejercicio = strtoupper($array_productos[$contador]["ejercicio"]);
            $base = $array_productos[$contador]["base"];
            $impuesto = $array_productos[$contador]["impuesto"];
            $codigoimpuesto = $array_productos[$contador]["codigoimpuesto"];
            $porcretencion = $array_productos[$contador]["porcretencion"];
            $valorretenido = $array_productos[$contador]["valorretenido"];


            $result = $retenlinea->save_retenlinea($conn, $idretencion, $ejercicio, $base, $impuesto, $codigoimpuesto, $porcretencion, $valorretenido);
            $contador++;
        }


    } else {
        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al modificar la retencion</span>";
        $validacion = 1;
    }

    $cabecera1 = "Inicio >> Retencion ";
    $cabecera2 = "INSERTAR retencion ";
}


//ANULACION RETENCION
if ($accion == "baja") {


    $idretencion = $_GET["idretencion"];
    include("class/retencion.php");
    $retencion = new retencion();

    $result = $retencion->anular_retencion($conn, $idretencion);

    if ($result) {
        $mensaje = "La retencion ha sido anulada correctamente";

        $validacion = 0;

        //datos retencion
        $query_mostrar = "SELECT * FROM retencion WHERE id_retencion='$idretencion'";
        $rs_mostrar = mysql_query($query_mostrar);

        $codretencion = mysql_result($rs_mostrar, 0, "codigo_retencion");
        $serie1 = mysql_result($rs_mostrar, 0, "serie1");
        $serie2 = mysql_result($rs_mostrar, 0, "serie2");
        $autorizacion = mysql_result($rs_mostrar, 0, "autorizacion");
        $fecha = mysql_result($rs_mostrar, 0, "fecha");
        $totalretencion = mysql_result($rs_mostrar, 0, "totalretencion");
        $idfactura = mysql_result($rs_mostrar, 0, "id_factura");

        //datos proveedor
        $query_prov = "SELECT fp.id_proveedor id_proveedor, p.empresa as empresa, p.ci_ruc as ci_ruc, p.direccion as direccion, fp.tipocomprobante as tipocomprobante, fp.serie1 as serie1, fp.serie2 as serie2, fp.codigo_factura as codigo_factura
                            FROM proveedor p INNER JOIN facturasp fp ON p.id_proveedor = fp.id_proveedor
                            WHERE fp.id_facturap= $idfactura";
        $res_prov = mysql_query($query_prov, $conn);

        $empresa = mysql_result($res_prov, 0, "empresa");
        $ci_ruc = mysql_result($res_prov, 0, "ci_ruc");
        $direccion = mysql_result($res_prov, 0, "direccion");
        $tipocomprobante = mysql_result($res_prov, 0, "tipocomprobante");
        $numerocomprobante = mysql_result($res_prov, 0, "serie1") . " - " . mysql_result($res_prov, 0, "serie2") . "  # " . mysql_result($res_prov, 0, "codigo_factura");

        //telefono proveedor
        $id_prov = mysql_result($res_prov, 0, "id_proveedor");
        $query_fono = "SELECT numero FROM proveedorfono WHERE id_proveedor = $id_prov";
        $res_fono = mysql_query($query_fono, $conn);


        $telefono = mysql_result($res_fono, 0, "telefono");


    } else {
        $validacion = 1;

        $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al anular la retencion</span>";
    }

    $cabecera1 = "Inicio >> Retencion &gt;&gt; Anular retencion";
    $cabecera2 = "ANULAR retencion retencion";


}

?>


<html>
<head>
    <title>Principal</title>
    <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
    <script language="javascript">
        var cursor;
        if (document.all) {
            // Está utilizando EXPLORER
            cursor = 'hand';
        } else {
            // Está utilizando MOZILLA/NETSCAPE
            cursor = 'pointer';
        }

        function aceptar(validacion) {
            if (validacion == 0) {
                location.href = "index.php";
            }
            else
                history.back();
        }

        function imprimir(idretencion) {


            var ajax_url = 'http://127.0.0.1:9876/printRetencion*' + idretencion;
            var ajax_request = new XMLHttpRequest();
            ajax_request.open('GET', ajax_url, true);
            ajax_request.send();
            //window.open("../imprimir/imprimir_retencion.php?idretencion="+idretencion);
        }

    </script>
</head>
<body>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $cabecera2 ?></div>
            <div id="frmBusqueda">
                <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                    <tr>
                        <td width="15%"></td>
                        <td width="85%" colspan="5" class="mensaje"><?php echo $mensaje; ?></td>
                    </tr>
                    <tr>
                        <td width="10%">No. retencion</td>
                        <td>
                            <?php echo $serie1 . " - " . $serie2 . "  # " . $codretencion ?>
                        </td>
                        <td width="12%">Autorizaci&oacute;n</td>
                        <td colspan="2">
                            <?php echo $autorizacion ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="10%">Proveedor</td>
                        <td width="27%"><?php echo $empresa ?></td>
                        <td width="12%">CI/RUC</td>
                        <td colspan="2"><?php echo $ci_ruc ?></td>
                    </tr>
                    <tr>
                        <td width="10%">Direcci&oacute;n</td>
                        <td width="27%"><?php echo $direccion ?></td>
                        <td width="12%">Telf.:</td>
                        <td colspan="2"><?php echo $telefono ?></td>
                    </tr>
                    <tr>
                        <td width="10%">Fecha</td>
                        <td width="27%"><?php echo implota($fecha) ?></td>

                        <td width="12%">Tipo Comprobante</td>
                        <?php

                        switch ($tipocomprobante) {
                            // 1 FACTURA
                            case 1:
                                $comprobante = "FACTURA";
                                break;
                            // 2 LIQUIDACIONES DE COMPRA
                            case 2:
                                $comprobante = "LIQUIDACIONES DE COMPRA";
                                break;
                            // 3 NOTA DE VENTA
                            case 3:
                                $comprobante = "NOTA DE VENTA";
                                break;
                        }
                        ?>
                        <td><?php echo $comprobante ?></td>

                        <td width="12%">No. Comprobante</td>
                        <td><?php echo $numerocomprobante ?></td>

                    </tr>
                    <tr>
                        <td>Concepto</td>
                        <td colspan="5"><?php echo $concepto ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="6"></td>
                    </tr>
                </table>
                <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                    <tr class="cabeceraTabla">

                        <td width="16%">EJERCICIO FISCAL</td>
                        <td width="16%">BASE IMPONIBLE</td>
                        <td width="35%">IMPUESTO</td>
                        <td width="8%">COD IMPUESTO</td>
                        <td width="8%">% RETENCION</td>
                        <td width="8%">VALOR RETENIDO</td>
                    </tr>
                </table>
                <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">

                    <?php //$sel_lineas="SELECT retenlinea.*,articulos.*,familias.nombre as nombrefamilia FROM retenlinea,articulos,familias WHERE retenlinea.codretencion='$codretencion' AND retenlinea.codigo=articulos.codarticulo AND retenlinea.codfamilia=articulos.codfamilia AND articulos.codfamilia=familias.codfamilia ORDER BY retenlinea.numlinea ASC";
                    $sel_lineas = "SELECT rt.ejercicio_fiscal as ejercicio_fiscal, rt.base_imponible as base_imponible, rt.impuesto as impuesto,
                                                            rt.codigo_impuesto as codigo_impuesto, rt.porcentaje_retencion as porcentaje_retencion,
                                                            rt.valor_retenido as valor_retenido
                                                            FROM retenlinea rt  WHERE rt.id_retencion = '$idretencion'";
                    $rs_lineas = mysql_query($sel_lineas, $conn);
                    for ($i = 0; $i < mysql_num_rows($rs_lineas); $i++) {
                        $ejercicio_fiscal = mysql_result($rs_lineas, $i, "ejercicio_fiscal");
                        $base_imponible = mysql_result($rs_lineas, $i, "base_imponible");
                        $impuesto = mysql_result($rs_lineas, $i, "impuesto");
                        $codigo_impuesto = mysql_result($rs_lineas, $i, "codigo_impuesto");
                        $porcentaje_retencion = mysql_result($rs_lineas, $i, "porcentaje_retencion");
                        $valor_retenido = mysql_result($rs_lineas, $i, "valor_retenido");
                        if ($i % 2) {
                            $fondolinea = "itemParTabla";
                        } else {
                            $fondolinea = "itemImparTabla";
                        } ?>
                        <tr class="<?php echo $fondolinea ?>">

                            <td width="16%" align="center"><?php echo $ejercicio_fiscal ?></td>
                            <td width="16%" align="center"><?php echo number_format($base_imponible, 2) ?> &#36;</td>
                            <td width="35%"><?php echo $impuesto ?></td>
                            <td width="8%" align="center"><?php echo $codigo_impuesto ?></td>
                            <td width="8%" align="center"><?php echo $porcentaje_retencion ?></td>
                            <td width="8%" align="center"><?php echo number_format($valor_retenido, 2) ?> &#36;</td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <div id="frmBusqueda">
                <table width="25%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
                    <tr>
                        <td width="15%">Total:</td>
                        <td width="15%"><?php echo number_format($totalretencion, 2); ?> &#36;</td>
                    </tr>


                </table>
            </div>
            <div id="botonBusqueda">
                <div align="center">

                    <img src="../img/botonaceptar.jpg" width="85" height="22"
                         onClick="aceptar(<?php echo $validacion ?>)" border="1" onMouseOver="style.cursor=cursor">

                    <img src="../img/botonimprimir.jpg" width="79" height="22" border="1"
                         onClick="imprimir(<?php echo $idretencion ?>)" onMouseOver="style.cursor=cursor">
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
