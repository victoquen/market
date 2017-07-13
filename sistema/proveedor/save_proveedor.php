<?php 
include_once 'class/proveedor.php';
include_once '../conexion/conexion.php';
$usuario = new ServidorBaseDatos();
$conn = $usuario->getConexion();

error_reporting(0);


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
    $codproveedortmp=$_POST["codproveedortmp"];
    $origen=$_POST["origen"];

    $ci_ruc=$_POST["Vci_ruc"];
    $empresa=strtoupper($_POST["Aempresa"]);
    $representante=strtoupper($_POST["arepresentante"]);    
    $email=$_POST["aemail"];
    $web=$_POST["aweb"];
    $direccion=strtoupper($_POST["adireccion"]);
    $lugar=strtoupper($_POST["alugar"]);
}

if ($accion=="alta") {
        $proveedor = new proveedor();
        $idproveedor = $proveedor->save_proveedor($conn, $ci_ruc,$empresa, $representante,$email,$web,$direccion,$lugar);

	if ($idproveedor)
        {
            $mensaje="El proveedor ha sido dado de alta correctamente";
            $validacion=0;

//--------- Inicio Guardar TELEFONOS OFICINA del proveedor------------------------------------------------------------
            $query_tmp="SELECT * FROM proveedorfonotmp WHERE idproveedor='$codproveedortmp' ORDER BY numfono ASC";
            $rs_tmp=mysql_query($query_tmp, $conn);
            $contador=0;

            include("class/proveedorfono.php");
            $telefono= new Proveedorfono();
            $num_rows=mysql_num_rows($rs_tmp);
            if($num_rows > 0)
            {
                while ($contador < $num_rows)
                {
                    $numero=mysql_result($rs_tmp,$contador,"numero");
                    $descripcion=mysql_result($rs_tmp,$contador,"descripcion");
                    $operadora=mysql_result($rs_tmp,$contador,"operadora");
                    $result=$telefono->save_telefono($conn,$idproveedor, $numero, $descripcion, $operadora);
                    $contador++;
                }
            }
//--------- Fin Guardar TELEFONOS OFICINA del proveedor------------------------------------------------------------


//--------- Inicio Guardar BANCOS del proveedor--------------------------------------------------------------------
            $query_tmp="SELECT * FROM proveedorbancotmp WHERE idproveedor='$codproveedortmp' ORDER BY numbanco ASC";
            $rs_tmp=mysql_query($query_tmp, $conn);
            $contador=0;

            include("class/proveedorbanco.php");
            $bancoprov= new Proveedorbanco();
            $num_rows=mysql_num_rows($rs_tmp);
            if($num_rows > 0)
            {
                while ($contador < $num_rows)
                {
                    $banco=mysql_result($rs_tmp,$contador,"banco");
                    $titular=mysql_result($rs_tmp,$contador,"titular");
                    $numero_cuenta=mysql_result($rs_tmp,$contador,"numero_cuenta");
                    $tipo_cuenta=mysql_result($rs_tmp,$contador,"tipo_cuenta");
                    $result=$bancoprov->save_banco($conn,$idproveedor, $banco, $titular, $numero_cuenta, $tipo_cuenta);
                    $contador++;
                }
            }
//--------- Fin Guardar BANCOS del proveedor--------------------------------------------------------------------

//--------- Inicio Guardar CONTACTOS del proveedor-------------------------------------------------------------
            $query_tmp="SELECT * FROM proveedorcontactotmp WHERE idproveedor='$codproveedortmp' ORDER BY numcontacto ASC";
            $rs_tmp=mysql_query($query_tmp, $conn);
            $contador=0;

            include("class/proveedorcontacto.php");
            $contacto= new Proveedorcontacto();

            include ("class/proveedorcontactofono.php");
            $contactofono= new Proveedorcontactofono();

            $num_rows=mysql_num_rows($rs_tmp);
            if($num_rows > 0)
            {
                while ($contador < $num_rows)
                {
                    $numcontacto=mysql_result($rs_tmp,$contador,"numcontacto");
                    $cargo=mysql_result($rs_tmp,$contador,"cargo");
                    $nombre=mysql_result($rs_tmp,$contador,"nombre");
                    $linea=mysql_result($rs_tmp,$contador,"linea");
                    $email_contacto=mysql_result($rs_tmp,$contador,"email");
                    $idcontacto=$contacto->save_contacto($conn,$idproveedor, $cargo,$nombre, $linea, $email_contacto);

           //------ Inicio Guardar TELEFONOS del CONTACTO---------------------------------------
                    if($idcontacto)
                    {
                        $query_tmpfonos="SELECT *
                                        FROM proveedorcontactofonotmp
                                        WHERE idproveedor='$codproveedortmp' AND numcontacto='$numcontacto' ORDER BY numfono ASC";
                        $rs_tmpfonos=mysql_query($query_tmpfonos, $conn);
                        $cont=0;

                        
                        $num_rowsfono=mysql_num_rows($rs_tmpfonos);
                        if($num_rowsfono > 0)
                        {
                            while ($cont < $num_rowsfono)
                            {
                                $numero=mysql_result($rs_tmpfonos,$cont,"numero");
                                $descripcion=mysql_result($rs_tmpfonos,$cont,"descripcion");
                                $operadora=mysql_result($rs_tmpfonos,$cont,"operadora");
                                $result=$contactofono->save_telefono($conn,$idproveedor,$idcontacto, $numero, $descripcion, $operadora);
                                $cont++;
                            }
                        }
                    }
           //------ Fin Guardar TELEFONOS del CONTACTO---------------------------------------
                    $contador++;
                }
            }
//--------- Fin Guardar CONTACTOS del proveedor--------------------------------------------------------------------
            $query_deletetmp="DELETE FROM proveedorfonotmp WHERE idproveedor=$codproveedortmp";
            $re_deletetmp=mysql_query($query_deletetmp,$conn);

            $query_deletetmp="DELETE FROM proveedorbancotmp WHERE idproveedor=$codproveedortmp";
            $re_deletetmp=mysql_query($query_deletetmp,$conn);

            $query_deletetmp="DELETE FROM proveedorcontactotmp WHERE idproveedor=$codproveedortmp";
            $re_deletetmp=mysql_query($query_deletetmp,$conn);

            $query_deletetmp="DELETE FROM proveedorcontactofonotmp WHERE idproveedor=$codproveedortmp";
            $re_deletetmp=mysql_query($query_deletetmp,$conn);

            $query_deletetmp="DELETE FROM proveedortmp WHERE idproveedor=$codproveedortmp";
            $re_deletetmp=mysql_query($query_deletetmp,$conn);
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el proveedor</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> proveedores &gt;&gt; Nuevo proveedor ";
	$cabecera2="INSERTAR PROVEEDOR ";
}



if ($accion=="modificar") {
	$idproveedor=$_POST["idproveedor"];
        $proveedor = new proveedor();
        $result = $proveedor->update_proveedor($conn, $idproveedor, $ci_ruc,$empresa, $representante,$email,$web,$direccion, $lugar);
	
        if ($result)
        {
            $mensaje="Los datos del proveedor han sido modificados correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'>   El CODIGO ya existe, ERROR al ingresar el proveedor</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> proveedores &gt;&gt; Modificar proveedor ";
	$cabecera2="MODIFICAR proveedor ";
}





if ($accion=="baja") {
	$idproveedor=$_REQUEST["idproveedor"];
        $proveedor = new proveedor();
        $result = $proveedor->delete_proveedor($conn,$idproveedor);

	if ($result)
        {
            $mensaje="El proveedor ha sido dado de baja correctamente";
            $validacion=0;
        }
        else
        {
            $mensaje = "<span style='color:#f8f8ff '><img src='../img/error_icon.png'> ERROR al dar de baja el proveedor</span>";
            $validacion=1;
        }
	$cabecera1="Inicio >> proveedor &gt;&gt; Eliminar proveedor ";
	$cabecera2="ELIMINAR proveedor ";
	
        $result= $proveedor->get_proveedor_borrado_id($conn, $idproveedor);
        
        $empresa=$result["empresa"];
        $ci_ruc=$result["ci_ruc"];
        $representante=$result["representante"];        
        $email=$result["email"];
        $web=$result["web"];
        $direccion=$result["direccion"];
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


                 function ingreso_factura(validacion,id,nombre,ci_ruc) {
                    if(validacion==0){
                        parent.opener.document.formulario.codproveedor.value=id;
                        parent.opener.document.formulario.nombre.value=nombre;
                        parent.opener.document.formulario.ci_ruc.value=ci_ruc;                       
                        parent.window.close();
                    }
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
				<div id="tituloForm" class="header"><?php  echo $cabecera2?>--<?php  echo $mensaje?></div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
                                                    <td width="15%">CI/RUC</td>
                                                    <td width="43%"><?php  echo $ci_ruc?></td>
                                                </tr>

                                                <tr>
                                                    <td width="15%">Empresa</td>
                                                    <td width="43%"><?php  echo $empresa?></td>

                                                </tr>
                                                 <tr>
                                                    <td width="15%">Represenante Legal</td>
                                                    <td width="43%"><?php  echo $representante?></td>
                                                </tr>                                                 
                                                <tr>
                                                    <td width="15%">Email</td>
                                                    <td width="43%"><?php  echo $email?></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Web</td>
                                                    <td width="43%"><?php  echo $web?></td>
                                                </tr>
                                                <tr>
                                                    <td width="17%">Direcci&oacute;n</td>
                                                    <td width="43%"><?php  echo $direccion?></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">Lugar/Ciudad</td>
                                                    <td width="43%"><?php  echo $lugar?></td>
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
                                     <?php 
                                             $contador=0;
                                             $num_rows_fono=mysql_num_rows($rs_fono);
                                             while($contador<$num_rows_fono)
                                             {

                                                $id_operadora=mysql_result($rs_fono,$contador,'operadora');
                                                $query_operadora="SELECT nombre FROM operadora WHERE id_operadora='$id_operadora'";
                                                $rs_operadora=mysql_query($query_operadora,$conn);

                                    ?>
                                    <tr>
                                        <td width="15%" align="center"><?php  echo mysql_result($rs_fono,$contador,'numero')?></td>
                                        <td width="15%" align="center"><?php  echo mysql_result($rs_operadora,0,'nombre')?></td>
                                        <td width="20%" align="center"><?php  echo mysql_result($rs_fono,$contador,'descripcion')?></td>
                                    </tr>
                                    <?php 
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
                                    <?php 
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
                                        <td width="14%" align="center"><?php  echo mysql_result($rs_nombanco,0,'nombre')?></td>
                                        <td width="28%" align="center"><?php  echo mysql_result($rs_banco,$contador,'titular')?></td>
                                        <td width="14%" align="center"><?php  echo mysql_result($rs_banco,$contador,'numero_cuenta')?></td>
                                        <td width="14%" align="center"><?php  echo $tipo_cuenta?></td>
                                    </tr>
                                    <?php 
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
                                    <?php 
                                             $contador=0;
                                             $num_rows_contacto=mysql_num_rows($rs_contacto);
                                             while($contador<$num_rows_contacto)
                                             {
                                                $id_contacto=mysql_result($rs_contacto,$contador,'id_contacto');

                                    ?>
                                    <tr>
                                        <td width="14%" align="center"><?php  echo mysql_result($rs_contacto,$contador,'cargo')?></td>
                                        <td width="30%" align="center"><?php  echo mysql_result($rs_contacto,$contador,'nombre')?></td>
                                        <td width="13%" align="center"><?php  echo mysql_result($rs_contacto,$contador,'linea')?></td>
                                        <td width="13%" align="center"><?php  echo mysql_result($rs_contacto,$contador,'email')?></td>
                                    </tr>
                                    <tr><td colspan="4" align="center">
                                                <table class="fuente8" width="70%" cellspacing=0 cellpadding=3 border=0>
                                            <?php 

                                            ?>
                                            <?php 
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
                                                                <?php 
                                                                    $id_operadora=mysql_result($rs_contactofono,$cont,'operadora');
                                                                    $query_operadora="SELECT nombre FROM operadora WHERE id_operadora='$id_operadora'";
                                                                    $rs_operadora=mysql_query($query_operadora,$conn);
                                                                    echo mysql_result($rs_contactofono,$cont,'numero')."(".mysql_result($rs_operadora,0,'nombre').") ".mysql_result($rs_contactofono,$cont,'descripcion');
                                                                ?>
                                                                </BLOCKQUOTE>
                                                            </td>
                                                        </tr>
                                              <?php 
                                                         $cont++;
                                                    }

                                                }
                                                //Fin TELEFONOS CONTACTOS---------------------------------------
                                            ?>
                                              </table>


                                    <?php 
                                                $contador++;
                                    ?>

                                              </td></tr>
                                    <tr><td colspan="4"><hr/></td></tr>
                                    <?php 
                                             }
                                    ?>

                                   </table>
                                    <?php 
                                        }
                                    ?>



                                <!-- Fin CONTACTOS------------------------------------------------------------>
                               

			  </div>
				<div id="botonBusqueda">
                                     <?php if ($origen=="factura"){?>
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="ingreso_factura(<?php  echo $validacion?>,'<?php  echo $idproveedor?>','<?php  echo $empresa?>','<?php  echo $ci_ruc?>')" border="1" onMouseOver="style.cursor=cursor">
                                     <?php }else{?>
                                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php  echo $validacion?>)" border="1" onMouseOver="style.cursor=cursor">
                                     <?php }?>
                                </div>
			 </div>
		  </div>
		</div>
	</body>
</html>