<?php 
require_once 'db.php'; // The mysql database connection script

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
 $estconcodigo = $data->estconcodigo;
    
   

	
	

$query="UPDATE contrato_credito SET 
    estconcodigo = '$estconcodigo'
   
 

 WHERE codigo=$id";

 //echo $query;
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

//$result = $mysqli->affected_rows;

$result=mysqli_insert_id($mysqli);
echo $json_response = json_encode($result);

?>