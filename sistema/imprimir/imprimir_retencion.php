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


// inicio datos retencion ------------------------------------------------------------------------------------------------------------------
$idretencion=$_GET["idretencion"];

$query_ret="SELECT r.id_factura as id_factura, r.serie1 as serie1, r.serie2 as serie2, r.codigo_retencion as codigo_retencion, r.autorizacion as autorizacion, r.concepto as concepto, r.totalretencion as totalretencion, r.fecha as fecha
            FROM retencion r 
            WHERE r.id_retencion=$idretencion";
$res_ret=mysql_query($query_ret,$conn);

$idfactura=mysql_result($res_ret,0,"id_factura");

$codigo_retencion=mysql_result($res_ret,0,"codigo_retencion");
$serie1=mysql_result($res_ret,0,"serie1");
$serie2=mysql_result($res_ret,0,"serie2");
$autorizacion=mysql_result($res_ret,0,"autorizacion");
$concepto=mysql_result($res_ret,0,"concepto");
$totalretencion=mysql_result($res_ret,0,"totalretencion");
$fecha=mysql_result($res_ret,0,"fecha");






//fin datos retencion ------------------------------------------------------------------------------------------------------------------

//inicio datos proveedor ------------------------------------------------------------------------------------------------------------------
$query_prov="SELECT fp.id_proveedor id_proveedor, p.empresa as empresa, p.ci_ruc as ci_ruc, p.direccion as direccion, fp.tipocomprobante as tipocomprobante,
                    fp.serie1 as serie1, fp.serie2 as serie2, fp.codigo_factura as codigo_factura
             FROM proveedor p INNER JOIN facturasp fp ON p.id_proveedor = fp.id_proveedor
             WHERE fp.id_facturap= $idfactura";
$res_prov=mysql_query($query_prov,$conn);

$id_prov=mysql_result($res_prov,0,"id_proveedor");
$empresa=mysql_result($res_prov,0,"empresa");
$ci_ruc=mysql_result($res_prov,0,"ci_ruc");
$direccion=mysql_result($res_prov,0,"direccion");
$tipocomprob=mysql_result($res_prov,0,"tipocomprobante");
switch ($tipocomprob)
{
    // 1 FACTURA
    case 1:
            $comprobante="FACTURA";
            break;
    // 2 LIQUIDACIONES DE COMPRA
    case 2:
            $comprobante="LIQUIDACIONES DE COMPRA";
            break;
    // 3 NOTA DE VENTA
    case 3:
            $comprobante="NOTA DE VENTA";
            break;
}
$factura_serie1=mysql_result($res_prov,0,"serie1");
$factura_serie2=mysql_result($res_prov,0,"serie2");
$numerocomprobante=mysql_result($res_prov,0,"codigo_factura");


$query_fono="SELECT numero FROM proveedorfono WHERE id_proveedor = $id_prov";
$res_fono=mysql_query($query_fono,$conn);
if(mysql_num_rows($res_fono)>0)
{
    $telefono=mysql_result($res_fono,0,"numero");
}
else
{
     $telefono="-----";
}
//fin datos proveedor ------------------------------------------------------------------------------------------------------------------


$pdf=new MYPDF('L','mm',array(148,210));
$pdf->AliasNbPages();
$pdf->SetMargins(21,33);
$pdf->SetAutoPageBreak(true,6);
$pdf->AddPage();



//$pdf->SetFont('Arial','',12);

//inicio tabla No 1******************************************************************************************************************
// create table
$columns = array();

// data col
$col = array();
$col[] = array('text' => '', 'width' => '10', 'height' => '7', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => utf8_decode($empresa), 'width' => '125', 'height' => '7', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;


$col = array();
$col[] = array('text' => '', 'width' => '20', 'height' => '7', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => $ci_ruc, 'width' => '50', 'height' => '7', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => '', 'width' => '10', 'height' => '7', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => $telefono, 'width' => '58', 'height' => '7', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$vector_fecha = explode("-",$fecha);
$col[] = array('text' => $vector_fecha[2], 'width' => '16', 'height' => '7', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => $vector_fecha[1], 'width' => '16', 'height' => '7', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => $vector_fecha[0], 'width' => '15', 'height' => '7', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '15', 'height' => '7', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => strtoupper(utf8_decode($direccion)), 'width' => '171', 'height' => '7', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

$col = array();
$col[] = array('text' => '', 'width' => '32', 'height' => '7', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => $comprobante, 'width' => '62', 'height' => '7', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => '', 'width' => '31', 'height' => '7', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col[] = array('text' => $factura_serie1."-".$factura_serie2."-".$numerocomprobante, 'width' => '61', 'height' => '7', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns[] = $col;

// Draw Table
$pdf->WriteTable($columns);

//fin tabla No 1*********************************************************************************************************************
 $pdf->Ln(1);

//inicio tabla No 2******************************************************************************************************************
$columns_concepto=array();

$concepto_parte1=substr($concepto,0,125);
$concepto_parte2=substr($concepto,125,255);
$col_concepto=array ();
$col_concepto[] = array('text' => '', 'width' => '17', 'height' => '4', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col_concepto[] = array('text' => utf8_decode($concepto_parte1), 'width' => '168', 'height' => '4', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns_concepto[]=$col_concepto;

$col_concepto=array ();
$col_concepto[] = array('text' => utf8_decode($concepto_parte2), 'width' => '185', 'height' => '5', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns_concepto[]=$col_concepto;

// Draw Table
$pdf->WriteTable($columns_concepto);


//fin tabla No 2*********************************************************************************************************************

$pdf->Ln(12);


//Inicio tabla No 3*********************************************************************************************************************


$columns_productos = array();

 $sel_lineas="SELECT rt.ejercicio_fiscal as ejercicio_fiscal, rt.base_imponible as base_imponible, rt.impuesto as impuesto,
                                                            rt.codigo_impuesto as codigo_impuesto, rt.porcentaje_retencion as porcentaje_retencion,
                                                            rt.valor_retenido as valor_retenido
                                                            FROM retenlinea rt  WHERE rt.id_retencion = '$idretencion'";
$rs_lineas=mysql_query($sel_lineas,$conn);

$totalfilas=mysql_num_rows($rs_lineas);
for ($i = 0; $i < $totalfilas; $i++)
{
    $ejercicio_fiscal=mysql_result($rs_lineas,$i,"ejercicio_fiscal");
    $base_imponible=mysql_result($rs_lineas,$i,"base_imponible");
    $impuesto=mysql_result($rs_lineas,$i,"impuesto");
    $codigo_impuesto=mysql_result($rs_lineas,$i,"codigo_impuesto");
    $porcentaje_retencion=mysql_result($rs_lineas,$i,"porcentaje_retencion");
    $valor_retenido=mysql_result($rs_lineas,$i,"valor_retenido");

	
	$query_codret = "SELECT tipo FROM codretencion WHERE codigo = $codigo_impuesto";
	$res_codret = mysql_query($query_codret, $conn);
	$tiporetencion = mysql_result($res_codret,0,"tipo");
	
    

    $col_pro = array();
    $col_pro[] = array('text' => $ejercicio_fiscal, 'width' => '31', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
    $col_pro[] = array('text' => $base_imponible, 'width' => '31', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
    $col_pro[] = array('text' => $tiporetencion, 'width' => '31', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
    $col_pro[] = array('text' => $codigo_impuesto, 'width' => '31', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
    $col_pro[] = array('text' => $porcentaje_retencion."%", 'width' => '31', 'height' => '5', 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
    $col_pro[] = array('text' => $valor_retenido, 'width' => '25', 'height' => '5', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
    $columns_productos[] = $col_pro;
    $cont=$i;
}

    $h_aux=((5-$totalfilas)*5)+1;
    $col_pro = array();
    $col_pro[] = array('text' => '', 'width' => '186', 'height' => $h_aux, 'align' => 'C', 'font_name' => 'Arial', 'font_size' => '6', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
    $columns_productos[] = $col_pro;


$col_pro = array();
$col_pro[] = array('text' => '', 'width' => '155', 'height' => '8', 'align' => 'L', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$col_pro[] = array('text' => $totalretencion, 'width' => '25', 'height' => '8', 'align' => 'R', 'font_name' => 'Arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
$columns_productos[] = $col_pro;



$pdf->WriteTable($columns_productos);
//FIN tabla No 3*********************************************************************************************************************


// Show PDF
$pdf->IncludeJS("print('true');"); 
$pdf->Output();
?>