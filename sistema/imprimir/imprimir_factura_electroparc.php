<?php

error_reporting(0);
include("../js/fechas.php");
include("../conexion/conexion.php");
include("numletras/numletras.php");

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$numero = new EnLetras();


// inicio datos factura ------------------------------------------------------------------------------------------------------------------
$idfactura = $_GET["idfactura"];

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

$vecFecha = (split("-", $fecha));
$dia = $vecFecha[2];
$mes = $vecFecha[1];
$anio = $vecFecha[0];


$descuento = mysql_result($rs_query, 0, "descuento");
$iva0 = mysql_result($rs_query, 0, "iva0");
$iva12 = mysql_result($rs_query, 0, "iva12");
$importeiva = mysql_result($rs_query, 0, "iva");
$flete = mysql_result($rs_query, 0, "flete");
$totalfactura = mysql_result($rs_query, 0, "totalfactura");
$baseimponible = $totalfactura - $flete - $importeiva + $descuento;

//fin datos factura --------------------------------------------------------------------------------------------------------------------


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


//porcentaje iva parametrizable------------------------------------------------------------------------------------------------------------------
$sel_iva = "select porcentaje FROM iva where activo=1 AND borrado=0";
$rs_iva = mysql_query($sel_iva, $conn);
$ivaporcetaje = mysql_result($rs_iva, 0, "porcentaje");
//fin porcentaje iva parametrizable--------------------------------------------------------------------------------------------------------------

//inicio forma de pago  ------------------------------------------------------------------------------------------------------------------
/*$efectivo=0;
$dineroelectronico=0;
$tarjetacredito = 0;*/
$efectivo = "";
$dineroelectronico = "";
$tarjetacredito = "";
$otros = "";

$sel_fp = "SELECT f.nombre as nombre, c.importe as importe FROM formapago f INNER JOIN cobros c ON f.id_formapago = c.id_formapago WHERE c.id_factura='$idfactura'";
$rs_fp = mysql_query($sel_fp, $conn);

$totalformaspago = mysql_num_rows($rs_fp);

for ($i = 0; $i < $totalformaspago; $i++) {
    $fpdescripcion = mysql_result($rs_fp, $i, "nombre");
    if (strcmp($fpdescripcion, "EFECTIVO") == 0) {
        $efectivo = "X";
        //$efectivo =  mysql_result($rs_fp, $i, "importe");
    } else {
        if (strcmp($fpdescripcion, "DINERO ELECTRONICO") == 0) {
            $dineroelectronico = "X";
            //$dineroelectronico =  mysql_result($rs_fp, $i, "importe");
        } else {
            if (strcmp($fpdescripcion, "TARJETA DE CREDITO") == 0) {
                $tarjetacredito = "X";
                //$tarjetacredito =  mysql_result($rs_fp, $i, "importe");
            } else {
                //$otros = $otros + mysql_result($rs_fp, $i, "importe");
                if (strcmp($fpdescripcion, "TRANSFERENCIAS") == 0) {
                    $otros = "TRANSFERENCIA";
                }
                if (strcmp($fpdescripcion, "CHEQUE") == 0) {
                    $otros = "CHEQUE";
                }

                if (strcmp($fpdescripcion, "DEPOSITO") == 0) {
                    $otros = "DEPOSITO";
                }
            }
        }
    }
}

//fin forma de pago ------------------------------------------------------------------------------------------------------------------

class Pro
{
    public $cantidad;
    public $descripcion;
    public $precio;
    public $subtotal;
}

$sel_lineas = "SELECT b.codigo as codigo, b.nombre as nombre, a.cantidad as cantidad, a.precio as precio, a.subtotal as subtotal, a.dcto as dcto, a.iva as iva, b.moto as moto, a.id_factulinea as id_factulinea
                FROM factulinea a INNER JOIN producto b ON a.id_producto=b.id_producto 
               
                WHERE a.id_factura = '$idfactura'";
$rs_lineas = mysql_query($sel_lineas, $conn);

$productos_array = array();
$totalfilas = mysql_num_rows($rs_lineas);

$moto = mysql_result($rs_lineas, 0, "moto");
$id_factulinea = mysql_result($rs_lineas, 0, "id_factulinea");
if ($moto == 1) {

    $sel_serie = "SELECT serie
                    FROM productoserie 
                    WHERE id_factulinea = '$id_factulinea'";
    $rs_serie = mysql_query($sel_serie, $conn);
    $serie = strtoupper(mysql_result($rs_serie, 0, "serie"));

    $cont_palabras = 0;
    $palabras = array('MODELO', 'COLOR', 'CPN', 'MOTOR', 'CHASIS', 'CILINDRAJE', 'AÑO',  'CAPACIDAD', 'TONELAJE', 'PAIS');
    $n = sizeof($palabras);
    for ($i = 0; $i < $n; $i++) {
        $pos = strpos($serie, $palabras[$i]);
        if ($pos === false) {
            //$serie = substr_replace($serie, ';', 0, 0);
        } else {
            if($pos != 0){
                $serie = substr_replace($serie, ';', $pos, 0);
            }
            $cont_palabras++;
        }
    }
    $seriales = explode(';', $serie);
    //$m =count($seriales);



    $codarticulo = mysql_result($rs_lineas, 0, "codigo");
    $codarticulo = substr($codarticulo, 0, 7);

    $descripcion = mysql_result($rs_lineas, 0, "nombre");
    $cantidad = mysql_result($rs_lineas, 0, "cantidad");
    $precio = mysql_result($rs_lineas, 0, "precio");
    $subtotal = mysql_result($rs_lineas, 0, "subtotal");

    $myPro = new Pro();
    $myPro->cantidad = $cantidad;
    $myPro->descripcion = $descripcion;
    $myPro->precio = $precio;
    $myPro->subtotal = $subtotal;
    $productos_array[] = $myPro;


    for($j=0; $j<$cont_palabras; $j++){
        $myPro = new Pro();
        $myPro->cantidad = "";
        $myPro->descripcion = $seriales[$j];
        $myPro->precio = "";
        $myPro->subtotal = "";
        $productos_array[] = $myPro;
    }


} else {
    for ($i = 0; $i < $totalfilas; $i++) {

        $myPro = new Pro();
        $codarticulo = mysql_result($rs_lineas, $i, "codigo");
        $codarticulo = substr($codarticulo, 0, 7);


        $descripcion = mysql_result($rs_lineas, $i, "nombre");
        $cantidad = mysql_result($rs_lineas, $i, "cantidad");
        $precio = mysql_result($rs_lineas, $i, "precio");
        $subtotal = mysql_result($rs_lineas, $i, "subtotal");

        $myPro->cantidad = $cantidad;
        $myPro->descripcion = $descripcion;
        $myPro->precio = $precio;
        $myPro->subtotal = $subtotal;
        $productos_array[] = $myPro;

        /*
        $productos_array[$i][0]=$cantidad;
        $productos_array[$i][1]=$descripcion;
        $productos_array[$i][2]=$precio;
        $productos_array[$i][3]=$subtotal;
        */

    }
}


$productos_sent = json_encode($productos_array);
//echo $productos_sent;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <script src="../js/jspdf.min.js"></script>
</head>
<body>


</body>


<script>
    //var print = function (){

    //    console.log('hello world');

    var doc = new jsPDF('p', 'mm', [194, 146]);

    var x = -2;
    var y = -18;
    doc.setFontSize(11);
    //doc.text(x+100, y+25, '006515050505');//numfac
    doc.setFontSize(8);
    doc.text(x + 5, y + 42, '<?php  echo $nombre_cliente?>');//nombre cliente

    doc.text(x + 103, y + 45, '<?php  echo $dia?>');//dia

    doc.text(x + 111, y + 45, '<?php  echo $mes?>');//mes

    doc.text(x + 120, y + 45, '<?php  echo $anio?>');//anio
    var direccion = '<?php  echo $direccion?>';//direccion
    var sub = direccion.substring(0, 55);//direccion
    doc.text(x + 5, y + 50, sub);//direccion
    doc.text(x + 80, y + 50, '0987595254');//telefono

    doc.text(x + 5, y + 60, '<?php  echo $ci_ruc?>');//ci_ruc
    doc.text(x + 35, y + 60, '<?php  echo $fpdescripcion?>');//forma de pago


    doc.text(x + 111, y + 55, 'RIOBAMBA');//LUGAR


    var xx = x + 10;
    var aux_xx = xx;
    var yy = y + 78;
    doc.setFontSize(6);

    var prod_array = (<?php  echo $productos_sent;?>);
    var n = prod_array.length;

    for (var i = 0; i < n; i++) {
        //doc.text(xx, yy, listaProductos[0].cantidad.toString());//cantidad
        doc.text(xx, yy, prod_array[i].cantidad);//cantidad

        xx += 11;
        //var sub= listaProductos[0].detalle.toString().substring(0,45);
        var sub = prod_array[i].descripcion.substring(0, 45);

        doc.text(xx, yy, sub);//detalle
        xx += 69;

        //doc.text(xx, yy, listaProductos[0].precioUnitario.toString());//precio unitario
        doc.text(xx, yy, prod_array[i].precio);//precio unitario

        xx += 25;
        //doc.text(xx, yy, listaProductos[0].valorTotal.toString());//valor total
        doc.text(xx, yy, prod_array[i].subtotal);//valor total

        yy += 5.8;
        xx = aux_xx;
    }


    xx += 11 + 70 + 25;
    yy += 12;
    var yyy = 12 + 68.8 + y + 78 - 5.8;
    doc.text(xx, yyy, '<?php echo $baseimponible;?>');//sub total
    yyy += 5.8;
    doc.text(xx, yyy, '<?php echo $descuento;?>');//descuento
    yyy += 5.8;
    doc.text(xx, yyy, '<?php echo $iva0;?>');//iva tari 0%
    yyy += 5.8;
    doc.text(xx, yyy, '<?php echo $iva12;?>');//iva tarifa % configurable
    yyy += 5.8;
    doc.text(xx, yyy, '<?php echo $importeiva;?>');//importe del iva
    yyy += 5.8;
    doc.text(xx, yyy, '<?php echo $totalfactura;?>');//valor total
    yyy += 5.8;
    doc.save('Test.pdf');

    //}
</script>

</html>