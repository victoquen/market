<?php 
require_once 'db.php'; // The mysql database connection script
//$data = json_decode(file_get_contents("php://input"));



$result = $mysqli->affected_rows;

echo $json_response = json_encode($result);

?>