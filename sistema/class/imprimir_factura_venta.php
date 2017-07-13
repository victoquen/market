<?php
/**
 * Created by PhpStorm.
 * User: VICTOR OQUENDO
 * Date: 5/23/2017
 * Time: 10:56 PM
 */

date_default_timezone_set('America/Guayaquil');


require_once('../config/config.configurar.php');
define('FPDF_FONTPATH', '../font');

include("../js/fechas.php");
include("../conexion/conexion.php");
include("class.clfpdf.php");

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();
$id = $_GET["id"];


/*$idx = $id;

$id = str_replace("v-", "", $id);
$id = str_replace("-v", "", $id);
$id = str_replace("/valor", "", $id);

if ($id == ""){
    $id = 0;
}*/

define('FPDF_FONTPATH',FONT_PATH);
include_once ( CLASS_PATH . "class.clfpdf.php" );

//Limpia el buffer si no sale un error
ob_end_clean();

$nombrearchivo = date("YmdHis").".pdf";


$query = new clQuery();


$tipopapel = "Personal";
$ancho = 145;
$largo = 200;
$distancia = 5;

$coordenadas[0][0] = 15;
$coordenadas[0][1] = 58;
$coordenadas[1][0] = 15;
$coordenadas[1][1] = 38;
$coordenadas[2][0] = 15;
$coordenadas[2][1] = 48;
$coordenadas[3][0] = 75;
$coordenadas[3][1] = 48;
$coordenadas[4][0] = 15;
$coordenadas[4][1] = 73;
$coordenadas[5][0] = 28;
$coordenadas[5][1] = 73;
$coordenadas[6][0] = 90;
$coordenadas[6][1] = 73;
$coordenadas[7][0] = 115;
$coordenadas[7][1] = 73;
$coordenadas[8][0] = 115;
$coordenadas[8][1] = 158;
$coordenadas[9][0] = 115;
$coordenadas[9][1] = 168;
$coordenadas[10][0] = 115;
$coordenadas[10][1] = 182;
$coordenadas[11][0] = 115;
$coordenadas[11][1] = 163;
$coordenadas[12][0] = 115;
$coordenadas[12][1] = 175;
$coordenadas[13][0] = 108;
$coordenadas[13][1] = 45;
$coordenadas[14][0] = 118;
$coordenadas[14][1] = 45;
$coordenadas[15][0] = 128;
$coordenadas[15][1] = 45;
$coordenadas[16][0] = 118;
$coordenadas[16][1] = 55;
$coordenadas[17][0] = 50;
$coordenadas[17][1] = 58;
$coordenadas[18][0] = 85;
$coordenadas[18][1] = 58;




//create a FPDF object
$pdf = new FPDF('P' , 'mm' , $tipopapel, $ancho, $largo);

//set document properties
$pdf->SetAuthor("Personal");
$pdf->SetTitle("Home");

//encabezado
$pdf->logoencabezado = -1;
$pdf->logopiepagina = -1;
$pdf->Header();
//
//Envia a otra pagina
$pdf->setAutoPagebreak(true,'');

//set font for the entire document
$pdf->SetFont('Arial','B',35);
//$pdf->SetTextColor(50,60,100);

//set up a page
$pdf->AddPage('P');
$pdf->SetDisplayMode(75,'default');

$sql = "SELECT
                      tventa.comid,
                      tdetalleventa.detvenid,
                      CONCAT(tcliente.clinombres, ' ', tcliente.cliapellidos) AS clicliente,
                      DATE_FORMAT(venfecha, '%Y-%m-%d %H:%i:%s %p') AS venfecha,
                      DATE_FORMAT(venfecha, '%Y') AS venfechaanio,
                      DATE_FORMAT(venfecha, '%m') AS venfechames,
                      DATE_FORMAT(venfecha, '%d') AS venfechadia,
                      IF (tcliente.clicedula = '0000000000', '***************', tcliente.clidireccion) AS clidireccion,
                      tcliente.clitelefono,
                      IF (tcliente.cliruc = '' OR tcliente.cliruc IS NULL, tcliente.clicedula, tcliente.cliruc) AS clicedularuc,
                      tventa.vendescuento,
                      tventa.retfuecodigo,
                      tventa.retivacodigo,   
                      tdetalleventa.ivacodigo,
                      tdetalleventa.detvencantidad,
                      tproducto.prodescripcion,
                      (tdetalleventa.detvenpreciounitario - (tdetalleventa.detvenpreciounitario * tventa.vendescuento * 0.01)) AS detvenpreciounitario,
                      (SELECT ttipopago.tippagdescripcion FROM ttipopago WHERE ttipopago.tippagcodigo = tventa.tippagcodigo) AS formapago,
                      0 AS guiaremision,
                      '". $_SESSION["usuario"]["cantondescripcion"] ."' AS lugar,                      
                      (tdetalleventa.detvencantidad * (tdetalleventa.detvenpreciounitario - (tdetalleventa.detvenpreciounitario * tventa.vendescuento * 0.01))) AS detvensubtotalitem,
                      CAST((tdetalleventa.detvencantidad * tdetalleventa.detvenpreciounitario * tventa.vendescuento * 0.01) * ( 1 + (tdetalleventa.ivacodigo * 0.01)) AS DECIMAL(18,4)) AS detvendescuento,
                      CAST(((tdetalleventa.detvencantidad * tdetalleventa.detvenpreciounitario * (tdetalleventa.ivacodigo * 0.01)) - (tdetalleventa.detvencantidad * tdetalleventa.detvenpreciounitario * (tdetalleventa.ivacodigo * 0.01) * (tventa.vendescuento * 0.01))) AS DECIMAL(18,4)) AS detvenivacondescuento,
                      CAST((tdetalleventa.detvencantidad * tdetalleventa.detvenpreciounitario * (tdetalleventa.ivacodigo * 0.01)) AS DECIMAL(18,4)) AS detvenivasindescuento
                    FROM
                      tventa
                      INNER JOIN tdetalleventa ON
                      tventa.venid = tdetalleventa.venid
                      INNER JOIN tcliente ON
                      tventa.cliid = tcliente.cliid
                      INNER JOIN tstock ON
                      tdetalleventa.stoid = tstock.stoid
                      INNER JOIN tproducto ON
                      tstock.proid = tproducto.proid
                    WHERE
                      tventa.venid = ". $id;

$sql = "SELECT 
          c.nombre as clicliente,
          c.direccion as clidireccion,
          c.ci_ruc as clicedularuc,
          f.descuento as detvendescuento,
          f.ret_iva as retivacodigo,
          f.ret_fuente as retfuecodigo,
          
          
          DATE_FORMAT(venfecha, '%Y') AS venfechaanio,
          DATE_FORMAT(venfecha, '%m') AS venfechames,
          DATE_FORMAT(venfecha, '%d') AS venfechadia,
          
        FROM facturas f 
        INNER JOIN cliente c ON f.id_cliente = c.id_cliente
        WHERE id_factura='$id'";


$resultado = $query->getStrQuery($sql);

if( count($resultado) > 0 ) {
    $i = 0;
//                $x = 0;
//                $y = 0;
//                $k = 0;

    $subtotalventa = 0;
    $ivaventacondescuento = 0;
    $ivaventasindescuento = 0;
    $descuento = 0;
    $totalventa = 0;
    $descuentoporcentaje = 0;
    $retencionfuente = 0;
    $retencioniva  = 0;

    $tarifaconiva = 0;
    $tarifasiniva = 0;

    $pdf->SetFont('Arial','',6);
    while ($rst = mysql_fetch_array($resultado)) {
        if ($i == 0){


            
            

            $pdf->Text($coordenadas[1][0],$coordenadas[1][1], utf8_decode($rst["clicliente"]));
            $pdf->Text($coordenadas[2][0],$coordenadas[2][1], utf8_decode($rst["clidireccion"]));
            $pdf->Text($coordenadas[3][0],$coordenadas[3][1], utf8_decode($rst["clitelefono"]));
            $pdf->Text($coordenadas[13][0],$coordenadas[13][1], utf8_decode($rst["venfechadia"]));
            $pdf->Text($coordenadas[14][0],$coordenadas[14][1], utf8_decode($rst["venfechames"]));
            $pdf->Text($coordenadas[15][0],$coordenadas[15][1], utf8_decode($rst["venfechaanio"]));
            $pdf->Text($coordenadas[0][0],$coordenadas[0][1], utf8_decode($rst["clicedularuc"]));
            $pdf->Text($coordenadas[17][0],$coordenadas[17][1], utf8_decode($rst["formapago"]));
            $pdf->Text($coordenadas[18][0],$coordenadas[18][1], utf8_decode($rst["guiaremision"]));
            $pdf->Text($coordenadas[16][0],$coordenadas[16][1], utf8_decode($rst["lugar"]));





            $i = 1;

        }


        $pdf->Text($coordenadas[4][0],$coordenadas[4][1], $rst["detvencantidad"]);
        $pdf->SetXY($coordenadas[5][0], $coordenadas[5][1] - 3);





        $ValorX = $pdf->GetX();

        $serie_descripcion = "";
        $sql_serie = "SELECT
                                    CONCAT('SERIE N°: ', tserie.sercodigo, ' ', CHAR(13)) AS seriecodigo,
                                    tserie.serdescripcion,
                                    (SELECT COUNT(s.sercodigo) FROM tserie AS s WHERE s.serdescripcion LIKE '%Moto%' AND s.detvenid = ". $rst["detvenid"] ." LIMIT 0,1) AS serproductomoto
                                  FROM
                                    tserie                                    
                                  WHERE
                                    tserie.detvenid = ". $rst["detvenid"];

        $resultado_serie = $query->getStrQuery($sql_serie);
        while ($rst_serie = mysql_fetch_array($resultado_serie)) {
            if ($rst_serie["serproductomoto"] > 0){
                $serie_descripcion .= $rst_serie["serdescripcion"]."\n";
            }else{
                $serie_descripcion .= $rst_serie["seriecodigo"]."\n".$rst_serie["serdescripcion"]."\n";
            }

        }
        mysql_free_result($resultado_serie);
        if($serie_descripcion == ""){
            $pdf->MultiCell(60,5, utf8_decode($rst["prodescripcion"]), 0, "J");
        }else{
            $pdf->MultiCell(60,5, utf8_decode($rst["prodescripcion"]."\n".($serie_descripcion)), 0, "J");
        }


        $pdf->Text($coordenadas[6][0],$coordenadas[6][1], number_format($rst["detvenpreciounitario"],2,',','.'));
        $pdf->Text($coordenadas[7][0],$coordenadas[7][1], number_format($rst["detvensubtotalitem"],2,',','.'));

        $coordenadas[5][1] = $pdf->GetY() + $distancia;
        $coordenadas[4][1] = $coordenadas[5][1];
        $coordenadas[6][1] = $coordenadas[5][1];
        $coordenadas[7][1] = $coordenadas[5][1];

        if ($rst["ivacodigo"] != 0){
            $tarifaconiva += $rst["detvensubtotalitem"];
        }else{
            $tarifasiniva += $rst["detvensubtotalitem"];
        }
        //$y = $y + $distancia;
        //$y = $coordenadas[5][1];

        $subtotalventa += $rst["detvensubtotalitem"];
        $descuento = $descuento + $rst["detvendescuento"];
        $ivaventacondescuento = $ivaventacondescuento + $rst["detvenivacondescuento"];
        $ivaventasindescuento = $ivaventasindescuento + $rst["detvenivasindescuento"];

        $descuentoporcentaje = $rst["vendescuento"] * 0.01;
        $retencionfuente = $rst["retfuecodigo"] * 0.01;
        $retencioniva = $rst["retivacodigo"] * 0.01;
    }

    if($descuento == 0){
        $totalventa = $subtotalventa + $ivaventasindescuento;
    }else{
        $totalventa = $subtotalventa + $ivaventacondescuento;
    }

    $pdf->SetX($ValorX);
    $pdf->MultiCell(60,5, utf8_decode("Descuento $ ". number_format($descuento, 2)), 0, "J");

    //Para cuadrar con las retenciones
    //$subtotalventa = $subtotalventa - ($subtotalventa * $descuentoporcentaje);
//                $retencionfuente = $subtotalventa * $retencionfuente;
//                $retencioniva = $ivaventacondescuento * $retencioniva;
    // $totalventa = ($subtotalventa + $ivaventacondescuento) - ($retencionfuente + $retencioniva);

    $pdf->Text($coordenadas[8][0],$coordenadas[8][1], number_format($subtotalventa,2,',','.'));
    $pdf->Text($coordenadas[9][0],$coordenadas[9][1], number_format($tarifaconiva,2,',','.'));
    $pdf->Text($coordenadas[10][0],$coordenadas[10][1], number_format($totalventa,2,',','.'));
    $pdf->Text($coordenadas[11][0],$coordenadas[11][1], number_format($tarifasiniva,2,',','.'));

    if($descuento == 0){
        $pdf->Text($coordenadas[12][0],$coordenadas[12][1], number_format($ivaventasindescuento,2,',','.'));
    }else{
        $pdf->Text($coordenadas[12][0],$coordenadas[12][1], number_format($ivaventacondescuento,2,',','.'));
    }

}else{
    $pdf->SetFont('Arial','B',20);
    $pdf->Text(30, (int) ($largo/2) , utf8_decode('ERROR INTERNO. INTENTE NUEVAMENTE !!!!!!'));
}

//Libera de la memoria el script
mysql_free_result($resultado);

//Pie Pagina
$pdf->Footer();

//Para poner la Pagina 1/(1...n)
$pdf->AliasNbPages();

//Output the document
//$nombrearchivo = date("YmdHis").'.pdf';
$pdf->Output($nombrearchivo,'D');

?>