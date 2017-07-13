<?php
//require_once 'db.php'; // The mysql database connection script
//$data = json_decode(file_get_contents("php://input"));
//session_start();
session_start();
$result = $_SESSION['username'];

echo $json_response = json_encode($result);

?>