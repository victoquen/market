
<html>
    <head>
        <title>Cobros</title>
        <link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
        <link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
        <script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
        <script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
        <script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>
        <script language="javascript">
            var cursor;
            if (document.all) {
                // Está utilizando EXPLORER
                cursor = 'hand';
            } else {
                // Está utilizando MOZILLA/NETSCAPE
                cursor = 'pointer';
            }


            function inicio() {
                document.getElementById("formulario").submit();
            }

            function buscar() {

                document.getElementById("formulario").submit();
            }

            function limpiar() {
                document.getElementById("formulario").reset();
            }
            
            
            function validarFormulario(){
                var mensaje = "";
                if (document.getElementById("cbomes").value == 0)
                {
                    mensaje += "   - Escoja el mes.\n";
                }
                                
                if (mensaje != "")
                {
                    alert("Atencion:\n" + mensaje);
                }
                else
                {
                    document.getElementById("formulario").submit();
                    document.getElementById("cbomes").value = 0;
                                       
                }
                
            }
        </script>
    </head>
    <body>
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header">ATS Anexo Transaccional Simplificado</div>
                    <div id="frmBusqueda">
                        <form id="formulario" name="formulario" method="post" action="ats.php" >
                            <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>					
                                <tr>
                                    <td width="35%" align="right">MES:</td>
                                    <td >
                                        <select name="cbomes" id="cbomes" class="comboMedio">
                                            <option value="0">Escoja el mes</option>
                                            <option value="1">Enero</option>
                                            <option value="2">Febrero</option>
                                            <option value="3">Marzo</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Mayo</option>
                                            <option value="6">Junio</option>
                                            <option value="7">Julio</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>                                                    
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">A�O:</td>
                                    <td>
                                        <select name="cboano" id="cboano" class="comboMedio">
                                            <?php
                                            for ($i = 2014; $i < 2051; $i++) {
                                                ?>                                                        
                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>                                                                                            						 						  						
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="button" value="Generar" onclick="validarFormulario()"/></td>
                                </tr>
                            </table>
                    </div>								 							
                    </form>

                </div>			
            </div>
        </div>
    </body>
</html>
