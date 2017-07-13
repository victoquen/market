<?php
require('fpdf/fpdf.php');

include ("../js/fechas.php");
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


// own pdf structure

class MYPDF extends FPDF
{
    
    var $javascript;
    var $n_js;

    function IncludeJS($script) {
        $this->javascript = $script;
    }

    function _putjavascript() {
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

    function _putresources() {
        parent::_putresources();
        if (!empty($this->javascript)) {
            $this->_putjavascript();
        }
    }

    function _putcatalog() {
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
      for ($i = 0; $i < sizeof($tcolums); $i++)
      {
         $current_col = $tcolums[$i];
         $height = 0;

         // get max height of current col
         $nb=0;
         for($b = 0; $b < sizeof($current_col); $b++)
         {
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
         $h=$height*$nb;


         // Issue a page break first if needed
         $this->CheckPageBreak($h);

         // Draw the cells of the row
         for($b = 0; $b < sizeof($current_col); $b++)
         {
            $w = $current_col[$b]['width'];
            $a = $current_col[$b]['align'];

            // Save the current position
            $x=$this->GetX();
            $y=$this->GetY();

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
            if (substr_count($current_col[$b]['linearea'], "T") > 0)
            {
               $this->Line($x, $y, $x+$w, $y);
            }

            if (substr_count($current_col[$b]['linearea'], "B") > 0)
            {
               $this->Line($x, $y+$h, $x+$w, $y+$h);
            }

            if (substr_count($current_col[$b]['linearea'], "L") > 0)
            {
               $this->Line($x, $y, $x, $y+$h);
            }

            if (substr_count($current_col[$b]['linearea'], "R") > 0)
            {
               $this->Line($x+$w, $y, $x+$w, $y+$h);
            }


            // Print the text
            $this->MultiCell($w, $current_col[$b]['height'], $current_col[$b]['text'], 0, $a, 0);

            // Put the position to the right of the cell
            $this->SetXY($x+$w, $y);
         }

         // Go to the next line
         $this->Ln($h);
      }
   }


   // If the height h would cause an overflow, add a new page immediately
   function CheckPageBreak($h)
   {
      if($this->GetY()+$h>$this->PageBreakTrigger)
         $this->AddPage($this->CurOrientation);
   }


   // Computes the number of lines a MultiCell of width w will take
   function NbLines($w, $txt)
   {
      $cw=&$this->CurrentFont['cw'];
      if($w==0)
         $w=$this->w-$this->rMargin-$this->x;
      $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
      $s=str_replace("\r", '', $txt);
      $nb=strlen($s);
      if($nb>0 and $s[$nb-1]=="\n")
         $nb--;
      $sep=-1;
      $i=0;
      $j=0;
      $l=0;
      $nl=1;
      while($i<$nb)
      {
         $c=$s[$i];
         if($c=="\n")
         {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
         }
         if($c==' ')
            $sep=$i;
         $l+=$cw[$c];
         if($l>$wmax)
         {
            if($sep==-1)
            {
               if($i==$j)
                  $i++;
            }
            else
               $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
         }
         else
            $i++;
      }
      return $nl;
   }

}


// inicio datos remision ------------------------------------------------------------------------------------------------------------------
$idremision=$_GET["idremision"];

$query_ret="SELECT id_factura, serie1, serie2, codigo_remision, autorizacion, fecha_fin, motivo, punto_partida, nombre_trans, ci_trans
            FROM remision
            WHERE id_remision=$idremision";
$res_rem=mysql_query($query_ret,$conn);

$idfactura=mysql_result($res_rem,0,"id_factura");

$codigo_remision=mysql_result($res_rem,0,"codigo_remision");
$serie1=mysql_result($res_rem,0,"serie1");
$serie2=mysql_result($res_rem,0,"serie2");
$autorizacion=mysql_result($res_rem,0,"autorizacion");
$fecha_fin=mysql_result($res_rem,0,"fecha_fin");
$motivo=mysql_result($res_rem,0,"motivo");
$punto_partida=mysql_result($res_rem,0,"punto_partida");
$nombre_trans=mysql_result($res_rem,0,"nombre_trans");
$ci_trans=mysql_result($res_rem,0,"ci_trans");


//fin datos remision ------------------------------------------------------------------------------------------------------------------

//inicio datos factura-cliente ------------------------------------------------------------------------------------------------------------------
$query_clie="SELECT f.id_cliente as id_cliente, c.nombre as nombre, c.ci_ruc as ci_ruc, c.direccion as direccion, c.lugar as lugar,
                    f.serie1 as serie1, f.serie2 as serie2, f.codigo_factura as codigo_factura, f.fecha as fecha
             FROM cliente c INNER JOIN facturas f ON c.id_cliente = f.id_cliente
             WHERE f.id_factura= $idfactura";
$res_clie=mysql_query($query_clie,$conn);

$nombre=mysql_result($res_clie,0,"nombre");
$ci_ruc=mysql_result($res_clie,0,"ci_ruc");
$direccion=mysql_result($res_clie,0,"direccion");
$lugar=mysql_result($res_clie,0,"lugar");
$serie1_fac=mysql_result($res_clie,0,"serie1");
$serie2_fac=mysql_result($res_clie,0,"serie2");
$codigo_factura=mysql_result($res_clie,0,"codigo_factura");
$fecha_factura=mysql_result($res_clie,0,"fecha");

//fin datos factura-cliente ------------------------------------------------------------------------------------------------------------------


$pdf=new MYPDF('P','mm',array(148,210));
$pdf->AliasNbPages();
$pdf->SetMargins(15,53);
$pdf->SetAutoPageBreak(true,2);
$pdf->AddPage();



//$pdf->SetFont('Arial','',12);

//inicio tabla No 1******************************************************************************************************************
// create table
$columns = array();

// data col
$col = array();
$col[] = array('text' => '', 'width' => '42', 'height' => '4', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => $serie1_fac." - ".$serie2_fac." # ".$codigo_factura, 'width' => '90', 'height' => '4', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '35', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => implota($fecha_factura), 'width' => '97', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '146', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '60', 'height' => '4', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => implota($fecha_factura), 'width' => '72', 'height' => '4', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '65', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => implota($fecha_fin), 'width' => '67', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '146', 'height' => '9', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;


switch ($motivo)
{
    case 'venta':
    case 'VENTA':
                    $col = array();
                    $col[] = array('text' => 'X', 'width' => '3', 'height' => '3', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '4', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
                    $spacio = 9;
                    $columns[] = $col;
                    break;
    case 'consignacion':
    case 'CONSIGNACION':
                    $col = array();
                    $col[] = array('text' => '', 'width' => '146', 'height' => '4', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '1', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
                    $columns[] = $col;

                    $col = array();
                    $col[] = array('text' => 'X', 'width' => '3', 'height' => '3', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '4', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
                    $spacio = 5;
                    $columns[] = $col;
                    break;
    case 'devolucion':
    case 'DEVOLUCION':
                    $col = array();
                    $col[] = array('text' => '', 'width' => '146', 'height' => '8', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '1', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
                    $columns[] = $col;

                    $col = array();
                    $col[] = array('text' => 'X', 'width' => '3', 'height' => '3', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '4', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
                    $spacio = 1;
                    $columns[] = $col;
                    break;
    case 'otros':
    case 'OTROS':
                    $col = array();
                    $col[] = array('text' => 'x', 'width' => '68', 'height' => '3', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '4', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
                    $spacio = 9;
                    $columns[] = $col;
                    break;
    default:
                    $col = array();
                    $col[] = array('text' => '', 'width' => '146', 'height' => '4', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '4', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
                    $columns[] = $col;

                    $col = array();
                    $col[] = array('text' => 'X' , 'width' => '68', 'height' => '3', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '4', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
                    $col[] = array('text' => strtoupper($motivo) , 'width' => '79', 'height' => '3', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '4', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
                    $spacio = 5;
                    $columns[] = $col;
                    break;
}


$col = array();
$col[] = array('text' => '', 'width' => '147', 'height' => $spacio, 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '30', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => implota($fecha_factura), 'width' => '102', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '30', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => $punto_partida, 'width' => '102', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '146', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;


$col = array();
$col[] = array('text' => '', 'width' => '40', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => utf8_decode($nombre), 'width' => '92', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '19', 'height' => '5.5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => $ci_ruc, 'width' => '92', 'height' => '5.5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '23', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => utf8_decode($lugar)." - ". utf8_decode($direccion), 'width' => '109', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '146', 'height' => '8', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '40', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => utf8_decode($nombre_trans), 'width' => '92', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '18', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => $ci_trans, 'width' => '114', 'height' => '6', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

// Draw Table
$pdf->WriteTable($columns);

//fin tabla No 1*********************************************************************************************************************
 $pdf->Ln(12);

//inicio tabla No 2******************************************************************************************************************
$columns_productos = array();

$query_productos="SELECT f.cantidad as cantidad, p.nombre as nombre
                                                         FROM factulinea as f INNER JOIN producto as p ON f.id_producto = p.id_producto
                                                         WHERE f.id_factura = $idfactura";

$res_prod=mysql_query($query_productos, $conn);

$totalfilas=mysql_num_rows($res_prod);
for ($i = 0; $i < $totalfilas; $i++)
{
    $cantidad=mysql_result($res_prod,$i,"cantidad");
    $nombre_producto=mysql_result($res_prod,$i,"nombre");
    

    $col_pro = array();
    $col_pro[] = array('text' => $cantidad, 'width' => '28', 'height' => '4', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
    $col_pro[] = array('text' => $nombre_producto, 'width' => '104', 'height' => '4', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
    $columns_productos[] = $col_pro;
    $cont=$i;
}

$pdf->WriteTable($columns_productos);

//fin tabla No 2*********************************************************************************************************************



// Show PDF
$pdf->IncludeJS("print('true');"); 
$pdf->Output();
?>