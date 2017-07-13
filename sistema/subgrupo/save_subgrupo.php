<?php 
include_once 'class/subgrupo.php';
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
    $grupo=$_POST["AcboGrupos"];
    $subgrupo = new Subgrupo();
    $result=$subgrupo->get_nombregrupo($grupo, $conn);
    $nombre_grupo=$result['nombre'];
}

if ($accion=="alta") {
        $subgrupo = new Subgrupo();
        $result = $subgrupo->save_subgrupo($conn, $grupo, $codigo, $nombre);

	if ($result)
        {
            $mensaje="El subgrupo ha sido dado de alta correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el subgrupo". $codigo."-".$nombre."-".$grupo."</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> subgrupos &gt;&gt; Nuevo subgrupo ";
	$cabecera2="INSERTAR subgrupo ";
}

if ($accion=="modificar") {
	$idsubgrupo=$_POST["idsubgrupo"];
        $subgrupo = new subgrupo();
        $result = $subgrupo->update_subgrupo($conn, $idsubgrupo,$grupo, $codigo, $nombre);
	
        if ($result)
        {
            $mensaje="Los datos del subgrupo han sido modificados correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el subgrupo</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> subgrupos &gt;&gt; Modificar subgrupo ";
	$cabecera2="MODIFICAR subgrupo ";
}

if ($accion=="baja") {
	$idsubgrupo=$_REQUEST["idsubgrupo"];
        $subgrupo = new subgrupo();
        $result = $subgrupo->delete_subgrupo($conn,$idsubgrupo);

	if ($result)
        {
            $mensaje="El subgrupo ha sido dado de baja correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja el subgrupo</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> subgrupo &gt;&gt; Eliminar subgrupo ";
	$cabecera2="ELIMINAR subgrupo ";
	
        $result= $subgrupo->get_subgrupo_borrado_id($conn, $idsubgrupo);
        $codigo=$result['codigo'];
        $nombre=$result['nombre'];

        $resultg=$subgrupo->get_nombregrupo($result['id_grupo'], $conn);
        $nombre_grupo=$resultg['nombre'];
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
							<td width="15%">C&oacute;digo</td>
							<td width="85%" colspan="2"><?php  echo $codigo?></td>
                                                </tr>
						<tr>
                                                    <td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php  echo $nombre?></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Grupo</td>
						    <td width="85%" colspan="2"><?php  echo $nombre_grupo?></td>
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