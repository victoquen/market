<?php 
include ("../js/fechas.php");

/* Database connection */
include_once '../conexion/conexion.php';
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();
$mes_contable = "";

$mes = $_POST["cbomes"];
$ano = $_POST["cboano"];

switch ($mes) {
    case '1':
        $fechainicio = $ano . "-01-01";
        $fechafin = $ano . "-01-31";
        $mes_contable = "01";
        break;
    case '2':
        $fechainicio = $ano . "-02-01";
        $fechafin = $ano . "-02-28";
        $mes_contable = "02";
        break;
    case '3':
        $fechainicio = $ano . "-03-01";
        $fechafin = $ano . "-03-31";
        $mes_contable = "03";
        break;
    case '4':
        $fechainicio = $ano . "-04-01";
        $fechafin = $ano . "-04-30";
        $mes_contable = "04";
        break;
    case '5':
        $fechainicio = $ano . "-05-01";
        $fechafin = $ano . "-05-31";
        $mes_contable = "05";
        break;
    case '6':
        $fechainicio = $ano . "-06-01";
        $fechafin = $ano . "-06-30";
        $mes_contable = "06";
        break;
    case '7':
        $fechainicio = $ano . "-07-01";
        $fechafin = $ano . "-07-31";
        $mes_contable = "07";
        break;
    case '8':
        $fechainicio = $ano . "-08-01";
        $fechafin = $ano . "-08-31";
        $mes_contable = "08";
        break;
    case '9':
        $fechainicio = $ano . "-09-01";
        $fechafin = $ano . "-09-30";
        $mes_contable = "09";
        break;
    case '10':
        $fechainicio = $ano . "-10-01";
        $fechafin = $ano . "-10-31";
        $mes_contable = "10";
        break;
    case '11':
        $fechainicio = $ano . "-11-01";
        $fechafin = $ano . "-11-30";
        $mes_contable = "11";
        break;
    case '12':
        $fechainicio = $ano . "-12-01";
        $fechafin = $ano . "-12-31";
        $mes_contable = "12";
        break;
}

//datos ruc*********************************************************************
$query_ruc = "SELECT idinformante, razonsocial FROM ruc WHERE id_ruc = 1";
$res_ruc = mysql_query($query_ruc, $conn);

$id_informante = mysql_result($res_ruc, 0, "idinformante");
$razon_social = mysql_result($res_ruc, 0, "razonsocial");
?>


<html>
    <head>
        <title>Cobros</title>
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

            function aceptar() {
                location.href = "index.php";
            }



        </script>
    </head>

    <body>
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header">ATS Anexo Transaccional Simplificado</div>
                    <div id="frmBusqueda">

                        <table class="fuente8" width="40%" cellspacing=0 cellpadding=3 border=0>
                            <tr>
                                <td width ="10%"><b>MES:</b></td>
                                <td width ="10%"><?php  echo $mes_contable ?></td>
                                <td width = "20%"><b>RUC:</b></td>
                                <td align = "left"><?php  echo $id_informante ?></td>
                            </tr>
                            <tr>
                                <td><b>A&Ntilde;O:</b></td>
                                <td><?php  echo $ano ?></td>

                                <td><b>RAZON SOCIAL:</b></td>
                                <td><?php  echo $razon_social ?></td>
                            </tr>
                        </table>


                        <?php 
                        $query_retencionero = "SELECT serie1, serie2, autorizacion FROM retencionero";
                        $res_retencionero = mysql_query($query_retencionero, $conn);
                        $serie1_retencionero = mysql_result($res_retencionero, 0, "serie1");
                        $serie2_retencionero = mysql_result($res_retencionero, 0, "serie2");
                        $autorizacion_retencionero = mysql_result($res_retencionero, 0, "autorizacion");
//total ventas por factureros del ruc*************************************
                        $array_factureroventas = array();

                        $query_facturero = "SELECT SQL_CALC_FOUND_ROWS id_facturero, serie1 FROM facturero WHERE id_ruc = 1";
                        $res_facturero = mysql_query($query_facturero, $conn);
                        $cont_f = 0;
                        while ($cont_f < mysql_num_rows($res_facturero)) {


                            $id_facturero = mysql_result($res_facturero, $cont_f, "id_facturero");
                            $establecimiento = mysql_result($res_facturero, $cont_f, "serie1");

                            $suma = 0;
                            $query_suma = "SELECT SUM(iva0+iva12+flete) as suma FROM facturas WHERE (anulado = 0)  AND (id_facturero =$id_facturero )  AND (fecha BETWEEN '$fechainicio' AND '$fechafin')";
                            $res_suma = mysql_query($query_suma, $conn);
                            $suma = mysql_result($res_suma, 0, "suma");

                            $resta = 0;
                            /* $query_resta = "SELECT SUM(iva0+iva12+flete) as resta FROM facturas WHERE (anulado = 0) AND (credito = 1) AND (id_facturero =$id_facturero) AND (fecha BETWEEN '$fechainicio' AND '$fechafin')";
                              $res_resta = mysql_query($query_resta, $conn);
                              $resta = mysql_result($res_resta, 0, "resta"); */


                            $array_factureroventas[$cont_f]["establecimiento"] = $establecimiento;
                            $array_factureroventas[$cont_f]["subtotal"] = $suma - $resta;

                            $cont_f++;
                        }

                        $totalVentas = 0;
                        for ($auxi = 0; $auxi < count($array_factureroventas); $auxi++) {
                            $totalVentas = $totalVentas + $array_factureroventas[$auxi]["subtotal"];
                        }
                        ?>
                        <br/>
                        <table class="fuente8" width="25%" cellspacing=0 cellpadding=3 border=1>
                            <tr>
                                <td colspan="2" align = "center"><b>RESUMEN DE VENTAS</b></td>
                            </tr>
                            <tr>
                                <td><b>ESTABLECIMIENTO</b></td>
                                <td><b>SUBTOTAL</b></td>
                            </tr>
<?php 
for ($auxi = 0; $auxi < count($array_factureroventas); $auxi++) {
    ?>    

                                <tr>
                                    <td><?php  echo $array_factureroventas[$auxi]["establecimiento"]; ?></td>
                                    <td><?php  echo number_format($array_factureroventas[$auxi]["subtotal"], 2, ".", ""); ?></td>
                                </tr>

    <?php 
}
?>

                            <tr>
                                <td align="right"><b>TOTAL</b></td>
                                <td><b><?php  echo number_format($totalVentas, 2, ".", "") ?></b></td>
                            </tr>
                        </table>


<?php 
//creacion xml *****************************************************************
$xml = new DomDocument('1.0', 'UTF-8');
$iva = $xml->createElement('iva');
$iva = $xml->appendChild($iva);
//datos cabecera xml ***********************************************************
$numEstabRuc = count($array_factureroventas);
if (strlen($numEstabRuc) == 1) {
    $numEstabRuc = "00" . $numEstabRuc;
} else {
    if (strlen($numEstabRuc) == 2) {
        $numEstabRuc = "0" . $numEstabRuc;
    }
}
$nodo = $xml->createElement('TipoIDInformante', "R");
$nodo = $iva->appendChild($nodo);
$nodo = $xml->createElement('IdInformante', $id_informante);
$nodo = $iva->appendChild($nodo);
$nodo = $xml->createElement('razonSocial', $razon_social);
$nodo = $iva->appendChild($nodo);
$nodo = $xml->createElement('Anio', $ano);
$nodo = $iva->appendChild($nodo);
$nodo = $xml->createElement('Mes', $mes_contable);
$nodo = $iva->appendChild($nodo);
$nodo = $xml->createElement('numEstabRuc', $numEstabRuc);
$nodo = $iva->appendChild($nodo);
$nodo = $xml->createElement('totalVentas', number_format($totalVentas, 2, ".", ""));
$nodo = $iva->appendChild($nodo);
$nodo = $xml->createElement('codigoOperativo', "IVA");
$nodo = $iva->appendChild($nodo);


$compras = $xml->createElement('compras');
$compras = $iva->appendChild($compras);

$ventas = $xml->createElement('ventas');
$ventas = $iva->appendChild($ventas);

$ventasestablecimiento = $xml->createElement('ventasEstablecimiento');
$ventasestablecimiento = $iva->appendChild($ventasestablecimiento);

$anulados = $xml->createElement('anulados');
$anulados = $iva->appendChild($anulados);

//datos compras*********************************************************************

$subtotal_basenogravaiva = 0;
$subtotal_baseimponible = 0;
$subtotal_baseimpgrav = 0;
$subtotal_valorretbienes = 0;
$subtotal_valorretservicios = 0;
$subtotal_valretserv100 = 0;
$subtotal_retenciones = 0;

$query_compras = "SELECT a.id_facturap as id_facturap, a.tipocomprobante as tipo_comprobante, a.fecha as fecha, b.ci_ruc as ruc,  a.autorizacion as autorizacion, a.serie1 as serie1, a.serie2 as serie2, a.codigo_factura as codigo_factura, a.iva0 as iva0, a.iva12 as iva12, a.iva as iva, a.totalfactura as totalfactura, a.credito as credito, a.retencion as retencion
  FROM facturasp a INNER JOIN proveedor b ON a.id_proveedor=b.id_proveedor
  WHERE (a.anulado = 0) AND (a.fecha BETWEEN '$fechainicio' AND '$fechafin')";
$res_c = mysql_query($query_compras, $conn);

$i = 0;
while ($i < mysql_num_rows($res_c)) {

    $idfacturap = mysql_result($res_c, $i, "id_facturap");
    $tipo_comprobante = mysql_result($res_c, $i, "tipo_comprobante");
    $fecha = implota(mysql_result($res_c, $i, "fecha"));
    $ruc = mysql_result($res_c, $i, "ruc");
    $autorizacion = mysql_result($res_c, $i, "autorizacion");
    $serie1 = mysql_result($res_c, $i, "serie1");
    $serie2 = mysql_result($res_c, $i, "serie2");
    $codigo_factura = mysql_result($res_c, $i, "codigo_factura");
    $iva0 = mysql_result($res_c, $i, "iva0");
    $iva12 = mysql_result($res_c, $i, "iva12");
    $iva = mysql_result($res_c, $i, "iva");
    $totalfactura = mysql_result($res_c, $i, "totalfactura");
    $credito = mysql_result($res_c, $i, "credito");
    $retencion = mysql_result($res_c, $i, "retencion");

    switch ($tipo_comprobante) {
        case 1:
            $codsustento = "01";
            $tpidprov = "01";
            $tipocomprobante = "01";

            $basenograiva = "0.00";
            $baseimponible = $iva0;
            break;
        case 2:
            $codsustento = "01";
            $tpidprov = "01";
            $tipocomprobante = "03";

            $basenograiva = "0.00";
            $baseimponible = $iva0;
            break;
        case 3:
            $codsustento = "02";
            $tpidprov = "01";
            $tipocomprobante = "02";

            $basenograiva = $iva0;
            $baseimponible = "0.00";
            break;
    }


    /* if ($credito == 1) {
      $tipocomprobante = "04";
      } */


    $subtotal_basenogravaiva = $subtotal_basenogravaiva + $basenograiva;
    $subtotal_baseimponible = $subtotal_baseimponible + $baseimponible;
    $subtotal_baseimpgrav = $subtotal_baseimpgrav + $iva12;

$base_retencio332=$basenograiva + $baseimponible +$iva12;
    $ret30 = "0.00";
    $ret70 = "0.00";
    $ret100 = "0.00";
    if ($retencion == 1) {
        $query_ret = "SELECT rl.codigo_impuesto as codigo, rl.valor_retenido as valor, rl.porcentaje_retencion as porcentaje, rl.base_imponible as base, rt.serie1 as retserie1, rt.serie2 as retserie2, rt.codigo_retencion as retsecuencia, rt.autorizacion as retautorizacion  FROM retenlinea rl INNER JOIN retencion rt ON rl.id_retencion = rt.id_retencion INNER JOIN facturasp f ON rt.id_factura = f.id_facturap WHERE f.id_facturap = $idfacturap";
        $res_ret = mysql_query($query_ret, $conn);

        $i_ret = 0;
        while ($i_ret < mysql_num_rows($res_ret)) {
            $codret = mysql_result($res_ret, $i_ret, "codigo");
            switch ($codret) {
                case "721":
                    $ret30 = mysql_result($res_ret, $i_ret, "valor");
                    $subtotal_valorretbienes = $subtotal_valorretbienes + $ret30;


                    break;
                case "723":
                    $ret70 = mysql_result($res_ret, $i_ret, "valor");
                    $subtotal_valorretservicios = $subtotal_valorretservicios + $ret70;
                    break;
                case "725":
                    $ret100 = mysql_result($res_ret, $i_ret, "valor");
                    $subtotal_valretserv100 = $subtotal_valretserv100 + $ret100;
                    break;
            }
            $i_ret++;
        }
    }

    $detallecompras = $xml->createElement('detalleCompras');
    $detallecompras = $compras->appendChild($detallecompras);

    $subnodo = $xml->createElement('codSustento', $codsustento);
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('tpIdProv', $tpidprov);
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('idProv', $ruc);
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('tipoComprobante', $tipocomprobante);
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('fechaRegistro', $fecha);
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('establecimiento', $serie1);
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('puntoEmision', $serie2);
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('secuencial', $codigo_factura);
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('fechaEmision', $fecha);
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('autorizacion', $autorizacion);
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('baseNoGraIva', number_format($basenograiva, 2, ".", ""));
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('baseImponible', number_format($baseimponible, 2, ".", ""));
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('baseImpGrav', number_format($iva12, 2, ".", ""));
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('montoIce', '0.00');
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('montoIva', number_format($iva, 2, ".", ""));
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('valorRetBienes', number_format($ret30, 2, ".", ""));
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('valorRetServicios', number_format($ret70, 2, ".", ""));
    $subnodo = $detallecompras->appendChild($subnodo);
    $subnodo = $xml->createElement('valRetServ100', number_format($ret100, 2, ".", ""));
    $subnodo = $detallecompras->appendChild($subnodo);

    $pagoexterior = $xml->createElement('pagoExterior');
    $pagoexterior = $detallecompras->appendChild($pagoexterior);

    $subnodo = $xml->createElement('pagoLocExt', '01');
    $subnodo = $pagoexterior->appendChild($subnodo);
    $subnodo = $xml->createElement('paisEfecPago', 'NA');
    $subnodo = $pagoexterior->appendChild($subnodo);
    $subnodo = $xml->createElement('aplicConvDobTrib', 'NA');
    $subnodo = $pagoexterior->appendChild($subnodo);
    $subnodo = $xml->createElement('pagExtSujRetNorLeg', 'NA');
    $subnodo = $pagoexterior->appendChild($subnodo);

    $auxtotalcompras = $basenograiva + $baseimponible + $iva12;
    if($auxtotalcompras >= 1000){
        $formasdepago = $xml->createElement('formasDePago');
        $formasdepago = $detallecompras->appendChild($formasdepago);
        
        $subnodo = $xml->createElement('formaPago', '02');
        $subnodo = $formasdepago->appendChild($subnodo);
    }
    
    $air = $xml->createElement('air');
    $air = $detallecompras->appendChild($air);


    if ($retencion == 1) {

        $i_ret = 0;
        $control_ret = 0;
        while ($i_ret < mysql_num_rows($res_ret)) {
            $valorret=0;
            $codret = mysql_result($res_ret, $i_ret, "codigo");
            if (($codret != "721") && ($codret != "723") && ($codret != "725")) {

                $control_ret = 1;
                $base = mysql_result($res_ret, $i_ret, "base");
                $porcentaje = mysql_result($res_ret, $i_ret, "porcentaje");
                $valorret = mysql_result($res_ret, $i_ret, "valor");

                $detalleAir = $xml->createElement('detalleAir');
                $detalleAir = $air->appendChild($detalleAir);

                $subnodo = $xml->createElement('codRetAir', $codret);
                $subnodo = $detalleAir->appendChild($subnodo);
                $subnodo = $xml->createElement('baseImpAir', number_format($base, 2, ".", ""));
                $subnodo = $detalleAir->appendChild($subnodo);
                $subnodo = $xml->createElement('porcentajeAir', $porcentaje);
                $subnodo = $detalleAir->appendChild($subnodo);
                $subnodo = $xml->createElement('valRetAir', number_format($valorret, 2, ".", ""));
                $subnodo = $detalleAir->appendChild($subnodo);

                $retserie1 = mysql_result($res_ret, $i_ret, "retserie1");
                $retserie2 = mysql_result($res_ret, $i_ret, "retserie2");
                $retsecuencia = mysql_result($res_ret, $i_ret, "retsecuencia");
                $retautorizacion = mysql_result($res_ret, $i_ret, "retautorizacion");
            }else{
                
                
            }
            
            
            
            
            $i_ret++;

            $subtotal_retenciones = $subtotal_retenciones + $valorret;
        }

        if ($control_ret == 1) {

            $subnodo = $xml->createElement('estabRetencion1', $retserie1);
            $subnodo = $detallecompras->appendChild($subnodo);
            $subnodo = $xml->createElement('ptoEmiRetencion1', $retserie2);
            $subnodo = $detallecompras->appendChild($subnodo);
            $subnodo = $xml->createElement('secRetencion1', $retsecuencia);
            $subnodo = $detallecompras->appendChild($subnodo);
            $subnodo = $xml->createElement('autRetencion1', $retautorizacion);
            $subnodo = $detallecompras->appendChild($subnodo);
            $subnodo = $xml->createElement('fechaEmiRet1', $fecha);
            $subnodo = $detallecompras->appendChild($subnodo);
        }else{
            $base_retencio332=$basenograiva + $baseimponible +$iva12;
            $detalleAir = $xml->createElement('detalleAir');
            $detalleAir = $air->appendChild($detalleAir);

            $subnodo = $xml->createElement('codRetAir', "332");
            $subnodo = $detalleAir->appendChild($subnodo);
            $subnodo = $xml->createElement('baseImpAir', number_format($base_retencio332, 2, ".", ""));
            $subnodo = $detalleAir->appendChild($subnodo);
            $subnodo = $xml->createElement('porcentajeAir', "0.00");
            $subnodo = $detalleAir->appendChild($subnodo);
            $subnodo = $xml->createElement('valRetAir', "0.00");
            $subnodo = $detalleAir->appendChild($subnodo);

            $subnodo = $xml->createElement('estabRetencion1', $serie1_retencionero);
            $subnodo = $detallecompras->appendChild($subnodo);
            $subnodo = $xml->createElement('ptoEmiRetencion1', $serie2_retencionero);
            $subnodo = $detallecompras->appendChild($subnodo);
            $subnodo = $xml->createElement('secRetencion1', "0");
            $subnodo = $detallecompras->appendChild($subnodo);
            $subnodo = $xml->createElement('autRetencion1', $autorizacion_retencionero);
            $subnodo = $detallecompras->appendChild($subnodo);
            $subnodo = $xml->createElement('fechaEmiRet1', $fecha);
            $subnodo = $detallecompras->appendChild($subnodo);
        }
    } else {
        $base_retencio332=$basenograiva + $baseimponible +$iva12;
        $detalleAir = $xml->createElement('detalleAir');
        $detalleAir = $air->appendChild($detalleAir);

        $subnodo = $xml->createElement('codRetAir', "332");
        $subnodo = $detalleAir->appendChild($subnodo);
        $subnodo = $xml->createElement('baseImpAir', number_format($base_retencio332, 2, ".", ""));
        $subnodo = $detalleAir->appendChild($subnodo);
        $subnodo = $xml->createElement('porcentajeAir', "0.00");
        $subnodo = $detalleAir->appendChild($subnodo);
        $subnodo = $xml->createElement('valRetAir', "0.00");
        $subnodo = $detalleAir->appendChild($subnodo);

        $subnodo = $xml->createElement('estabRetencion1', $serie1_retencionero);
        $subnodo = $detallecompras->appendChild($subnodo);
        $subnodo = $xml->createElement('ptoEmiRetencion1', $serie2_retencionero);
        $subnodo = $detallecompras->appendChild($subnodo);
        $subnodo = $xml->createElement('secRetencion1', "0");
        $subnodo = $detallecompras->appendChild($subnodo);
        $subnodo = $xml->createElement('autRetencion1', $autorizacion_retencionero);
        $subnodo = $detallecompras->appendChild($subnodo);
        $subnodo = $xml->createElement('fechaEmiRet1', $fecha);
        $subnodo = $detallecompras->appendChild($subnodo);
        
    }
    $i++;
}
//fin compras ******************************************************************
?>

                        <br/>
                        <table class="fuente8" width="25%"  cellspacing=0 cellpadding=3 border=1 >
                            <tr>
                                <td colspan="2" align = "center"><b>RESUMEN DE COMPRAS</b></td>
                            </tr>
                            <tr>
                                <td><b>Base Imponible no objeto de IVA</b></td>
                                <td><?php  echo number_format($subtotal_basenogravaiva, 2, ".", ""); ?></td>
                            </tr>
                            <tr>
                                <td><b>Base Imponible tarifa 0% de IVA</b></td>
                                <td><?php  echo number_format($subtotal_baseimponible, 2, ".", ""); ?></td>
                            </tr>
                            <tr>
                                <td><b>Base Imponible gravada</b></td>
                                <td><?php  echo number_format($subtotal_baseimpgrav, 2, ".", ""); ?></td>
                            </tr>
                            <tr>
                                <td><b>Retenci�n de IVA 30% bienes</b></td>
                                <td><?php  echo number_format($subtotal_valorretbienes, 2, ".", ""); ?></td>
                            </tr>
                            <tr>                                
                                <td><b>Retenci�n de IVA 70% servicios</b></td>
                                <td><?php  echo number_format($subtotal_valorretservicios, 2, ".", ""); ?></td>
                            </tr>
                            <tr>                                
                                <td><b> Retenci�n de IVA 100%</b></td>
                                <td><?php  echo number_format($subtotal_valretserv100, 2, ".", ""); ?></td>
                            </tr>
                            <tr>                                
                                <td><b>TOTAL Retenciones</b></td>
                                <td><?php  echo number_format($subtotal_retenciones, 2, ".", ""); ?></td>                                
                            </tr>
                        </table>


<?php 
//inicio ventas ****************************************************************
//ventas facturas tipoComprobante 18**********
$query_ventas = "SELECT c.ci_ruc as ruc, COUNT(f.id_factura) as numerocomprobantes, SUM(f.iva0 + flete) as iva0, SUM(f.iva12) as iva12, SUM(f.iva) as importeiva, SUM(f.ret_iva) as retiva, SUM(f.ret_fuente) as retfuente
    FROM facturas f INNER JOIN cliente c ON f.id_cliente = c.id_cliente
WHERE (f.anulado = 0)  AND (f.fecha BETWEEN '$fechainicio' AND '$fechafin')
GROUP BY (c.ci_ruc)";

$res_v = mysql_query($query_ventas, $conn);

$i = 0;
while ($i < mysql_num_rows($res_v)) {

    $ruc = mysql_result($res_v, $i, "ruc");
    $numerocomprobantes = mysql_result($res_v, $i, "numerocomprobantes");
    $iva0 = mysql_result($res_v, $i, "iva0");
    $iva12 = mysql_result($res_v, $i, "iva12");
    $importeiva = mysql_result($res_v, $i, "importeiva");
    $retiva = mysql_result($res_v, $i, "retiva");
    $retfuente = mysql_result($res_v, $i, "retfuente");


    $tipcomprob = "18";
    $basenograiva = "0.00";
    $baseimponible = "0.00";
    $baseimpgrav = $iva12;
    switch (strlen($ruc)) {
        case 10:
            $tpidcliente = "05";
            $basenograiva = $iva0;
            break;
        case 13:
            if ($ruc == '9999999999999') {
                $tpidcliente = "07";
                $basenograiva = $iva0;
            } else {
                $tpidcliente = "04";
                $baseimponible = $iva0;
            }
            break;
    }

    $detalleventas = $xml->createElement('detalleVentas');
    $detalleventas = $ventas->appendChild($detalleventas);

    $subnodo = $xml->createElement('tpIdCliente', $tpidcliente);
    $subnodo = $detalleventas->appendChild($subnodo);
    $subnodo = $xml->createElement('idCliente', $ruc);
    $subnodo = $detalleventas->appendChild($subnodo);
    $subnodo = $xml->createElement('tipoComprobante', $tipcomprob);
    $subnodo = $detalleventas->appendChild($subnodo);
    $subnodo = $xml->createElement('numeroComprobantes', $numerocomprobantes);
    $subnodo = $detalleventas->appendChild($subnodo);
    $subnodo = $xml->createElement('baseNoGraIva', number_format($basenograiva, 2, ".", ""));
    $subnodo = $detalleventas->appendChild($subnodo);
    $subnodo = $xml->createElement('baseImponible', number_format($baseimponible, 2, ".", ""));
    $subnodo = $detalleventas->appendChild($subnodo);
    $subnodo = $xml->createElement('baseImpGrav', number_format($baseimpgrav, 2, ".", ""));
    $subnodo = $detalleventas->appendChild($subnodo);
    $subnodo = $xml->createElement('montoIva', number_format($importeiva, 2, ".", ""));
    $subnodo = $detalleventas->appendChild($subnodo);
    $subnodo = $xml->createElement('valorRetIva', $retiva);
    $subnodo = $detalleventas->appendChild($subnodo);
    $subnodo = $xml->createElement('valorRetRenta', $retfuente);
    $subnodo = $detalleventas->appendChild($subnodo);

    $i++;
}
//fin ventas facturas tipo 18**********
//ventas nota credito tipoComprobante 04**********

/* $query_ventas = "SELECT c.ci_ruc as ruc, COUNT(f.id_factura) as numerocomprobantes, SUM(f.iva0 + flete) as iva0, SUM(f.iva12) as iva12, SUM(f.iva) as importeiva, SUM(f.ret_iva) as retiva, SUM(f.ret_fuente) as retfuente
  FROM facturas f INNER JOIN cliente c ON f.id_cliente = c.id_cliente
  WHERE (f.anulado = 0) AND  AND (f.fecha BETWEEN '$fechainicio' AND '$fechafin')
  GROUP BY (c.ci_ruc)";

  $res_v = mysql_query($query_ventas, $conn);

  $i = 0;
  while ($i < mysql_num_rows($res_v)) {

  $ruc = mysql_result($res_v, $i, "ruc");
  $numerocomprobantes = mysql_result($res_v, $i, "numerocomprobantes");
  $iva0 = mysql_result($res_v, $i, "iva0");
  $iva12 = mysql_result($res_v, $i, "iva12");
  $importeiva = mysql_result($res_v, $i, "importeiva");
  $retiva = mysql_result($res_v, $i, "retiva");
  $retfuente = mysql_result($res_v, $i, "retfuente");


  $tipcomprob = "04";
  $basenograiva = "0.00";
  $baseimponible = "0.00";
  $baseimpgrav = "0.00";
  switch (strlen($ruc)) {
  case 10:
  $tpidcliente = "05";
  $basenograiva = $iva0;
  break;
  case 13:
  if ($ruc == "9999999999999") {
  $tpidcliente = "07";
  $basenograiva = $iva0;
  } else {
  $tpidcliente = "04";
  $baseimponible = $iva0;
  }
  break;
  }

  $detalleventas = $xml->createElement('detalleVentas');
  $detalleventas = $ventas->appendChild($detalleventas);

  $subnodo = $xml->createElement('tpIdCliente', $tpidcliente);
  $subnodo = $detalleventas->appendChild($subnodo);
  $subnodo = $xml->createElement('idCliente', $ruc);
  $subnodo = $detalleventas->appendChild($subnodo);
  $subnodo = $xml->createElement('tipoComprobante', $tipcomprob);
  $subnodo = $detalleventas->appendChild($subnodo);
  $subnodo = $xml->createElement('numeroComprobantes', $numerocomprobantes);
  $subnodo = $detalleventas->appendChild($subnodo);
  $subnodo = $xml->createElement('baseNoGraIva', $basenograiva);
  $subnodo = $detalleventas->appendChild($subnodo);
  $subnodo = $xml->createElement('baseImponible', $baseimponible);
  $subnodo = $detalleventas->appendChild($subnodo);
  $subnodo = $xml->createElement('baseImpGrav', $baseimpgrav);
  $subnodo = $detalleventas->appendChild($subnodo);
  $subnodo = $xml->createElement('montoIva', $iva);
  $subnodo = $detalleventas->appendChild($subnodo);
  $subnodo = $xml->createElement('valorRetIva', $retiva);
  $subnodo = $detalleventas->appendChild($subnodo);
  $subnodo = $xml->createElement('valorRetRenta', $retfuente);
  $subnodo = $detalleventas->appendChild($subnodo);

  $i++;
  } */


//fin ventas facturas tipo 18**********
//fin ventas *******************************************************************
//inicio ventasEstablecimiento **************************************************************
for ($auxi = 0; $auxi < count($array_factureroventas); $auxi++) {


    $codestab = $array_factureroventas[$auxi]["establecimiento"];
    $subtotal = $array_factureroventas[$auxi]["subtotal"];

    $ventaest = $xml->createElement('ventaEst');
    $ventaest = $ventasestablecimiento->appendChild($ventaest);

    $subnodo = $xml->createElement('codEstab', $codestab);
    $subnodo = $ventaest->appendChild($subnodo);
    $subnodo = $xml->createElement('ventasEstab', number_format($subtotal, 2, ".", ""));
    $subnodo = $ventaest->appendChild($subnodo);
}
//fin ventasEstablecimiento *****************************************************************
//inicio anulados **************************************************************
$query_anulados = "SELECT f.serie1, f.serie2, f.autorizacion, f.codigo_factura
  FROM facturas f
  WHERE (f.anulado = 1) AND (f.fecha BETWEEN '$fechainicio' AND '$fechafin')";
$res_a = mysql_query($query_anulados, $conn);
$i = 0;
while ($i < mysql_num_rows($res_a)) {
    $detalleanulados = $xml->createElement('detalleAnulados');
    $detalleanulados = $anulados->appendChild($detalleanulados);

    $establecimiento = mysql_result($res_a, $i, "serie1");
    $puntoemision = mysql_result($res_a, $i, "serie2");
    $secuencial = mysql_result($res_a, $i, "codigo_factura");
    $autorizacion = mysql_result($res_a, $i, "autorizacion");

    $subnodo = $xml->createElement('tipoComprobante', '01');
    $subnodo = $detalleanulados->appendChild($subnodo);
    $subnodo = $xml->createElement('establecimiento', $establecimiento);
    $subnodo = $detalleanulados->appendChild($subnodo);
    $subnodo = $xml->createElement('puntoEmision', $puntoemision);
    $subnodo = $detalleanulados->appendChild($subnodo);
    $subnodo = $xml->createElement('secuencialInicio', $secuencial);
    $subnodo = $detalleanulados->appendChild($subnodo);
    $subnodo = $xml->createElement('secuencialFin', $secuencial);
    $subnodo = $detalleanulados->appendChild($subnodo);
    $subnodo = $xml->createElement('autorizacion', $autorizacion);
    $subnodo = $detalleanulados->appendChild($subnodo);


    $i++;
}

//fin anulados *****************************************************************
//fin xml ruta de almacenamiento ***********************************************
$xml->formatOutput = true;
$xml->saveXML();
$nombrearchivo = $mes_contable . "_" . $ano;
$xml->save('c:\ats\\' . $nombrearchivo . '.xml');
?>

                        <br/>
                        <table class="fuente8" width="25%" cellspacing=0 cellpadding=3 border=1>
                            <tr>
                                <td colspan="2" align = "center"><b>FACTURAS ANULADAS</b></td>
                            </tr>
                            <tr>
                                <td><b>Total Anuladas</b></td>
                                <td><?php  echo $i; ?></td>                                                                
                            </tr>
                        </table>

                        <br/> 

                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor = cursor">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>