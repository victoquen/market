<?php
include_once 'class/grupo.php';
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
    $codigo=strtoupper($_POST["Acodigo"]);
    $nombre=strtoupper($_POST["Anombre"]);
}

if ($accion=="alta") {
        $grupo = new Grupo();
        $result = $grupo->save_grupo($conn, $codigo, $nombre);

	if ($result)
        {
            $mensaje="El grupo ha sido dado de alta correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el GRUPO</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> grupos &gt;&gt; Nuevo grupo ";
	$cabecera2="INSERTAR GRUPO ";
}

if ($accion=="modificar") {
	$idgrupo=$_POST["idgrupo"];
        $grupo = new Grupo();
        $result = $grupo->update_grupo($conn, $idgrupo, $codigo, $nombre);
	
        if ($result)
        {
            $mensaje="Los datos del grupo han sido modificados correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el GRUPO</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> grupos &gt;&gt; Modificar grupo ";
	$cabecera2="MODIFICAR GRUPO ";
}

if ($accion=="baja") {
	$idgrupo=$_REQUEST["idgrupo"];
        $grupo = new Grupo();
        $result = $grupo->delete_grupo($conn,$idgrupo);

	if ($result)
        {
            $mensaje="El grupo ha sido dado de baja correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja el grupo</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> grupo &gt;&gt; Eliminar grupo ";
	$cabecera2="ELIMINAR GRUPO ";
	
        $result= $grupo->get_grupo_borrado_id($conn, $idgrupo);
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
							<td width="15%">C&oacute;digo</td>
							<td width="85%" colspan="2"><?php echo $codigo?></td>
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