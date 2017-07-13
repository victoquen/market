<?php 
require_once 'db.php'; // The mysql database connection script

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
 $tipconcodigo = $data->tipconcodigo;
    $estconcodigo = $data->estconcodigo;
    $venid = $data->venid;
    $idcliente = $data->idcliente;
   
    $concasapropiaarrendadacliente = $data->concasapropiaarrendadacliente;
   
    $concaracteristicasdomiciliocliente = $data->concaracteristicasdomiciliocliente;
    $conreferenciadomiciliocliente = $data->conreferenciadomiciliocliente;
    $contelefonodomiciliocliente = $data->contelefonodomiciliocliente;
    $concelularcliente = $data->concelularcliente;
    $conlugartrabajocliente = $data->conlugartrabajocliente;
    $concargotrabajocliente = $data->concargotrabajocliente;
    $contiempolugartrabajocliente = $data->contiempolugartrabajocliente;
    $condirecciontrabajocliente = $data->condirecciontrabajocliente;
    $contelefonostrabajocliente = $data->contelefonostrabajocliente;
    $conreferencialugartrabajocliente = $data->conreferencialugartrabajocliente;
    $concedulagaranteconyugue = $data->concedulagaranteconyugue;
    $connombrescompletosgaranteconyugue = $data->connombrescompletosgaranteconyugue;
    $conciudadgaranteconyugue = $data->conciudadgaranteconyugue;
    $condirecciondomiciliogaranteconyugue = $data->condirecciondomiciliogaranteconyugue;
    $concaracteristicasdomiciliogaranteconyugue = $data->concaracteristicasdomiciliogaranteconyugue;

    $concasapropiaarrendadagaranteconyugue = $data->concasapropiaarrendadagaranteconyugue;
    $conreferenciadomiciliogaranteconyugue = $data->conreferenciadomiciliogaranteconyugue;
    $contelefonocasagaranteconyugue = $data->contelefonocasagaranteconyugue;
    $concelulargaranteconyugue = $data->concelulargaranteconyugue;
    $conlugartrabajogaranteconyugue = $data->conlugartrabajogaranteconyugue;
    $concargotrabajogaranteconyugue = $data->concargotrabajogaranteconyugue;
    $contiempolugartrabajogaranteconyugue = $data->contiempolugartrabajogaranteconyugue;
    $condirecciontrabajogaranteconyugue = $data->condirecciontrabajogaranteconyugue;
    $contelefonostrabajogaranteconyugue = $data->contelefonostrabajogaranteconyugue;
    $concedulareferenciapersonal = $data->concedulareferenciapersonal;
    $connombrescompletosreferenciapersonal = $data->connombrescompletosreferenciapersonal;
    $condirecciondomicilioreferenciapersonal = $data->condirecciondomicilioreferenciapersonal;
    $concaracteristicasdomicilioreferenciapersonal = $data->concaracteristicasdomicilioreferenciapersonal;

    $concasapropiaarrendadareferenciapersonal = $data->concasapropiaarrendadareferenciapersonal;
    $conreferenciadomicilioreferenciapersonal = $data->conreferenciadomicilioreferenciapersonal;
    $contelefonocasareferenciapersonal = $data->contelefonocasareferenciapersonal;
    $concelularreferenciapersonal = $data->concelularreferenciapersonal;
    $conlugartrabajoreferenciapersonal = $data->conlugartrabajoreferenciapersonal;
    $concargotrabajoreferenciapersonal = $data->concargotrabajoreferenciapersonal;
    $contiempolugartrabajoreferenciapersonal = $data->contiempolugartrabajoreferenciapersonal;
    $condirecciontrabajoreferenciapersonal = $data->condirecciontrabajoreferenciapersonal;
    $contelefonostrabajoreferenciapersonal = $data->contelefonostrabajoreferenciapersonal;
    $concedulareferenciaestudiantil = $data->concedulareferenciaestudiantil;
    $connombrescompletosreferenciaestudiantil = $data->connombrescompletosreferenciaestudiantil;
    $conparentescoreferenciaestudiantil = $data->conparentescoreferenciaestudiantil;
    $coninstitucionreferenciaestudiantil = $data->coninstitucionreferenciaestudiantil;
    $connivelreferenciaestudiantil = $data->connivelreferenciaestudiantil;
   

	
	

$query="UPDATE contrato_credito SET  tipconcodigo ='$tipconcodigo',
    estconcodigo = '$estconcodigo',
    id_venta = $venid,
    id_cliente = $idcliente,
   
    concasapropiaarrendadacliente = '$concasapropiaarrendadacliente',
   
    concaracteristicasdomiciliocliente = '$concaracteristicasdomiciliocliente',
    conreferenciadomiciliocliente = '$conreferenciadomiciliocliente',
    contelefonodomiciliocliente = '$contelefonodomiciliocliente',
    concelularcliente = '$concelularcliente',
    conlugartrabajocliente = '$conlugartrabajocliente',
    concargotrabajocliente = '$concargotrabajocliente',
    contiempolugartrabajocliente = '$contiempolugartrabajocliente',
    condirecciontrabajocliente = '$condirecciontrabajocliente',
    contelefonostrabajocliente = '$contelefonostrabajocliente',
    conreferencialugartrabajocliente = '$conreferencialugartrabajocliente',
    concedulagaranteconyugue = '$concedulagaranteconyugue',
    connombrescompletosgaranteconyugue = '$connombrescompletosgaranteconyugue',
    conciudadgaranteconyugue = '$conciudadgaranteconyugue',
    condirecciondomiciliogaranteconyugue = '$condirecciondomiciliogaranteconyugue',
    concaracteristicasdomiciliogaranteconyugue = '$concaracteristicasdomiciliogaranteconyugue',

    concasapropiaarrendadagaranteconyugue = '$concasapropiaarrendadagaranteconyugue',
    conreferenciadomiciliogaranteconyugue = '$conreferenciadomiciliogaranteconyugue',
    contelefonocasagaranteconyugue = '$contelefonocasagaranteconyugue',
    concelulargaranteconyugue = '$concelulargaranteconyugue',
    conlugartrabajogaranteconyugue = '$conlugartrabajogaranteconyugue',
    concargotrabajogaranteconyugue = '$concargotrabajogaranteconyugue',
    contiempolugartrabajogaranteconyugue = '$contiempolugartrabajogaranteconyugue',
    condirecciontrabajogaranteconyugue = '$condirecciontrabajogaranteconyugue',
    contelefonostrabajogaranteconyugue = '$contelefonostrabajogaranteconyugue',
    concedulareferenciapersonal = '$concedulareferenciapersonal',
    connombrescompletosreferenciapersonal = '$connombrescompletosreferenciapersonal',
    condirecciondomicilioreferenciapersonal = '$condirecciondomicilioreferenciapersonal',
    concaracteristicasdomicilioreferenciapersonal = '$concaracteristicasdomicilioreferenciapersonal',

    concasapropiaarrendadareferenciapersonal = '$concasapropiaarrendadareferenciapersonal',
    conreferenciadomicilioreferenciapersonal = '$conreferenciadomicilioreferenciapersonal',
    contelefonocasareferenciapersonal = '$contelefonocasareferenciapersonal',
    concelularreferenciapersonal = '$concelularreferenciapersonal',
    conlugartrabajoreferenciapersonal = '$conlugartrabajoreferenciapersonal',
    concargotrabajoreferenciapersonal = '$concargotrabajoreferenciapersonal',
    contiempolugartrabajoreferenciapersonal = '$contiempolugartrabajoreferenciapersonal',
    condirecciontrabajoreferenciapersonal = '$condirecciontrabajoreferenciapersonal',
    contelefonostrabajoreferenciapersonal = '$contelefonostrabajoreferenciapersonal',
    concedulareferenciaestudiantil = '$concedulareferenciaestudiantil',
    connombrescompletosreferenciaestudiantil = '$connombrescompletosreferenciaestudiantil',
    conparentescoreferenciaestudiantil = '$conparentescoreferenciaestudiantil',
    coninstitucionreferenciaestudiantil = '$coninstitucionreferenciaestudiantil',
    connivelreferenciaestudiantil = '$connivelreferenciaestudiantil'
 

 WHERE codigo=$id";

 //echo $query;
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

//$result = $mysqli->affected_rows;

$result=mysqli_insert_id($mysqli);
echo $json_response = json_encode($result);

?>