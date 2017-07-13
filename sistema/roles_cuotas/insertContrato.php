<?php 
require_once 'db.php'; // The mysql database connection script

$data = json_decode(file_get_contents("php://input"));

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
    $conplazocredito = $data->conplazocredito;
    $confechacontrato = $data->confechacontrato;
    $coninterescredito = $data->coninterescredito;
    $coninteresmora = $data->coninteresmora;
    $concuotainicial = $data->concuotainicial;
    $conentradapendiente = $data->conentradapendiente;
    $concostocuota = $data->concostocuota;
    //$conobservacion = $data->conobservacion;

$query="INSERT INTO `contrato_credito`
(`tipconcodigo`,
`id_cliente`,
`id_venta`,

`concasapropiaarrendadacliente`,

`concaracteristicasdomiciliocliente`,
`conreferenciadomiciliocliente`,
`contelefonodomiciliocliente`,
`concelularcliente`,
`conlugartrabajocliente`,
`concargotrabajocliente`,
`contiempolugartrabajocliente`,
`condirecciontrabajocliente`,
`contelefonostrabajocliente`,
`conreferencialugartrabajocliente`,
`concedulagaranteconyugue`,
`connombrescompletosgaranteconyugue`,
`conciudadgaranteconyugue`,
`condirecciondomiciliogaranteconyugue`,
`concaracteristicasdomiciliogaranteconyugue`,

`concasapropiaarrendadagaranteconyugue`,
`conreferenciadomiciliogaranteconyugue`,
`contelefonocasagaranteconyugue`,
`concelulargaranteconyugue`,
`conlugartrabajogaranteconyugue`,
`concargotrabajogaranteconyugue`,
`contiempolugartrabajogaranteconyugue`,
`condirecciontrabajogaranteconyugue`,
`contelefonostrabajogaranteconyugue`,
`concedulareferenciapersonal`,
`connombrescompletosreferenciapersonal`,
`condirecciondomicilioreferenciapersonal`,
`concaracteristicasdomicilioreferenciapersonal`,

`concasapropiaarrendadareferenciapersonal`,
`conreferenciadomicilioreferenciapersonal`,
`contelefonocasareferenciapersonal`,
`concelularreferenciapersonal`,
`conlugartrabajoreferenciapersonal`,
`concargotrabajoreferenciapersonal`,
`contiempolugartrabajoreferenciapersonal`,
`condirecciontrabajoreferenciapersonal`,
`contelefonostrabajoreferenciapersonal`,
`concedulareferenciaestudiantil`,
`connombrescompletosreferenciaestudiantil`,
`conparentescoreferenciaestudiantil`,
`coninstitucionreferenciaestudiantil`,
`connivelreferenciaestudiantil`,
`conplazocredito`,
`confechacontrato`,
`coninterescredito`,
`coninteresmora`,
`concuotainicial`,
`conentradapendiente`,
`concostocuota`,
`estconcodigo`)
VALUES
(  '$tipconcodigo','$idcliente','$venid','$concasapropiaarrendadacliente','$concaracteristicasdomiciliocliente','$conreferenciadomiciliocliente','$contelefonodomiciliocliente','$concelularcliente','$conlugartrabajocliente','$concargotrabajocliente','$contiempolugartrabajocliente','$condirecciontrabajocliente','$contelefonostrabajocliente','$conreferencialugartrabajocliente','$concedulagaranteconyugue','$connombrescompletosgaranteconyugue','$conciudadgaranteconyugue','$condirecciondomiciliogaranteconyugue','$concaracteristicasdomiciliogaranteconyugue', '$concasapropiaarrendadagaranteconyugue','$conreferenciadomiciliogaranteconyugue','$contelefonocasagaranteconyugue','$concelulargaranteconyugue','$conlugartrabajogaranteconyugue','$concargotrabajogaranteconyugue','$contiempolugartrabajogaranteconyugue','$condirecciontrabajogaranteconyugue','$contelefonostrabajogaranteconyugue','$concedulareferenciapersonal','$connombrescompletosreferenciapersonal','$condirecciondomicilioreferenciapersonal','$concaracteristicasdomicilioreferenciapersonal','$concasapropiaarrendadareferenciapersonal','$conreferenciadomicilioreferenciapersonal','$contelefonocasareferenciapersonal','$concelularreferenciapersonal','$conlugartrabajoreferenciapersonal','$concargotrabajoreferenciapersonal','$contiempolugartrabajoreferenciapersonal','$condirecciontrabajoreferenciapersonal','$contelefonostrabajoreferenciapersonal','$concedulareferenciaestudiantil','$connombrescompletosreferenciaestudiantil','$conparentescoreferenciaestudiantil','$coninstitucionreferenciaestudiantil','$connivelreferenciaestudiantil','$conplazocredito','$confechacontrato','$coninterescredito','$coninteresmora','$concuotainicial','$conentradapendiente','$concostocuota','$estconcodigo');";

$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

//$result = $mysqli->affected_rows;
$result=mysqli_insert_id($mysqli);
echo $json_response = json_encode($result);

?>