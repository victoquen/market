<?php


require_once 'db.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));

//$cont = $data->cont;
$id_factura = $data->id_factura;


$query="SELECT * FROM factulinea as a join producto as b on a.id_producto=b.id_producto join facturas as c on a.id_factura=c.id_factura where a.id_factura =$id_factura ";
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