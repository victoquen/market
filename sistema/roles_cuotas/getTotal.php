<?php
/**
 * Created by PhpStorm.
 * User: xaipo
 * Date: 6/22/2017
 * Time: 11:45 AM
 */


require_once 'db2.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;

$query="select * from cuota_legacy as a where a.id_contrato=$id and estado_cuota=1";
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