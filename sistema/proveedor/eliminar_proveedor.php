<?php

$idproveedor=$_REQUEST["idproveedor"];

include_once '../conexion/conexion.php';
include_once 'class/proveedor.php';

$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();

$proveedor= new proveedor();
$row = $proveedor->get_proveedor_id($conn, $idproveedor);
?>

<html>
	<head>
                <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function aceptar(idproveedor) {
			location.href="save_proveedor.php?idproveedor=" + idproveedor + "&accion=baja";
		}
		
		function cancelar() {
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
				<div id="tituloForm" class="header">ELIMINAR proveedor </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
                                                <tr>
                                                    <td width="15%">CI/RUC</td>
                                                    <td width="43%"><?php echo $row["ci_ruc"]?></td>
                                                </tr>

                                                <tr>
                                                    <td width="15%">Empresa</td>
                                                    <td width="43%"><?php echo $row["empresa"]?></td>

                                                </tr>
                                                 <tr>
                                                    <td width="15%">Represenante Legal</td>
                                                    <td width="43%"><?php echo $row["representante"]?></td>
                                                </tr>                                                
                                                <tr>
                                                    <td width="15%">Email</td>
                                                    <td width="43%"><?php echo $row["email"]?></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Web</td>
                                                    <td width="43%"><?php echo $row["web"]?></td>
                                                </tr>
                                                <tr>
                                                    <td width="17%">Direcci&oacute;n</td>
                                                    <td><?php echo $row["direccion"]?></td>
                                                </tr>                                                
					</table>

                                    <!-- Inicio TELEFONOS OFICINA---------------------------------------------------->

                                    <?php
                                        $query_fono="SELECT numero, operadora, descripcion FROM proveedorfono WHERE id_proveedor='$idproveedor'";
                                        $rs_fono=mysql_query($query_fono,$conn);
                                        if(mysql_num_rows($rs_fono)>0)
                                        {
                                    ?>
                                    <div id="tituloForm" class="header" style="background: #EFD279">Tel&eacute;fonos Oficina</div>
                                    <table class="fuente8" width="50%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                                        <tr class="cabeceraTabla">
                                            <td width="15%">#</td>
                                            <td width="15%">OPERADORA</td>
                                            <td width="20%">DESCRIPCION</td>
                                        </tr>
                                     <?
                                             $contador=0;
                                             $num_rows_fono=mysql_num_rows($rs_fono);
                                             while($contador<$num_rows_fono)
                                             {

                                                $id_operadora=mysql_result($rs_fono,$contador,'operadora');
                                                $query_operadora="SELECT nombre FROM operadora WHERE id_operadora='$id_operadora'";
                                                $rs_operadora=mysql_query($query_operadora,$conn);

                                    ?>
                                    <tr>
                                        <td width="15%" align="center"><?php echo mysql_result($rs_fono,$contador,'numero')?></td>
                                        <td width="15%" align="center"><?php echo mysql_result($rs_operadora,0,'nombre')?></td>
                                        <td width="20%" align="center"><?php echo mysql_result($rs_fono,$contador,'descripcion')?></td>
                                    </tr>
                                    <?
                                                $contador++;
                                             }
                                        }
                                    ?>
                                </table>
                                <!-- Fin TELEFONOS OFICINA---------------------------------------------------->


                                <!-- Inicio BANCOS------------------------------------------------------------>

                                    <?php
                                        $query_banco="SELECT banco, titular, numero_cuenta, tipo_cuenta FROM proveedorbanco WHERE id_proveedor='$idproveedor'";
                                        $rs_banco=mysql_query($query_banco,$conn);
                                        if(mysql_num_rows($rs_banco)>0)
                                        {
                                    ?>
                                    <div id="tituloForm" class="header" style="background: #024769">Bancos</div>
                                    <table class="fuente8" width="70%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                                        <tr class="cabeceraTabla">
                                            <td width="14%">BANCO</td>
                                            <td width="28%">TITULAR</td>
                                            <td width="14%"># CUENTA</td>
                                            <td width="14%">TIPO CUENTA</td>

                                        </tr>
                                    <?
                                             $contador=0;
                                             $num_rows_banco=mysql_num_rows($rs_banco);
                                             while($contador<$num_rows_banco)
                                             {
                                                //1 cuenta corriente
                                                //2 cuenta de ahorros
                                                if(mysql_result($rs_banco,$contador,"tipo_cuenta")==1)
                                                {
                                                    $tipo_cuenta="Cuenta Corriente";
                                                }
                                                else
                                                {
                                                    $tipo_cuenta="Cuenta de Ahorros";
                                                }
                                                $banco=mysql_result($rs_banco,$contador,'banco');
                                                $query_nombanco="SELECT nombre FROM banco WHERE id_banco='$banco'";
                                                $rs_nombanco=mysql_query($query_nombanco,$conn);
                                    ?>
                                    <tr>
                                        <td width="14%" align="center"><?php echo mysql_result($rs_nombanco,0,'nombre')?></td>
                                        <td width="28%" align="center"><?php echo mysql_result($rs_banco,$contador,'titular')?></td>
                                        <td width="14%" align="center"><?php echo mysql_result($rs_banco,$contador,'numero_cuenta')?></td>
                                        <td width="14%" align="center"><?php echo $tipo_cuenta?></td>
                                    </tr>
                                    <?
                                                $contador++;
                                             }
                                        }
                                    ?>
                                </table>
                                <!-- Fino BANCOS-------------------------------------------------------------->


                                <!-- Inicio CONTACTOS--------------------------------------------------------->

                                    <?php
                                        $query_contacto="SELECT id_contacto, cargo,nombre,linea,email FROM proveedorcontacto WHERE id_proveedor='$idproveedor'";
                                        $rs_contacto=mysql_query($query_contacto,$conn);
                                        if(mysql_num_rows($rs_contacto)>0)
                                        {
                                    ?>
                                    <div id="tituloForm" class="header" style="background: #2C5700">Contactos</div>
                                    <table class="fuente8" width="70%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
                                        <tr class="cabeceraTabla">
                                            <td width="14%">CARGO</td>
                                            <td width="30%">NOMBRE</td>
                                            <td width="13%">LINEA</td>
                                            <td width="13%">EMAIL</td>
                                        </tr>
                                    <?
                                             $contador=0;
                                             $num_rows_contacto=mysql_num_rows($rs_contacto);
                                             while($contador<$num_rows_contacto)
                                             {
                                                $id_contacto=mysql_result($rs_contacto,$contador,'id_contacto');

                                    ?>
                                    <tr>
                                        <td width="14%" align="center"><?php echo mysql_result($rs_contacto,$contador,'cargo')?></td>
                                        <td width="30%" align="center"><?php echo mysql_result($rs_contacto,$contador,'nombre')?></td>
                                        <td width="13%" align="center"><?php echo mysql_result($rs_contacto,$contador,'linea')?></td>
                                        <td width="13%" align="center"><?php echo mysql_result($rs_contacto,$contador,'email')?></td>
                                    </tr>
                                    <tr><td colspan="4" align="center">
                                                <table class="fuente8" width="70%" cellspacing=0 cellpadding=3 border=0>
                                            <?

                                            ?>
                                            <?
                                                //Inicio TELEFONOS CONTACTO---------------------------------
                                                $query_contactofono="SELECT numero, operadora, descripcion FROM proveedorcontactofono WHERE id_proveedor='$idproveedor' AND id_contacto='$id_contacto'";
                                                $rs_contactofono=mysql_query($query_contactofono,$conn);
                                                if($rs_contactofono)
                                                {
                                                     $cont=0;
                                                     $num_rows_contactofono=mysql_num_rows($rs_contactofono);
                                                     while($cont<$num_rows_contactofono)
                                                    {
                                             ?>
                                                        <tr>
                                                            <td width="70%">
                                                                <BLOCKQUOTE>
                                                                <?
                                                                    $id_operadora=mysql_result($rs_contactofono,$cont,'operadora');
                                                                    $query_operadora="SELECT nombre FROM operadora WHERE id_operadora='$id_operadora'";
                                                                    $rs_operadora=mysql_query($query_operadora,$conn);
                                                                    echo mysql_result($rs_contactofono,$cont,'numero')."(".mysql_result($rs_operadora,0,'nombre').") ".mysql_result($rs_contactofono,$cont,'descripcion');
                                                                ?>
                                                                </BLOCKQUOTE>
                                                            </td>
                                                        </tr>
                                              <?
                                                         $cont++;
                                                    }

                                                }
                                                //Fin TELEFONOS CONTACTOS---------------------------------------
                                            ?>
                                              </table>


                                    <?
                                                $contador++;
                                    ?>

                                              </td></tr>
                                    <tr><td colspan="4"><hr/></td></tr>
                                    <?
                                             }
                                    ?>

                                   </table>
                                    <?
                                        }
                                    ?>



                                <!-- Fin CONTACTOS------------------------------------------------------------>


			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php echo $idproveedor?>)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			  </div>
		  </div>
		</div>
	</body>
</html>
