<?php 
include_once 'class/operadora.php';
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
        $operadora = new operadora();
        $result = $operadora->save_operadora($conn,  $nombre);

	if ($result)
        {
            $mensaje="La operadora ha sido dado de alta correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar la operadora</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> operadoras &gt;&gt; Nueva operadora ";
	$cabecera2="INSERTAR OPERADORA ";
}

if ($accion=="modificar") {
	$idoperadora=$_POST["idoperadora"];
        $operadora = new operadora();
        $result = $operadora->update_operadora($conn, $idoperadora, $nombre);
	
        if ($result)
        {
            $mensaje="Los datos de la operadora movil han sido modificados correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar la operadora</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> operadoras &gt;&gt; Modificar operadora ";
	$cabecera2="MODIFICAR OPERADORA MOVIL ";
}

if ($accion=="baja") {
	$idoperadora=$_REQUEST["idoperadora"];
        $operadora = new operadora();
        $result = $operadora->delete_operadora($conn,$idoperadora);

	if ($result)
        {
            $mensaje="La operadora movil ha sido dado de baja correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja la operadora</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> operadora &gt;&gt; Eliminar operadora ";
	$cabecera2="ELIMINAR OPERADORA ";
	
        $result= $operadora->get_operadora_borrado_id($conn, $idoperadora);
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
				<div id="tituloForm" class="header"><?php  echo $cabecera2?></div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="15%"></td>
							<td width="85%" colspan="2" class="mensaje"><?php  echo $mensaje;?></td>
                                                </tr>						
						<tr>
							<td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php  echo $nombre?></td>
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