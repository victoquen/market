<?php




require_once 'db.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));
$id_cliente = $data->id_cliente;

$query="SELECT * FROM clientefono  where id_cliente='$id_cliente'";
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