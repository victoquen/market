<?php 
include_once '../conexion/conexion.php';
include_once 'class/cliente.php';

$idcliente=$_REQUEST["idcliente"];

$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();

$cliente= new cliente();
$row = $cliente->get_cliente_id($conn, $idcliente);
if($row['image'] === ""){
    $row['image'] = "person.png";
}

?>

<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function aceptar() {
			location.href="index.php";
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
				<div id="tituloForm" class="header">VER CLIENTE </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                                <tr>
                                                    <td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php  echo $row['nombre']?></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Empresa</td>
						    <td width="85%" colspan="2"><?php  echo $row['empresa']?></td>
                                                </tr>
						<tr>
							<td width="15%">CI/RUC</td>
							<td width="85%" colspan="2"><?php  echo $row['ci_ruc']?></td>
                                                </tr>

                                                <?php 
 
                                                    $rtipo = $cliente->get_nombretipo($row['codigo_tipocliente'],$conn);
                                                ?>
                                                <tr>
                                                    <td width="15%"><strong>Tipo</strong></td>
                                                    <td width="85%" colspan="2"><?php  echo $rtipo['nombre']?></td>
                                                </tr>                                              
                                                <tr>
							<td width="15%">Email</td>
						    <td width="85%" colspan="2"><?php  echo $row['email']?></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Direcci&oacute;n</td>
						    <td width="85%" colspan="2"><?php  echo $row['direccion']?></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Lugar/Ciudad</td>
						    <td width="85%" colspan="2"><?php  echo $row['lugar']?></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Credito</td>
						    <td width="85%" colspan="2"><?php  echo $row['credito']?></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">Tel&eacute;fono(s):</td>
                                                </tr>
                                                <?php 
                                                    $query_fono="SELECT numero, operadora, descripcion FROM clientefono WHERE id_cliente='$idcliente'";
                                                    $rs_fono=mysql_query($query_fono,$conn);
                                                    if($rs_fono)
                                                    {
                                                        $contador=0;
                                                         $num_rows_fono=mysql_num_rows($rs_fono);
                                                         while($contador<$num_rows_fono)
                                                         {

                                                ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <BLOCKQUOTE>
                                                        <?php 
                                                            $id_operadora=mysql_result($rs_fono,$contador,'operadora');
                                                            $query_operadora="SELECT nombre FROM operadora WHERE id_operadora='$id_operadora'";
                                                            $rs_operadora=mysql_query($query_operadora,$conn);
                                                            echo mysql_result($rs_fono,$contador,'numero')."(".mysql_result($rs_operadora,0,'nombre').") ".mysql_result($rs_fono,$contador,'descripcion');
                                                        ?>
                                                        </BLOCKQUOTE>
                                                    </td>
                                                </tr>
                                                <?php 
                                                            $contador++;
                                                         }
                                                    }
                                                ?>
                        <tr>
                            <td></td>
                            <td>
                                <img src="fotografias/<?php  echo $row['image']; ?>" class="img-rounded" width="150px" height="200px" />
                            </td>
                        </tr>
					</table>
                                </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			 </div>
		  </div>
		</div>
	</body>
</html>
