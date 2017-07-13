<?php
include_once 'class/codretencion.php';
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
	$codigo = $_POST["Acodigo"];
    $nombre=strtoupper($_POST["Anombre"]);
	$porcentaje = $_POST["Qporcentaje"];
	$tipo = $_POST["Acbotipos"];
}

if ($accion=="alta") {
        $reten = new Codretencion();
        $result = $reten->save($conn, $codigo, $nombre, $porcentaje, $tipo);

	if ($result)
        {
            $mensaje="La retencion ha sido dado de alta correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar la operadora</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> C&oacute;digo Retenci&oacute;n &gt;&gt; Nuevo C&oacute;digo Retenci&oacute;n ";
	$cabecera2="INSERTAR CODIGO DE RETENCION ";
}

if ($accion=="modificar") {
	$idreten=$_POST["idcodretencion"];
        $reten = new Codretencion();
        $result = $reten->update($conn, $idreten, $codigo, $nombre, $porcentaje, $tipo);
	
        if ($result)
        {
            $mensaje="Los datos de la retencion han sido modificados correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar la retencion</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> C&oacute;digo Retenci&oacute;n &gt;&gt; Nuevo C&oacute;digo Retenci&oacute;n ";
	$cabecera2="MODIFICAR CODIGOS DE RETENCION ";
}

if ($accion=="baja") {
	$idreten=$_REQUEST["idcodretencion"];
        $reten = new Codretencion();
        $result = $reten->delete($conn,$idoperadora);

	if ($result)
        {
            $mensaje="CODIGO DE RETENCION ha sido dado de baja correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja la RETENCION</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> C&oacute;digo Retenci&oacute;n &gt;&gt; Nuevo C&oacute;digo Retenci&oacute;n ";
	$cabecera2="ELIMINAR CODIGO DE RETENCION ";
	
        $result= $reten->get_codretencion_borrado_id($conn, $idoperadora);
        $codigo=$result['codigo'];
        $nombre=$result['nombre'];
		$porcentaje = $result['porcentaje'];
		$tipo = $result['tipo'];
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
							<td width="15%">C&oacute;digo</td>
						    <td width="85%" colspan="2"><?php echo $codigo;?></td>
					    </tr>					  
						<tr>
							<td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php echo $nombre;?></td>
					    </tr>	
						<tr>
							<td width="15%">Porcentaje</td>
						    <td width="85%" colspan="2"><?php echo $porcentaje;?></td>
					    </tr>
						<tr>
							<td width="15%"><strong>Tipo</strong></td>
							<td width="85%" colspan="2"><?php echo $tipo?></td>
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