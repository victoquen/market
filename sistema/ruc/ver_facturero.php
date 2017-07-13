<?php 
error_reporting(0);
include ("../conexion/conexion.php");
include ("../js/fechas.php");
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

$idruc=$_GET["idruc"];
$idfacturero=$_GET["idfacturero"];

$query_f="SELECT a.id_facturero, a.id_ruc,a.serie1,a.serie2, a.autorizacion, a.inicio,a.fin, a.fecha_caducidad
                        FROM facturero a 
                        WHERE (a.id_ruc = $idruc) AND (a.id_facturero = $idfacturero)";
$rs_f=mysql_query($query_f,$conn);

$fecha_caducidad = implota(mysql_result($rs_f,0,"fecha_caducidad"));
?>

<html>
<head>
    <title>Modificar Tel&eacute;fono</title>
<script>
var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}

function guardar_facturero(idruc)
{
    var mensaje="";
            if (document.getElementById("establecimiento").value == "")
            {
                mensaje += "   - Ingrese Establecimiento.\n";
            }

            if (document.getElementById("tiposervicio").value == "")
            {
                mensaje += "   - Ingrese Tipo Servicio.\n"
            }

            if (document.getElementById("serieinicio").value == "")
            {
                mensaje += "   - Ingrese Serie Inicio.\n";
            }

            if (document.getElementById("seriefin").value == "")
            {
                mensaje += "   - Ingrese Serie Fin.\n";
            }

            if (document.getElementById("autorizacion").value == "")
            {
                mensaje += "   - Ingrese Autorizacion.\n";
            }

            if (document.getElementById("fecha_caducidad").value == "")
            {
                mensaje += "   - Ingrese Fecha Caducidad.\n";
            }
                
            if(mensaje!="")
            {
                alert("Atencion:\n"+mensaje);
            }
            else
            {
                document.getElementById("form1").submit();
               
                //parent.location.href="frame_telefonos_final.php?idproveedor="+idproveedor;
                parent.opener.document.location.href="index.php?idruc="+idruc;

                window.close();

            }
}

</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
<script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
<script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
<script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>

<script type="text/javascript" src="../js/validar.js"></script>
<script type="text/javascript" src="../js/fechas.js"></script>


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
			<div id="tituloForm" class="header">FACTURERO</div>
			<div id="frmBusqueda">



        <form name="form1" id="form1" method="post" action="guardar_facturero.php" >
          <table class="fuente8" width="95%" id="tabla_resultado" name="tabla_resultado" align="center">
                <tr>
                    <td width="6%">
                        Establecimiento:
                    </td>
                    <td width="15%">                                        
                        <input NAME="establecimiento" value="<?php  echo mysql_result($rs_f,0,"serie1");?>" type="text" class="cajaPequena" id="establecimiento" size="3" maxlength="3">
                    </td>
                </tr>
                <tr>
                    <td>
                        Tipo Servicio:
                    </td>
                    <td>                                        
                        <input NAME="tiposervicio" value="<?php  echo mysql_result($rs_f,0,"serie2");?>" type="text" class="cajaPequena" id="tiposervicio" size="3" maxlength="3">
                    </td>
                </tr>
                <tr>
                    <td width="6%">
                        Serie Inicio:
                    </td>
                    <td width="15%">
                        <input NAME="serieinicio" value="<?php  echo mysql_result($rs_f,0,"inicio");?>" type="text" class="cajaMedia" id="serieinicio" size="20" maxlength="20">
                    </td>
                </tr>
                <tr>
                    <td>
                        Serie Fin:
                    </td>
                    <td>
                        <input NAME="seriefin" value="<?php  echo mysql_result($rs_f,0,"fin");?>" type="text" class="cajaMedia" id="seriefin" size="20" maxlength="20">
                    </td>
                </tr>
                <tr>
                    <td width="6%">
                        Autorizaci&oacute;n:
                    </td>
                    <td width="15%">
                        <input NAME="autorizacion" value="<?php  echo mysql_result($rs_f,0,"autorizacion");?>" type="text" class="cajaMedia" id="autorizacion" size="20" maxlength="20">
                    </td>                                   
                </tr>   
                
                <tr>
                    <td >Fecha Vencto.:</td>
                    <td ><input NAME="fecha_caducidad" value="<?php  echo implota(mysql_result($rs_f,0,"fecha_caducidad"));?>" type="text" class="cajaPequena" id="fecha_caducidad" size="10" maxlength="10"  readonly> <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor = 'pointer'">
                        <script type="text/javascript">
                            Calendar.setup(
                                    {
                                        inputField: "fecha_caducidad",
                                        ifFormat: "%d/%m/%Y",
                                        button: "Image1"
                                    }
                            );
                        </script>
                    </td>                                    
                </tr>
                
        </table>
        

        </div>
</div>

        <table width="100%" border="0">
          <tr>
            <td><div align="center">
              <img src="../img/botonaceptar.jpg"  onClick="guardar_facturero(<?php  echo $idruc?>)" border="1" onMouseOver="style.cursor=cursor">
              <img src="../img/botoncerrar.jpg" width="70" height="22" onClick="window.close()" border="1" onMouseOver="style.cursor=cursor">
              
            </div></td>
          </tr>
        </table>
        <iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
                <ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
        </iframe>

       <input id="idproveedor" name="idruc" value="<?php  echo $idruc?>" type="hidden">
       <input id="idtelefono" name="idfacturero" value="<?php  echo $idfacturero?>" type="hidden">

        </form>


</div>
</div>



</body>
</html>
