<?php




require_once 'db.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));
$query="SELECT b.id_contrato, b.codigo,a.id,c.id as id_empleado, c.nombre as nombre_empleado, d.nombre, seguro,a.sueldo,descuento,comision,total_dias,total_pagar,mes,anio,dias_no_laborados FROM  rol_pago as a join   relacion_empleado_contrato as b on a.id_relacion_empleado_contrato=b.id join  empleado as c on b.id_empleado=c.id join  contrato as d on d.id=b.id_contrato where a.borrado=0 and b.activo=1 order by c.nombre asc 
";
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