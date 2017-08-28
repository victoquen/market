<?php

require('fpdf/fpdf.php');

include("../js/fechas.php");
include("../conexion/conexion.php");
include("numletras/numletras.php");

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$numero = new EnLetras();



//porcentaje iva parametrizable------------------------------------------------------------------------------------------------------------------
$sel_iva = "select porcentaje FROM iva where activo=1 AND borrado=0";
$rs_iva = mysql_query($sel_iva, $conn);
$ivaporcetaje = mysql_result($rs_iva, 0, "porcentaje");
//fin porcentaje iva parametrizable--------------------------------------------------------------------------------------------------------------

$idfactura_request = $_REQUEST["idfactura"];

//$ids_array = split(",",$idfactura_request);


$ids_array = explode(",", $idfactura_request);

//$ids_array = json_decode($idfactura_request);
//echo "<script>";
//echo "alert(" . count($ids_array). " );";
//echo "</script>";

$n= count($ids_array);

//$n=2;
$pdf = new FPDF();
for ($j = 0; $j < $n; $j++) {

    //$idfactura = $j+1;
    $idfactura = $ids_array[$j];

    $query = "SELECT *, DATE_ADD(fecha,INTERVAL (plazo*30) DAY) as fecha_venc FROM facturas WHERE id_factura='$idfactura'";
    $rs_query = mysql_query($query, $conn);

    $codfactura = mysql_result($rs_query, 0, "codigo_factura");
    $serie1 = mysql_result($rs_query, 0, "serie1");
    $serie2 = mysql_result($rs_query, 0, "serie2");
    $autorizacion = mysql_result($rs_query, 0, "autorizacion");
    $idcliente = mysql_result($rs_query, 0, "id_cliente");
    $fecha = mysql_result($rs_query, 0, "fecha");
    $fecha_venc = mysql_result($rs_query, 0, "fecha_venc");
    $credito = mysql_result($rs_query, 0, "credito");
    $plazo = mysql_result($rs_query, 0, "plazo");


    $descuento = mysql_result($rs_query, 0, "descuento");
    $iva0 = mysql_result($rs_query, 0, "iva0");
    $iva12 = mysql_result($rs_query, 0, "iva12");
    $importeiva = mysql_result($rs_query, 0, "iva");
    $flete = mysql_result($rs_query, 0, "flete");
    $totalfactura = mysql_result($rs_query, 0, "totalfactura");
    $baseimponible = $totalfactura - $flete - $importeiva + $descuento;


    //inicio datos cliente ------------------------------------------------------------------------------------------------------------------
    $sel_cliente = "SELECT * FROM cliente WHERE id_cliente='$idcliente'";
    $rs_cliente = mysql_query($sel_cliente, $conn);

    $nombre_cliente = mysql_result($rs_cliente, 0, "nombre");
    $ci_ruc = mysql_result($rs_cliente, 0, "ci_ruc");
    $empresa = mysql_result($rs_cliente, 0, "empresa");
    $direccion = mysql_result($rs_cliente, 0, "direccion");
    $lugar = mysql_result($rs_cliente, 0, "lugar");
    $tipo_cliente = mysql_result($rs_cliente, 0, "codigo_tipocliente");


    $sel_fono = "SELECT numero FROM clientefono WHERE id_cliente='$idcliente'";
    $rs_fono = mysql_query($sel_fono, $conn);
    if (mysql_num_rows($rs_fono) > 0) {
        $telefono = mysql_result($rs_fono, 0, "numero");
    } else {
        $telefono = "-----";
    }
//fin datos cliente -----------------------------------------------------------------------------------------------------------------------------

//inicio forma de pago  ------------------------------------------------------------------------------------------------------------------
    $efectivo = 0;
    $dineroelectronico = 0;
    $tarjetacredito = 0;
    $otros = 0;

    $sel_fp = "SELECT f.nombre as nombre, c.importe as importe FROM formapago f INNER JOIN cobros c ON f.id_formapago = c.id_formapago WHERE c.id_factura='$idfactura'";
    $rs_fp = mysql_query($sel_fp, $conn);

    $totalformaspago = mysql_num_rows($rs_fp);

    for ($i = 0; $i < $totalformaspago; $i++) {
        $fpdescripcion = mysql_result($rs_fp, $i, "nombre");
        if (strcmp($fpdescripcion, "EFECTIVO") == 0) {
            $efectivo = mysql_result($rs_fp, $i, "importe");
        } else {
            if (strcmp($fpdescripcion, "DINERO ELECTRONICO") == 0) {
                $dineroelectronico = mysql_result($rs_fp, $i, "importe");
            } else {
                if (strcmp($fpdescripcion, "TARJETA DE CREDITO") == 0) {
                    $tarjetacredito = mysql_result($rs_fp, $i, "importe");
                } else {
                    $otros = $otros + mysql_result($rs_fp, $i, "importe");
                }
            }
        }
    }

//fin forma de pago ------------------------------------------------------------------------------------------------------------------

    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    //$pdf->Text(40, 10, $nombre_cliente);
    $pdf->Text(40, 10, $idfactura);

    $pdf->Text(40, 25, $ci_ruc);
    $pdf->Text(100, 25, $fecha);

    $pdf->Text(40, 30, $direccion);



    $sel_lineas = "SELECT b.codigo as codigo, b.nombre as nombre, a.cantidad as cantidad, a.precio as precio, 
                    a.subtotal as subtotal, a.dcto as dcto, a.iva as iva 
                    FROM factulinea a INNER JOIN producto b ON a.id_producto=b.id_producto 
                    WHERE a.id_factura = '$idfactura'";
    $rs_lineas = mysql_query($sel_lineas, $conn);

    $totalfilas = mysql_num_rows($rs_lineas);

    $coord_y= 40;
    for ($i = 0; $i < $totalfilas; $i++) {
        $coord_x = 10;


        $codarticulo = mysql_result($rs_lineas, $i, "codigo");
        $codarticulo = substr($codarticulo, 0, 7);

        $descripcion = mysql_result($rs_lineas, $i, "nombre");
        $cantidad = mysql_result($rs_lineas, $i, "cantidad");
        $precio = mysql_result($rs_lineas, $i, "precio");
        $subtotal = mysql_result($rs_lineas, $i, "subtotal");

        $pdf->Text($coord_x, $coord_y, number_format($cantidad, 2));
        $coord_x+=20;
        $pdf->Text($coord_x, $coord_y, substr(utf8_decode($descripcion), 0, 50));
        $coord_x+=150;
        $pdf->Text($coord_x, $coord_y, number_format($precio, 2));
        $coord_x+=15;
        $pdf->Text($coord_x, $coord_y, number_format($subtotal, 2));
        $coord_y+=5;
    }



    $pdf->Text(100, 90, number_format($baseimponible, 2));
    $pdf->Text(100, 95, number_format($iva0, 2));
    $pdf->Text(70, 100, number_format($ivaporcetaje, 2));
    $pdf->Text(100, 100, number_format($iva12, 2));
    $pdf->Text(100, 105, number_format($descuento, 2));
    $pdf->Text(100, 110, number_format($importeiva, 2));
    $pdf->Text(100, 115, number_format($totalfactura, 2));


}
$pdf->Output();

// Show PDF
$pdf->IncludeJS("print('true');");

$pdf->Output();
?>