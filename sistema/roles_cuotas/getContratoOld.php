<?php




require_once 'db2.php'; // The mysql database connection script
$data = json_decode(file_get_contents("php://input"));
$cedula = $data->cedula;

$query="select a.codigo,confechacontrato,conplazocredito,estconcodigo,concostocuota,coninterescredito,coninteresmora,concuotainicial,b.nombre,ci_ruc,a.id_venta,e.descripcion_producto as producto,a.id_cliente
from contrato_credito_legacy as a 
join cliente as b on a.id_cliente=b.id_cliente
join venta_legacy as c on c.id_venta=a.id_venta
join detalle_venta_legacy as d on c.id_venta=d.id_venta
join stock_legacy as f on f.codigo_stock=d.id_stock
join producto_legacy as e on e.codigo_producto=f.producto_id
where  estconcodigo='Old' ";
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