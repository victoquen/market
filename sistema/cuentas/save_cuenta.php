<?php
include_once 'class/cuenta.php';
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
    $gasto=$_POST["cbogasto"];
}

if ($accion=="alta") {
        $cuenta = new cuenta();
        $result = $cuenta->save_cuenta($conn,  $nombre, $gasto);

	if ($result)
        {
            $mensaje="La cuenta ha sido dado de alta correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar la cuenta</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> cuentas &gt;&gt; Nueva cuenta ";
	$cabecera2="INSERTAR OPERADORA ";
}

if ($accion=="modificar") {
	$idcuenta=$_POST["idcuenta"];
        $cuenta = new cuenta();
        $result = $cuenta->update_cuenta($conn, $idcuenta, $nombre,$gasto);
	
        if ($result)
        {
            $mensaje="Los datos de la cuenta movil han sido modificados correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar la cuenta</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> cuentas &gt;&gt; Modificar cuenta ";
	$cabecera2="MODIFICAR OPERADORA MOVIL ";
}

if ($accion=="baja") {
	$idcuenta=$_REQUEST["idcuenta"];
        $cuenta = new cuenta();
        $result = $cuenta->delete_cuenta($conn,$idcuenta);

	if ($result)
        {
            $mensaje="La cuenta movil ha sido dado de baja correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja la cuenta</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> cuenta &gt;&gt; Eliminar cuenta ";
	$cabecera2="ELIMINAR OPERADORA ";
	
        $result= $cuenta->get_cuenta_borrado_id($conn, $idcuenta);
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
                                            <tr>
                                                <td width="15%">Gasto</td>
                                                <?php 
                                                    if($gasto==0)
                                                    {
                                                        $esGasto="No";
                                                    }
                                                    else
                                                    {
                                                         $esGasto="Si";
                                                    }
                                                ?>
                                                <td width="85%" colspan="2"><?php echo $esGasto?></td>
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