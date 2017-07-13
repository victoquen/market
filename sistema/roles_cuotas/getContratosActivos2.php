<?php




require_once 'db.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));
$cedula = $data->cedula;

$query="SELECT a.codigo,confechacontrato,conplazocredito,estconcodigo,concostocuota,coninterescredito,coninteresmora,concuotainicial,b.nombre,ci_ruc,a.id_venta,e.nombre as producto,c.id_factura, a.id_cliente FROM 
contrato_credito as a join cliente as b on a.id_cliente=b.id_cliente join 
facturas as c on a.id_venta=c.id_factura join 
factulinea as d on c.id_factura=d.id_factura join 
producto as e on d.id_producto=e.id_producto 
where  estconcodigo='Vigente'";
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

$arr = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$arr[] = $row;	
	}
}

# JSON-encode the response
echo $json_response = json_encode($arr);


?>