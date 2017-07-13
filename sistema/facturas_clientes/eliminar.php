<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 
?>
<html>
<head>
</head>
<?php 
include ("../js/fechas.php");

include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();
?>
<body>
<?php
	$idmov=$_GET["idmov"];
	$idfactura=$_GET["idfactura"];
	$fechacobro=$_GET["fechacobro"];
	$importe=$_GET["importe"];
	$fecha=explota($fechacobro);
	$act_factura="DELETE FROM cobros WHERE id_cobro='$idmov' AND id_factura='$idfactura'";
	$rs_act=mysql_query($act_factura,$conn);
	
	//1 compra
	//2 venta

        $act_libro="DELETE FROM librodiario WHERE id_mov='$idmov'  AND id_factura ='$idfactura' AND tipodocumento = 2";
        $rs_libro=mysql_query($act_libro,$conn);



        
        $select_facturas="SELECT totalfactura, ret_iva, ret_fuente FROM facturas  WHERE facturas.id_factura=$idfactura";
        $rs_facturas=mysql_query($select_facturas,$conn);
        $totalfactura=mysql_result($rs_facturas,0,"totalfactura");
        $retiva= mysql_result($rs_facturas,0,"ret_iva");
        $retfuente = mysql_result($rs_facturas,0,"ret_fuente");


        $sel_cobros="SELECT sum(importe) as aportaciones FROM cobros WHERE id_factura=$idfactura";
        $rs_cobros=mysql_query($sel_cobros,$conn);
        if($rs_cobros)
            $aportaciones=mysql_result($rs_cobros,0,"aportaciones");
        else
            $aportaciones=0;

         $pendiente=$totalfactura-$aportaciones - $retiva - $retfuente;


//$aportaciones='1212';

        echo "<script>parent.location.href='frame_cobros.php?accion=eliminado&idfactura=".$idfactura."&importe=".$pendiente."';</script>";
//	$sel_libro="INSERT INTO librodiario (id,fecha,tipodocumento,coddocumento,codcomercial,codformapago,numpago,total) VALUES
//	('','$fecha','2','$codfactura','','','','$importe')";
//	$rs_libro=mysql_query($sel_libro);
?>
</body>
</html>
