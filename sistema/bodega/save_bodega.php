<?php
include_once 'class/bodega.php';
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
	$direccion = $_POST["Adireccion"];

}

if ($accion=="alta") {
        $reten = new Bodega();
        $result = $reten->save($conn, $nombre, $direccion);

	if ($result)
        {
            $mensaje="La bodega ha sido dado de alta correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar la bodega</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >>Bodega &gt;&gt; Nuevo Bodega";
	$cabecera2="INSERTAR BODEGA ";
}

if ($accion=="modificar") {
	$idbodega=$_POST["idbodega"];
        $reten = new Bodega();
        $result = $reten->update($conn, $idbodega,  $nombre, $direccion);
	
        if ($result)
        {
            $mensaje="Los datos de la bodega han sido modificados correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al modificar la bodega</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> BODEGA &gt;&gt; Nuevo BODEGA ";
	$cabecera2="MODIFICAR BODEGA ";
}

if ($accion=="baja") {
	$idbodega=$_REQUEST["idbodega"];
        $reten = new bodega();
        $result = $reten->delete($conn,$idbodega);

	if ($result)
        {
            $mensaje="CODIGO DE BODEGA ha sido dado de baja correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja la RETENCION</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> Bodega &gt;&gt; Nuevo Bodega ";
	$cabecera2="ELIMINAR CODIGO DE BODEGA ";
	
        $result= $reten->get_bodega_borrado_id($conn, $idoperadora);
        
        $nombre=$result['nombre'];
		$direccion = $result['direccion'];
		
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
						    <td width="85%" colspan="2"><?php echo $nombre;?></td>
					    </tr>	
						<tr>
							<td width="15%">Direcci&oacute;n</td>
						    <td width="85%" colspan="2"><?php echo $direccion;?></td>
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