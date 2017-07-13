<?php




require_once 'db.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));
$cedula = $data->cedula;

$query="SELECT codigo,confechacontrato,conplazocredito,estconcodigo,concostocuota,coninterescredito,coninteresmora,concuotainicial FROM contrato_credito where id_cliente =(SELECT id_cliente from cliente where ci_ruc='$cedula') and estconcodigo='Vigente'";
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