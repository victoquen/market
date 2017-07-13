<?php

date_default_timezone_set ( 'America/Guayaquil' );


    require_once( '../config/config.configurar.php' );
    define('FPDF_FONTPATH','../font');

    include ("../js/fechas.php");
    include ("../conexion/conexion.php");
    include ( "class.clfpdf.php" );

    $usuario = new ServidorBaseDatos();
    $conn = $usuario->getConexion();
    $id_trasnferencia = $_GET["id_trasnferencia"];


?>