<?php
include_once 'class/banco.php';
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
        $banco = new Banco();
        $result = $banco->save_banco($conn,  $nombre);

	if ($result)
        {
            $mensaje="El banco ha sido dado de alta correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el banco</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> bancos &gt;&gt; Nuevo banco ";
	$cabecera2="INSERTAR banco ";
}

if ($accion=="modificar") {
	$idbanco=$_POST["idbanco"];
        $banco = new banco();
        $result = $banco->update_banco($conn, $idbanco, $nombre);
	
        if ($result)
        {
            $mensaje="Los datos de la entidad bancaria han sido modificados correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el banco</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> bancos &gt;&gt; Modificar banco ";
	$cabecera2="MODIFICAR ENTIDAD BANCARIA ";
}

if ($accion=="baja") {
	$idbanco=$_REQUEST["idbanco"];
        $banco = new banco();
        $result = $banco->delete_banco($conn,$idbanco);

	if ($result)
        {
            $mensaje="La entidad bancaria ha sido dado de baja correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja el banco</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> banco &gt;&gt; Eliminar banco ";
	$cabecera2="ELIMINAR banco ";
	
        $result= $banco->get_banco_borrado_id($conn, $idbanco);
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