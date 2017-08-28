<?php
require('fpdf181/fpdf.php');

include ("../js/fechas.php");
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();


// own pdf structure




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


$pdf=new FPDF();
$pdf->AliasNbPages();
$pdf->SetMargins(21,33);
$pdf->SetAutoPageBreak(true,6);
$pdf->AddPage();






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
	
    


}





$pdf->WriteTable($columns_productos);
//FIN tabla No 3*********************************************************************************************************************


// Show PDF
$pdf->IncludeJS("print('true');"); 
$pdf->Output();
?>