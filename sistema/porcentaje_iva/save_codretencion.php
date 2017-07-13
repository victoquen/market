<?php
include_once 'class/porcentaje_iva.php';
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

	$porcentaje = $_POST["porcentaje"];
	$activo = $_POST["Acbotipos"];
}

if ($accion=="alta") {
        $reten = new Porcentaje_iva();
        $result = $reten->save($conn,$porcentaje, $activo);

	if ($result)
        {
            $mensaje="Iva ha sido dado de alta correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar datos</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> C&oacute;digo Retenci&oacute;n &gt;&gt; Nuevo C&oacute;digo Iva ";
	$cabecera2="INSERTAR CODIGO DE IVA ";
}

if ($accion=="modificar") {
	$id=$_POST["id"];
        $reten = new Porcentaje_iva();
        $result = $reten->update($conn, $id, $porcentaje, $activo);
	
        if ($result)
        {
            $mensaje="Los datos de IVA han sido modificados correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar la retencion</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> C&oacute;digo Retenci&oacute;n &gt;&gt; Nuevo C&oacute;digo Ivan ";
	$cabecera2="MODIFICAR CODIGOS DE IVA ";
}

if ($accion=="baja") {
	$id=$_POST["id"];
        $reten = new Porcentaje_iva();
        $result = $reten->delete($conn,$id);

	if ($result)
        {
            $mensaje="CODIGO DE RETENCION ha sido dado de baja correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja IVA</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> C&oacute;digo Retenci&oacute;n &gt;&gt; Nuevo C&oacute;digo IVA ";
	$cabecera2="ELIMINAR CODIGO DE IVA ";
	
        $result= $reten->get_iva_borrado_id($conn, $id);

		$porcentaje = $result['porcentaje'];
		$activo = $result['activo'];
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
							<td width="15%">Porcentaje</td>
						    <td width="85%" colspan="2"><?php echo $porcentaje;?></td>
					    </tr>
						<tr>
							<td width="15%"><strong>Tipo</strong></td>
							<?php if($activo == 1){?>
							<td width="85%" colspan="2">SI</td>
							<?php } else {?>
								<td width="85%" colspan="2">NO</td>
							<?php }?>
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