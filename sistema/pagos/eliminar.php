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
	$act_factura="DELETE FROM pagos WHERE id_pago='$idmov' AND id_factura='$idfactura'";
	$rs_act=mysql_query($act_factura,$conn);
	
	//1 compra
	//2 venta

        $act_libro="DELETE FROM librodiario WHERE id_mov='$idmov'  AND id_factura ='$idfactura' AND tipodocumento = 1";
        $rs_libro=mysql_query($act_libro,$conn);



        
        $select_facturas="SELECT totalfactura FROM facturasp  WHERE facturasp.id_facturap=$idfactura";
        $rs_facturas=mysql_query($select_facturas,$conn);
        $totalfactura=mysql_result($rs_facturas,0,"totalfactura");
        
        $query_retencion="SELECT totalretencion FROM retencion WHERE (anulado = 0) AND id_factura='$idfactura'";
        $rs_retencion=mysql_query($query_retencion, $conn);
        $retencion=mysql_result($rs_retencion,0,"totalretencion");


        $sel_pagos="SELECT sum(importe) as aportaciones FROM pagos WHERE id_factura=$idfactura";
        $rs_pagos=mysql_query($sel_pagos,$conn);
        if($rs_pagos){
            $aportaciones=mysql_result($rs_pagos,0,"aportaciones");
        } else {
            $aportaciones=0;
        }
        $pendiente=$totalfactura-$aportaciones - $retencion;


//$aportaciones='1212';

        echo "<script>parent.location.href='frame_pagos.php?accion=eliminado&idfactura=".$idfactura."&importe=".$pendiente."';</script>";
//	$sel_libro="INSERT INTO librodiario (id,fecha,tipodocumento,coddocumento,codcomercial,codformapago,numpago,total) VALUES
//	('','$fecha','2','$codfactura','','','','$importe')";
//	$rs_libro=mysql_query($sel_libro);
?>
</body>
</html>
