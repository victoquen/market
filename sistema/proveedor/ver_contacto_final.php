<?php 
include ("../conexion/conexion.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idproveedor=$_GET["idproveedor"];
$idcontacto=$_GET["idcontacto"];

$query_f="SELECT cargo,nombre,linea,email FROM proveedorcontacto WHERE id_proveedor ='".$idproveedor."' AND id_contacto='".$idcontacto."'";
$rs_f=mysql_query($query_f,$conn);

?>

<html>
<head>
    <title>Modificar Banco</title>
<script>
var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}

function guardar_contacto(idproveedor)
{
      var mensaje="";
            if(document.getElementById("cargo").value=="")
            {
                mensaje+="   - Ingrese cargo del contacto.\n";
            }
            if(document.getElementById("nombre_contacto").value=="")
            {
                mensaje+="   - Ingrese nombre del contacto.\n";
            }

            if(document.getElementById("linea_contacto").value=="")
            {
                mensaje+="   - Ingrese linea del contacto.\n"
            }

            if(mensaje!="")
            {
                alert("Atencion:\n"+mensaje);
            }
            else
            {
                document.getElementById("form1").submit();
               
                //parent.location.href="frame_bancos_final.php?idproveedor="+idproveedor;
                parent.opener.document.location.href="modificar_proveedor.php?idproveedor="+idproveedor;

                 window.close();

            }
}

</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>




<body>
    <div id="pagina">
	<div id="zonaContenido">
		<div align="center">
			<div id="tituloForm" class="header">banco</div>
			<div id="frmBusqueda">



        <form name="form1" id="form1" method="post" action="guardar_contactos_final.php" >
          <table class="fuente8" width="95%" id="tabla_resultado" name="tabla_resultado" align="center">
              <tr>
                    <td width="5%">Cargo:</td>
                    <td width="10%"><input NAME="cargo" value="<?php  echo mysql_result($rs_f,0,"cargo")?>" type="text" class="cajaMedia" id="cargo" maxlength="30"></td>
              </tr>
               <tr>
                    <td width="5%">Nombre:</td>
                    <td width="10%"><input NAME="nombre_contacto" value="<?php  echo mysql_result($rs_f,0,'nombre')?>" type="text" class="cajaMedia" id="nombre_contacto" maxlength="50"></td>
               </tr>
               <tr>
                    <td width="5%">L&iacute;nea:</td>
                    <td width="10%"><input NAME="linea_contacto" value="<?php  echo mysql_result($rs_f,0,'linea')?>" type="text" class="cajaMedia" id="linea_contacto" maxlength="30"></td>
              </tr>
               <tr>
                    <td width="5%">Email:</td>
                    <td width="10%"><input NAME="email_contacto" value="<?php  echo mysql_result($rs_f,0,'email')?>" type="text" class="cajaMedia1" id="email_contacto" maxlength="30"></td>
             </tr>
        </table>
        

        </div>
</div>

        <table width="100%" border="0">
          <tr>
            <td><div align="center">
              <img src="../img/botonaceptar.jpg"  onClick="guardar_contacto(<?php  echo $idproveedor?>)" border="1" onMouseOver="style.cursor=cursor">
              <img src="../img/botoncerrar.jpg" width="70" height="22" onClick="window.close()" border="1" onMouseOver="style.cursor=cursor">
              
            </div></td>
          </tr>
        </table>
        <iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
                <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
        </iframe>

       <input id="idproveedor" name="idproveedor" value="<?php  echo $idproveedor?>" type="hidden">
       <input id="idcontacto" name="idcontacto" value="<?php  echo $idcontacto?>" type="hidden">

        </form>


</div>
</div>



</body>
</html>
