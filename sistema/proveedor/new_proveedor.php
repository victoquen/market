<?php
include("../js/fechas.php");
include_once '../conexion/conexion.php';
include_once 'class/proveedor.php';
$usuario = new ServidorBaseDatos();
$conn= $usuario->getConexion();


error_reporting(0);
$origen=$_GET["origen"];

$fechahoy=date("Y-m-d");
$sel_prov="INSERT INTO proveedortmp (idproveedor,fecha) VALUE ('','$fechahoy')";
$rs_prov=mysql_query($sel_prov, $conn);
$codproveedortmp=mysql_insert_id();

$query_deletetmp="DELETE FROM proveedorfonotmp WHERE idproveedor=$codproveedortmp";
$re_deletetmp=mysql_query($query_deletetmp,$conn);

$query_deletetmp="DELETE FROM proveedorbancotmp WHERE idproveedor=$codproveedortmp";
$re_deletetmp=mysql_query($query_deletetmp,$conn);

$query_deletetmp="DELETE FROM proveedorcontactotmp WHERE idproveedor=$codproveedortmp";
$re_deletetmp=mysql_query($query_deletetmp,$conn);

$query_deletetmp="DELETE FROM proveedorcontactofonotmp WHERE idproveedor=$codproveedortmp";
$re_deletetmp=mysql_query($query_deletetmp,$conn);

?>




<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
        <title>Principal</title>
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="../js/validar.js"></script>
        <!-- INICIO ARCHIVOS CALENDARIO -->
        <link rel="stylesheet" href="../css/jquery-ui.css"/>
        <link rel="stylesheet" href="../css/jquery-ui.min.css"/>
        <link rel="stylesheet" href="../css/jquery-ui.structure.css"/>
        <link rel="stylesheet" href="../css/jquery-ui.structure.min.css"/>
        <script src="../js/jquery-1.12.4.js"></script>
        <script src="../js/1.12.1_jquery-ui..js"></script>

        <script language="javascript">
            $( function() {
                $( "#fechacaducidad" ).datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'dd/mm/yy',
                    showOn: "button",
                    buttonImage: "../img/calendario.png",
                    buttonImageOnly: true,
                    buttonText: "Seleccionar Fecha"
                });
            } );
        </script>
        <!-- FIN ARCHIVOS CALENDARIO -->
        <script language="javascript">
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

        function limpiar() {
                document.getElementById("formulario").reset();
        }



         function validar_formulario(formulario,val)
        {
            validar(formulario,val);
        }

        function validar_telefono()
        {
            var mensaje="";
            if(document.getElementById("numero").value=="")
            {
                mensaje+="   - Ingrese numero telefonico.\n";
            }

            if(document.getElementById("operadora").value=="0")
            {
                mensaje+="   - Escoja operadora.\n"
            }
            if(mensaje!="")
            {
                alert("Atencion:\n"+mensaje);
            }
            else
            {
                document.getElementById("formulario_telefonos_oficina").submit();
                document.getElementById("numero").value="";
                document.getElementById("descripcion").value="";
                document.getElementById("operadora").value="4";
            }
        }

        function validar_banco()
        {
            var mensaje="";
            if(document.getElementById("banco").value=="0")
            {
                mensaje+="   - Escoja el banco.\n"
            }
            if(document.getElementById("numero_cuenta").value=="")
            {
                mensaje+="   - Ingrese numero de cuenta.\n";
            }
            if(document.getElementById("titular").value=="")
            {
                mensaje+="   - Ingrese titular de cuenta.\n";
            }
            
            if(document.getElementById("tipo").value=="0")
            {
                mensaje+="   - Escoja tipo de cuenta.\n"
            }
            if(mensaje!="")
            {
                alert("Atencion:\n"+mensaje);
            }
            else
            {
                document.getElementById("formulario_bancos").submit();
                document.getElementById("numero_cuenta").value="";
                document.getElementById("titular").value="";
                document.getElementById("banco").value="0";
                 document.getElementById("tipo").value="0";
            }
        }

        function validar_contacto()
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
                document.getElementById("formulario_contactos").submit();
                document.getElementById("cargo").value="";
                document.getElementById("nombre_contacto").value="";
                document.getElementById("linea_contacto").value="";
                document.getElementById("email_contacto").value="";
            }
        }



        </script>
    </head>
    <body>
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header">INSERTAR PROVEEDOR</div>
                    <div id="frmBusqueda">
                        <form id="formulario" name="formulario" method="post" action="save_proveedor.php">
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>



                                <tr>
                                    <td width="15%">Empresa</td>
                                    <td width="43%"><input NAME="Aempresa" type="text" class="cajaGrande" id="empresa" size="45" maxlength="45"></td>
                                    <td width="42%" rowspan="6" align="left" valign="top"><ul id="lista-errores"></ul></td>
                                </tr>
                                <tr>
                                    <td width="15%">CI/RUC</td>
                                    <td width="43%"><input NAME="Vci_ruc" type="text" class="cajaGrande" id="ci_ruc" size="13" maxlength="13"></td>
                                    
                                </tr>                                
                                 <tr>
                                    <td width="15%">Represenante Legal</td>
                                    <td width="43%"><input NAME="arepresentante" type="text" class="cajaGrande" id="representante" size="70" maxlength="70"></td>
                                </tr>                                                                                                                            
                                <tr>
                                    <td width="15%">Email</td>
                                    <td width="43%"><input NAME="aemail" id="email" type="text" class="cajaGrande1" size="35" maxlength="50" ></td>
                                </tr>
                                <tr>
                                    <td width="15%">Web</td>
                                    <td width="43%"><input NAME="aweb" id="web" type="text" class="cajaGrande1" size="35" maxlength="50" ></td>
                                </tr>
                                <tr>
                                    <td width="17%">Direcci&oacute;n</td>
                                    <td><input NAME="adireccion" id="direccion"  class="cajaGrande1" size="500" maxlength="500" ></td>
                                </tr>
                                <tr>
                                    <td width="17%">Lugar/Ciudad</td>
                                    <td width="43%"><input NAME="alugar" id="lugar" type="text" class="cajaGrande" size="35" maxlength="50" ></td>
                                </tr>
                                <tr>
                                    <td width="17%">Autorización:</td>
                                    <td width="43%"><input NAME="aautorizacion" id="autorizacion" type="text" class="cajaGrande" size="35" maxlength="50" ></td>
                                </tr>
                                <tr>
                                    <td width="15%" align="left">Fecha Caducidad:</td>
                                    <td width="43%"><input id="fechacaducidad" type="text" class="cajaPequena" NAME="fechacaducidad"
                                                           value="<?php echo date("d/m/Y") ?>" readonly/></td>

                                </tr>
                            </table>
                    </div>

                    <div id="botonBusqueda">
                         <input id="origen" name="origen" value="<?php  echo $origen?>" type="hidden">
                         <input id="codproveedortmp" name="codproveedortmp" value="<?php  echo $codproveedortmp;?>" type="hidden">
                        <input id="accion" name="accion" value="alta" type="hidden">
                        <input id="id" name="Zid" value="" type="hidden">
                    </div>
            </form>



<!--- INICIO FORMULARIO TELEFONOS OFICINA------------------------------------------------------------------------------------->

                <div id="frmBusqueda">
                        <form id="formulario_telefonos_oficina" name="formulario_telefonos_oficina" method="post" action="frame_telefonos_oficina.php" target="frame_telefonos_oficina">
                            <div id="tituloForm" class="header" style="background: #EFD279">OFICINA TELEFONOS</div>
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 >

                                 <?php 

                                    $query_o="SELECT * FROM operadora WHERE borrado=0 ORDER BY nombre ASC";
                                    $res_o=mysql_query($query_o,$conn);

                                ?>
                                <tr>
                                    <td width="">
                                        Numero Telf:&nbsp;
                                        <input NAME="numero" type="text" class="cajaPequena" id="numero" maxlength="13">&nbsp;
                                         Operadora:&nbsp;
                                        <select id="operadora"  class="comboMedio" NAME="operadora">
                                            <option value="0">Seleccionar operadora</option>
                                            <?php 
                                            $contador=0;
                                            while ($contador < mysql_num_rows($res_o)) 
                                                {
                                                    if(mysql_result($res_o,$contador,"nombre")=="FIJO")
                                                    {?>
                                                        <option selected value="<?php  echo mysql_result($res_o,$contador,"id_operadora")?>"><?php  echo mysql_result($res_o,$contador,"nombre")?></option>
                                            

                                                     <?php } else {?>
                                                        <option value="<?php  echo mysql_result($res_o,$contador,"id_operadora")?>"><?php  echo mysql_result($res_o,$contador,"nombre")?></option>
                                            <?php  }$contador++;
                                            } ?>
                                        </select>
                                         &nbsp;
                                         Descripci&oacute;n:&nbsp;
                                        <input NAME="descripcion" type="text" class="cajaMedia" id="descripcion" size="45" maxlength="45">
                                        &nbsp;
                                        <img src="../img/guardar.png" width="23" height="29" onClick="validar_telefono()" onMouseOver="style.cursor=cursor" title="Agregar telefono">
                                    </td>
                                </tr>
                            </table>
                    </div>


                     <div id="frmBusqueda">
				<table class="fuente8" width="50%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							<td width="15%">#</td>
                                                        <td width="10%">OPERADORA</td>
                                                        <td width="20%">DESCRIPCION</td>
							<td width="5%">&nbsp;</td>
						</tr>
				</table>
				<div id="lineaResultado">
                                    <iframe align="middle" width="100%" height="110" id="frame_telefonos_oficina" name="frame_telefonos_oficina" frameborder="0" >
						<ilayer  width="100%" height="110" id="frame_telefonos_oficina" name="frame_telefonos_oficina"></ilayer>
					</iframe>



				</div>

                    </div>

                              
             <input id="codproveedortmp" name="codproveedortmp" value="<?php  echo $codproveedortmp;?>" type="hidden">
            </form>

<!--- FIN FORMULARIO TELEFONOS OFICINA------------------------------------------------------------------------------------->

<hr style="color: #EFD279"/>
<hr style="color: #EFD279"/>


<!--- INICIO FORMULARIO BANCOS OFICINA------------------------------------------------------------------------------------->

                <div id="frmBusqueda">
                        <form id="formulario_bancos" name="formulario_bancos" method="post" action="frame_bancos.php" target="frame_bancos">
                            <div id="tituloForm" class="header" style="background: #024769">BANCOS</div>
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 >

                                 <?php 

                                    $query_b="SELECT * FROM banco WHERE borrado=0 ORDER BY nombre ASC";
                                    $res_b=mysql_query($query_b,$conn);

                                ?>
                                <tr>
                                    <td width="">
                                         Banco:&nbsp;
                                        <select id="banco"  class="comboMedio" NAME="banco">
                                            <option value="0">Seleccionar banco</option>
                                            <?php 
                                            $contador=0;
                                            while ($contador < mysql_num_rows($res_b))
                                                {
                                                    
                                            ?>                                                    
                                               <option value="<?php  echo mysql_result($res_b,$contador,"id_banco")?>"><?php  echo mysql_result($res_b,$contador,"nombre")?></option>
                                            <?php  $contador++;
                                            } ?>
                                        </select>
                                         &nbsp;
                                         Titular Cuenta:&nbsp;
                                        <input NAME="titular" type="text" class="cajaMedia" id="titular" size="45" maxlength="45">
                                        &nbsp;
                                         Numero Cuenta:&nbsp;
                                        <input NAME="numero_cuenta" type="text" class="cajaPequena" id="numero_cuenta" maxlength="13">&nbsp;
                                         Tipo Cuenta:&nbsp;
                                         <select id="tipo" class="comboMedio" name="tipo">
                                             <option value="0">Seleccionar Tipo cuenta</option>
                                             <option value="1">Cuenta Corriente</option>
                                             <option value="2">Cuenta de Ahorros</option>
                                         </select>
                                        &nbsp;
                                         <img src="../img/guardar.png" width="23" height="29" onClick="validar_banco()" onMouseOver="style.cursor=cursor" title="Agregar Banco">
                                    </td>
                                </tr>
                            </table>
                    </div>


                     <div id="frmBusqueda">
				<table class="fuente8" width="80%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							<td width="15%">BANCO</td>
                                                        <td width="30%">TITULAR</td>
                                                        <td width="15%"># CUENTA</td>
                                                        <td width="15%">TIPO CUENTA</td>
							<td width="5%">&nbsp;</td>
						</tr>
				</table>
				<div id="lineaResultado">
                                    <iframe align="middle" width="100%" height="120" id="frame_bancos" name="frame_bancos" frameborder="0" >
						<ilayer  width="100%" height="120" id="frame_bancos" name="frame_bancos"></ilayer>
					</iframe>



				</div>

                    </div>

                             
             <input id="codproveedortmp" name="codproveedortmp" value="<?php  echo $codproveedortmp;?>" type="hidden">
            </form>

<!--- FIN FORMULARIO BANCOS ------------------------------------------------------------------------------------->


<hr style="color: #024769"/>
<hr style="color: #024769"/>


<!--- INICIO FORMULARIO CONTACTOS------------------------------------------------------------------------------------->

                <div id="frmBusqueda">
                        <form id="formulario_contactos" name="formulario_contactos" method="post" action="frame_contactos.php" target="frame_contactos">
                            <div id="tituloForm" class="header" style="background: #2C5700">CONTACTOS</div>
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 >

                                
                                <tr>
                                    <td width="">                                        
                                        Cargo:&nbsp;
                                        <input NAME="cargo" type="text" class="cajaMedia" id="cargo" maxlength="30">
                                        &nbsp;
                                        Nombre:&nbsp;
                                        <input NAME="nombre_contacto" type="text" class="cajaMedia" id="nombre_contacto" maxlength="50">
                                        &nbsp;
                                        L&iacute;nea:&nbsp;
                                        <input NAME="linea_contacto" type="text" class="cajaMedia" id="linea_contacto" maxlength="30">
                                        &nbsp;
                                        Email:&nbsp;
                                        <input NAME="email_contacto" type="text" class="cajaMedia1" id="email_contacto" maxlength="30">
                                        &nbsp;
                                        <img src="../img/guardar.png" width="23" height="29" onClick="validar_contacto()" onMouseOver="style.cursor=cursor" title="Agregar contacto">
                                    </td>
                                </tr>
                            </table>
                    </div>


                     <div id="frmBusqueda">
				<table class="fuente8" width="85%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							<td width="15%">CARGO</td>
                                                        <td width="30%">NOMBRE</td>
                                                        <td width="15%">LINEA</td>
                                                        <td width="15%">EMAIL</td>
							<td width="5%">&nbsp;</td>
                                                        <td width="5%">&nbsp;</td>
						</tr>
				</table>
				<div id="lineaResultado">
                                    <iframe align="middle" width="100%" height="150" id="frame_contactos" name="frame_contactos" frameborder="0" >
						<ilayer  width="100%" height="150" id="frame_contactos" name="frame_contactos"></ilayer>
					</iframe>



				</div>

                    </div>

                    <div id="botonBusqueda">
                        <?php if ($origen=="factura"){?>
                        <input id="origen" name="origen" value="<?php  echo $origen?>" type="hidden">
                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar_formulario(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
                        <?php }else{?>
                        <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar_formulario(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
                        <img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor=cursor">
                        <img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
                        <?php }?>


                    </div>
             <input id="codproveedortmp" name="codproveedortmp" value="<?php  echo $codproveedortmp;?>" type="hidden">
            </form>

<!--- FIN FORMULARIO CONTACTOS------------------------------------------------------------------------------------->




            </div>
            </div>
        </div>
    </body>
</html>