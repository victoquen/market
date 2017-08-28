<?php

require('fpdf/fpdf.php');

include("../js/fechas.php");
include("../conexion/conexion.php");
include("numletras/numletras.php");

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$numero = new EnLetras();


// own pdf structure

class MYPDF extends FPDF
{

    var $javascript;
    var $n_js;

    function IncludeJS($script)
    {
        $this->javascript = $script;
    }

    function _putjavascript()
    {
        $this->_newobj();
        $this->n_js = $this->n;
        $this->_out('<<');
        $this->_out('/Names [(EmbeddedJS) ' . ($this->n + 1) . ' 0 R]');
        $this->_out('>>');
        $this->_out('endobj');
        $this->_newobj();
        $this->_out('<<');
        $this->_out('/S /JavaScript');
        $this->_out('/JS ' . $this->_textstring($this->javascript));
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putresources()
    {
        parent::_putresources();
        if (!empty($this->javascript)) {
            $this->_putjavascript();
        }
    }

    function _putcatalog()
    {
        parent::_putcatalog();
        if (!empty($this->javascript)) {
            $this->_out('/Names <</JavaScript ' . ($this->n_js) . ' 0 R>>');
        }
    }

    // Margins
//   var $left = 10;
//   var $right = 10;
//   var $top = 28;
//   var $bottom = 10;
    // Create Table
    function WriteTable($tcolums)
    {
        // go through all colums
        for ($i = 0; $i < sizeof($tcolums); $i++) {
            $current_col = $tcolums[$i];
            $height = 0;

            // get max height of current col
            $nb = 0;
            for ($b = 0; $b < sizeof($current_col); $b++) {
                // set style
                $this->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetFillColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['textcolor']);
                $this->SetTextColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);
                $this->SetLineWidth($current_col[$b]['linewidth']);

                $nb = max($nb, $this->NbLines($current_col[$b]['width'], $current_col[$b]['text']));
                $height = $current_col[$b]['height'];
            }
            $h = $height * $nb;

            // Issue a page break first if needed
            $this->CheckPageBreak($h);

            // Draw the cells of the row
            for ($b = 0; $b < sizeof($current_col); $b++) {
                $w = $current_col[$b]['width'];
                $a = $current_col[$b]['align'];

                // Save the current position
                $x = $this->GetX();
                $y = $this->GetY();

                // set style
                $this->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetFillColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['textcolor']);
                $this->SetTextColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);
                $this->SetLineWidth($current_col[$b]['linewidth']);

                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);


                // Draw Cell Background
                $this->Rect($x, $y, $w, $h, 'FD');

                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);

                // Draw Cell Border
                if (substr_count($current_col[$b]['linearea'], "T") > 0) {
                    $this->Line($x, $y, $x + $w, $y);
                }

                if (substr_count($current_col[$b]['linearea'], "B") > 0) {
                    $this->Line($x, $y + $h, $x + $w, $y + $h);
                }

                if (substr_count($current_col[$b]['linearea'], "L") > 0) {
                    $this->Line($x, $y, $x, $y + $h);
                }

                if (substr_count($current_col[$b]['linearea'], "R") > 0) {
                    $this->Line($x + $w, $y, $x + $w, $y + $h);
                }

                // Print the text
                $this->MultiCell($w, $current_col[$b]['height'], $current_col[$b]['text'], 0, $a, 0);

                // Put the position to the right of the cell
                $this->SetXY($x + $w, $y);
            }

            // Go to the next line
            $this->Ln($h);
        }
    }

    // If the height h would cause an overflow, add a new page immediately
    function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    // Computes the number of lines a MultiCell of width w will take
    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}

$pdf = new MYPDF('P', 'mm', array(213, 149));
$pdf->AliasNbPages();
$pdf->SetMargins(9, 47);
$pdf->SetAutoPageBreak(true, 6);



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



//$pdf = new MYPDF('L', 'mm', array(149,213));


    $pdf->AddPage();


//$pdf->SetFont('Arial','B',12);
// create table
    $columns = array();

// data col
    $col = array();
    $col[] = array('text' => '', 'width' => '18', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col[] = array('text' => implota($fecha), 'width' => '75', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '9', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $columns[] = $col;

    $col = array();
    $col[] = array('text' => '', 'width' => '18', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col[] = array('text' => utf8_decode($nombre_cliente), 'width' => '75', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '9', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $columns[] = $col;

    $col = array();
    $col[] = array('text' => '', 'width' => '15', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col[] = array('text' => utf8_decode($direccion), 'width' => '75', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '9', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $columns[] = $col;

    $col = array();
    $col[] = array('text' => '', 'width' => '20', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col[] = array('text' => $ci_ruc, 'width' => '75', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '9', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col[] = array('text' => '', 'width' => '15', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col[] = array('text' => $telefono, 'width' => '75', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '9', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $columns[] = $col;


// Draw Table
    $pdf->WriteTable($columns);
    $pdf->Ln(9);

    $columns_productos = array();

    $sel_lineas = "SELECT b.codigo as codigo, b.nombre as nombre, a.cantidad as cantidad, a.precio as precio, a.subtotal as subtotal, a.dcto as dcto, a.iva as iva FROM factulinea a INNER JOIN producto b ON a.id_producto=b.id_producto WHERE a.id_factura = '$idfactura'";
    $rs_lineas = mysql_query($sel_lineas, $conn);

    $totalfilas = mysql_num_rows($rs_lineas);
    for ($i = 0; $i < $totalfilas; $i++) {


        $codarticulo = mysql_result($rs_lineas, $i, "codigo");
        $codarticulo = substr($codarticulo, 0, 7);

        $descripcion = mysql_result($rs_lineas, $i, "nombre");
        $cantidad = mysql_result($rs_lineas, $i, "cantidad");
        $precio = mysql_result($rs_lineas, $i, "precio");
        $subtotal = mysql_result($rs_lineas, $i, "subtotal");

        $col_pro = array();
        $col_pro[] = array('text' => $cantidad, 'width' => '15', 'height' => '3.8', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '7', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
        $col_pro[] = array('text' => substr(utf8_decode($descripcion), 0, 100), 'width' => '80', 'height' => '3.8', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '7', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
        $col_pro[] = array('text' => $precio, 'width' => '18', 'height' => '3.8', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '7', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
        $col_pro[] = array('text' => $subtotal, 'width' => '20', 'height' => '3.8', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '7', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');

        $columns_productos[] = $col_pro;
        $cont = $i;
    }

//$h_aux = ((11 - $totalfilas) * 6) + 28;

    $h_aux = ((25 - $totalfilas) * 3.8);
    $col_pro = array();
    $col_pro[] = array('text' => '', 'width' => '194', 'height' => $h_aux, 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $columns_productos[] = $col_pro;


    $col_pro = array();
    $col_pro[] = array('text' => '', 'width' => '103', 'height' => '4', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col_pro[] = array('text' => number_format($baseimponible, 2), 'width' => '30', 'height' => '4', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $columns_productos[] = $col_pro;


    $col_pro = array();
    $col_pro[] = array('text' => '', 'width' => '14', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col_pro[] = array('text' => $efectivo, 'width' => '17', 'height' => '6', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col_pro[] = array('text' => $tarjetacredito, 'width' => '23', 'height' => '6', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col_pro[] = array('text' => $dineroelectronico, 'width' => '17', 'height' => '6', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col_pro[] = array('text' => number_format($otros, 2), 'width' => '10', 'height' => '6', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col_pro[] = array('text' => '', 'width' => '22', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col_pro[] = array('text' => $iva0, 'width' => '30', 'height' => '6', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $columns_productos[] = $col_pro;

    $col_pro = array();
    $col_pro[] = array('text' => '', 'width' => '103', 'height' => '4', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col_pro[] = array('text' => $iva12, 'width' => '30', 'height' => '4', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $columns_productos[] = $col_pro;

    $col_pro = array();
    $col_pro[] = array('text' => '', 'width' => '103', 'height' => '4', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col_pro[] = array('text' => $descuento, 'width' => '30', 'height' => '4', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $columns_productos[] = $col_pro;

    $col_pro = array();
    $col_pro[] = array('text' => '', 'width' => '103', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col_pro[] = array('text' => $importeiva, 'width' => '30', 'height' => '5', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $columns_productos[] = $col_pro;

    /*
    $col_pro = array();
    $col_pro[] = array('text' => '', 'width' => '142', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col_pro[] = array('text' => $flete, 'width' => '47', 'height' => '5', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $columns_productos[] = $col_pro;
    */

    $col_pro = array();
    $col_pro[] = array('text' => '', 'width' => '103', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '10', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $col_pro[] = array('text' => $totalfactura, 'width' => '30', 'height' => '5', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '9', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.2', 'linearea' => '');
    $columns_productos[] = $col_pro;

    $pdf->WriteTable($columns_productos);


// Show PDF
$pdf->IncludeJS("print('true');");

$pdf->Output();
?>