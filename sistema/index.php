<?php session_start();
?>
<html>
    <head>
        <title>IdeWeb Facturacio&oacute;n Web</title>
        <script language="JavaScript" src="menu/JSCookMenu.js"></script>
        <link rel="stylesheet" href="menu/theme.css" type="text/css">
        <script language="JavaScript" src="menu/theme.js"></script>
        <script language="JavaScript">
            <!--
      var MenuPrincipal = [
                [null, 'Inicio', 'central2.php', 'principal', 'Inicio'],
                [null, 'Clientes', './cliente/index.php', 'principal', 'Clientes'],
                [null, 'Proveedores', './proveedor/index.php', 'principal', 'Proveedores'],
                [null, 'Conversion', null, null, 'Conversion',
                    [null, 'Transformacion', './transformacion_inventario/index.php', 'principal', 'transformacion']
                    //[null, 'Agrupacion', './agrupacion_inventario/index.php', 'principal', 'agrupacion']
                ],
                [null, 'Productos', null, null, 'Productos',					
                    [null, 'Articulos', './producto/index.php', 'principal', 'Productos'],
                    [null, 'Grupos', './grupo/index.php', 'principal', 'Grupos'],
                    [null, 'SubGrupos', './subgrupo/index.php', 'principal', 'SubGrupos'],
					[null, 'Bodegas', './bodega/index.php', 'principal', 'Bodegas'],
					[null, 'Transferencias', './bodega_transferencia/index.php', 'principal', 'Transferencias']
                ],
                [null, 'Ventas', null, null, 'Ventas',                    
                    [null, 'Facturas Ventas', './facturas_clientes/index.php', 'principal', 'Ventas Clientes'],                    
                    [null, 'Facturas Ventas Anuladas', './facturas_clientes_anuladas/index.php', 'principal', 'Ventas Clientes'],
                    [null, 'Guias Remision', './remisiones/index.php', 'principal', 'Remisiones'],
                    [null, 'Historial Ventas', './reporte_historial_ventas/index.php', 'principal', 'historial'],
                    [null, 'Reporte Iva 0-12', './reporte_fact_ventas_iva0iva12/index.php', 'principal', 'iva']
                ],
                [null, 'Compras', null, null, 'Compras',
                    [null, 'Facturas Compras', './facturas_proveedores/index.php', 'principal', 'Compras Proveedores'],
                    [null, 'Facturas Compras Anuladas', './facturas_proveedores_anuladas/index.php', 'principal', 'Ventas Proveedores'],
                    [null, 'Productos Consignacion', './consignacion_proveedores/index.php', 'principal', 'Productos Consignacion'],
                    [null, 'Retenciones', './retenciones/index.php', 'principal', 'Retenciones'],
                    [null, 'Retenciones Anuladas', './retenciones_anuladas/index.php', 'principal', 'Retenciones'],
                    [null, 'Historial Compras', './reporte_historial_compras/index.php', 'principal', 'historial'],
                    [null, 'Reporte Iva 0-12', './reporte_fact_compras_iva0iva12/index.php', 'principal', 'iva']
                ],
            /*
		        [null, 'Proforma', null, null, 'Proforma',
                    [null, 'Proformas Ventas', './proformas_clientes/index.php', 'principal', 'Proformas Clientes']
                ],
            */
                [null, 'Gastos', null, null, 'Gastos',
                    [null, 'Cuentas Gastos', './cuentas/index.php', 'principal', 'cuentas'],
                        [null, 'Facturas Gastos', './facturas_gastos/index.php', 'principal', 'Compras Gastos'],
                    [null, 'Facturas Gastos Anuladas', './facturas_gastos_anuladas/index.php', 'principal', 'Ventas Proveedores'],
                    [null, 'Retenciones', './retenciones/index.php', 'principal', 'Retenciones']
                ],
                [null, 'Tesoreria', null, null, 'Tesoreria',
                    [null, 'Cobros', './cobros/index.php', 'principal', 'cobros'],
                    [null, 'Pagos', './pagos/index.php', 'principal', 'pagos'],
                    [null, 'Caja Diaria', './cerrarcaja/index.php', 'principal', 'caja'],
                    [null, 'Libro Diario', './librodiario/index.php', 'principal', 'libro']

                ],
                [null, 'Reportes', null, null, 'Tesoreria',
                    [null, 'Reportes x Cuenta', './reportes_cuentas/index.php', 'principal', 'cuentas'],
                    [null, 'Retenciones x Mes', './reporte_retenciones_mes/index.php', 'principal', 'retenciones'],
                    [null, 'Reporte Cuentas x Cobrar General', './reporte_cuentasCobrar/index.php', 'principal', 'Cuentas Cobrar'],
                    [null, 'Reporte Cuentas x Cobrar Individual', './reporte_cuentasCobrarIndividual/index.php', 'principal', 'Cuentas Cobrar'],
                    [null, 'Reporte Cuentas x Pagar General', './reporte_cuentasPagar/index.php', 'principal', 'Cuentas Pagar'],
                    [null, 'Reporte Cuentas x Pagar Individual', './reporte_cuentasPagarIndividual/index.php', 'principal', 'Cuentas Pagar'],
                    [null, 'Historial Ventas por tipo Cliente Detallado', './reporte_historial_cliente_ventas_detallado/index.php', 'principal', 'Historial ventas cliente'],
                    [null, 'Historial Ventas por tipo Cliente Totales', './reporte_historial_cliente_ventas_totales/index.php', 'principal', 'Historial ventas cliente'],
                    [null, 'Kardex x Producto', './reporte_kardex/index.php', 'principal', 'Kardex']
                ],
                [null, 'Rol Pagos', null, null, 'Rol Pagos',
                    [null, 'Empleado', './empleado/index.php', 'principal', 'empleado'],
                    [null, 'Contrato', './contrato/index.php', 'principal', 'contrato'],
                    [null, 'Contratacion Empleado', './empleadocontrato/index.php', 'principal', 'Contratacion Empleado'],
					[null, 'Rol de Pago', './roles_cuotas/table.html', 'principal', 'Contratacion Empleado'],
                ],
				[null, ' Creditos', null, null, ' Creditos',
                    [null, 'Pago Antiguo', './roles_cuotas/oldModule/cobros.html', 'principal', 'Pago Antiguo'],
                    [null, 'Pago', './roles_cuotas/tablaPagos.html', 'principal', 'Pago'],
                    [null, 'Contratos', './roles_cuotas/tableContrato.html', 'principal', 'Contratos'],
                ],

                [null, 'Mantenimientos', null, null, 'mantenimientos',
                    [null, 'RUC', './ruc/index.php', 'principal', 'RUC'],
                    [null, 'Usuarios', './usuario/index.php', 'principal', 'Usuarios'],
                    [null, 'IVA %', './porcentaje_iva/index.php', 'principal', 'IVA %'],
                    [null, 'ITEMS Factura', './parametros_item/index.php', 'principal', 'ITEMS Factura'],
					[null, 'Codigos Retencion', './codigos_retencion/index.php', 'principal', 'Retenciones'],
                    [null, 'Bancos', './bancos/index.php', 'principal', 'bancos'],
                    [null, 'Bancos Movimientos', './banco_movimiento/index.php', 'principal', 'banco movimientos'],
                    [null, 'Datos Retencionero', './retencionero/index.php', 'principal', 'retencionero'],
                    [null, 'Datos Guia de remision', './remisionero/index.php', 'principal', 'remisionero'],
                    [null, 'Datos Proformas', './proformero/index.php', 'principal', 'proformero'],
                    [null, 'Formas de Pago', './formas_pago/index.php', 'principal', 'forma de pagos'],
                    [null, 'Operadoras Moviles', './operadoras/index.php', 'principal', 'operadoras'],
                    [null, '% Tarjeta Credito', './porcentaje_tarjetacredito/index.php', 'principal', 'Tarjeta Crédito'],
                    [null, '', '', '', '']
                ],
                [null, 'Respaldos', null, null, 'Copias de Seguridad',
                    [null, 'Hacer copia', './backup/hacerbak.php', 'principal', 'Hacer copia'],
                    [null, 'Restaurar copia', './backup/restaurarbak.php', 'principal', 'Restaurar copia'],
                ],
                [null, 'Copyright', 'creditos.php', 'principal', 'Copyright']
            ];

            var MenuFacturacion = [
                [null, 'Inicio', 'central2.php', 'principal', 'Inicio'],
                [null, 'Clientes', './cliente/index.php', 'principal', 'Clientes'],
                [null, 'Proveedores', './proveedor/index.php', 'principal', 'Proveedores'],
                [null, 'Productos', null, null, 'Productos',
                    [null, 'Articulos', './producto/index.php', 'principal', 'Productos'],
                    [null, 'Transferencias', './bodega_transferencia/index.php', 'principal', 'Transferencias'],
                    [null, 'Grupos', './grupo/index.php', 'principal', 'Grupos'],
                    [null, 'SubGrupos', './subgrupo/index.php', 'principal', 'SubGrupos']
                ],
                [null, 'Ventas', null, null, 'Ventas Clientes',
                    [null, 'Facturas Ventas', './facturas_clientes/index.php', 'principal', 'Ventas Clientes'],
                    [null, 'Facturas Ventas Anuladas', './facturas_clientes_anuladas/index.php', 'principal', 'Ventas Clientes']
                ],
                [null, 'Copyright', 'creditos.php', 'principal', 'Copyright']
            ];

  --></script>
        <style type="text/css">
            body { background-color: rgb(255, 255,255);
                   background-image: url(images/superior.png);
                   background-repeat: no-repeat;
                   margin: 0px;
            }

            #MenuAplicacion { margin-left: 10px;
                              margin-top: 0px;
            }


        </style>


    </head>
    <body>
        <?php

        if ( isset($_SESSION['username']) && isset($_SESSION['userid']) && $_SESSION['username'] != '' && $_SESSION['userid'] != '0' )
        {

        $tipo=$_SESSION['tipo'];
        ?>
        <div align="center" style="background-image:url('img/banner1.jpg'); height: 70px;background-repeat:no-repeat; background-position:right">
            <table width="100%">
                <tr>
                    <td width="70%"align="center" ><img src="img/electroparc.png" height="70px" width="70px"></td>
                    <td width="20%" ><strong style="color: white">Bienvenido <?php echo $_SESSION['username'] ?> -- <?php echo $_SESSION['ultimoAcceso'];?>.<br/></strong><a style="color:papayawhip " href="../logout.php" id="sessionKiller">Cerrar sesi&oacute;n.</a></td>
                </tr>
            </table>

        </div>
        <div id="MenuAplicacion" align="center"></div>
        <?php
        if ($_SESSION['tipo']=="administrador")
        {
        ?>
        <script language="JavaScript">
         
                cmDraw('MenuAplicacion', MenuPrincipal, 'hbr', cmThemeGray, 'ThemeGray');

        </script>
        <?php
        }
        else
        {
        ?>
        <script language="JavaScript">

                cmDraw('MenuAplicacion', MenuFacturacion, 'hbr', cmThemeGray, 'ThemeGray');

        </script>
        <?php }?>
        <iframe src="central2.php" name="principal" title="principal" width="100%" height="2600px" frameborder=0 scrolling="no" style="margin-left: 0px; margin-right: 0px; margin-top: 2px; margin-bottom: 0px;"></iframe>
        <?php
        }
        ?>
    </body>
</html>
