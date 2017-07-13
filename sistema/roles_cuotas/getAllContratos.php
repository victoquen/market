<?php




require_once 'db.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));
//$cedula = $data->cedula;

$query="SELECT * FROM contrato_credito as a join cliente as b on a.id_cliente=b.id_cliente where estconcodigo='Vigente'";
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