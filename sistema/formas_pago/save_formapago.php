<?php
include_once 'class/formapago.php';
include_once '../conexion/conexion.php';
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

if($accion!="baja")
{

    $nombre=strtoupper($_POST["Anombre"]);
}

if ($accion=="alta") {
        $formapago = new Formapago();
        $result = $formapago->save_formapago($conn,  $nombre);

	if ($result)
        {
            $mensaje="El formapago ha sido dado de alta correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el formapago</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> formapagos &gt;&gt; Nuevo formapago ";
	$cabecera2="INSERTAR formapago ";
}

if ($accion=="modificar") {
	$idformapago=$_POST["idformapago"];
        $formapago = new Formapago();
        $result = $formapago->update_formapago($conn, $idformapago, $nombre);
	
        if ($result)
        {
            $mensaje="Los datos de la entidad bancaria han sido modificados correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el formapago</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> formapagos &gt;&gt; Modificar formapago ";
	$cabecera2="MODIFICAR ENTIDAD BANCARIA ";
}

if ($accion=="baja") {
	$idformapago=$_REQUEST["idformapago"];
        $formapago = new Formapago();
        $result = $formapago->delete_formapago($conn,$idformapago);

	if ($result)
        {
            $mensaje="La entidad bancaria ha sido dado de baja correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja el formapago</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> formapago &gt;&gt; Eliminar formapago ";
	$cabecera2="ELIMINAR formapago ";
	
        $result= $formapago->get_formapago_borrado_id($conn, $idformapago);
        $codigo=$result['codigo'];
        $nombre=$result['nombre'];
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
                            location.href="index.php";
                        else
                            history.back();
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
				<div id="tituloForm" class="header"><?php echo $cabecera2?></div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="15%"></td>
							<td width="85%" colspan="2" class="mensaje"><?php echo $mensaje;?></td>
                                                </tr>						
						<tr>
							<td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php echo $nombre?></td>
					    </tr>						
					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php echo $validacion?>)" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			 </div>
		  </div>
		</div>
	</body>
</html>