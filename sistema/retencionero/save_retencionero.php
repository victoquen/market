<?php 
include_once 'class/retencionero.php';
include_once '../conexion/conexion.php';
include ("../js/fechas.php");

$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();




$accion=$_REQUEST["accion"];
if (!isset($accion))
{
    $accion=$_GET["accion"];
    if(!isset($accion))
    {
        $accion=$_REQUEST["accion"];
    }
}




if ($accion=="modificar") {
	$idretencionero=$_POST["idretencionero"];
        $serie1=$_POST["Aserie1"];
        $serie2=$_POST["Aserie2"];
        $autorizacion=$_POST["Aautorizacion"];
        $inicio=$_POST["Ainicio"];
        $fin=$_POST["Afin"];
        $fecha_caducidad=explota($_POST["afecha_caducidad"]);

        $retencionero = new retencionero();
        $result = $retencionero->update_retencionero($conn, $idretencionero, $serie1,$serie2,$autorizacion,$inicio,$fin,$fecha_caducidad);
	
        if ($result)
        {
            $mensaje="Los datos del retencionero han sido actualizados correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el retencionero</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> Comprobante de Retencion &gt;&gt; Actualizar datos ";
	$cabecera2="ACTUALIzar DATOS DE RETENCIONES ";
}

?>


<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">

		function aceptar(validacion) {
			if(validacion==0)
                          {
                            location.href="../central2.php";
                          }
                        else
                            {
                                alert("error");
                                history.back();
                            }
		}

		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}

		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header"><?php  echo $cabecera2?></div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
                                                    <td width="8%">Tipo Servicio</td>
                                                   <td><?php  echo $serie1?></td>

                                                </tr>
                                                <tr>
                                                    <td width="8%">No. Local</td>
                                                    <td width="43%"><?php  echo $serie2?></td>

                                                </tr>
                                                <tr>
                                                    <td width="8%">Autorizaci&oacute;n</td>
                                                    <td width="43%"><?php  echo $autorizacion?></td>

                                                </tr>
                                                <tr>
                                                    <td width="8%">Serie Inicio</td>
                                                    <td width="43%"><?php  echo $inicio?></td>

                                                </tr>
                                                <tr>
                                                    <td width="8%">Serie Fin</td>
                                                    <td width="43%"><?php  echo $fin?></td>

                                                </tr>
                                                <tr>

                                                     <td width="8%">Fecha</td>
						    <td width="43%"><?php  echo implota($fecha_caducidad)?></td>


                                                </tr>
					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php  echo $validacion?>)" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			 </div>
		  </div>
		</div>
	</body>
</html>