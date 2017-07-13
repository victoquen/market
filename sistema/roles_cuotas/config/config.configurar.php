<?php
    // Nombre del Sistema (Directorio)
    define( "NAME", $_SESSION["nombresistema"] );

    //Título del Sistema Web
    define( "TITULO", "ELECTROPARC CIA. LTDA." );

    // Pie de Pagina
    define( "PIEPAGINA", "<br/> ELECTROPARC CIA. LTDA.<br/>MATRIZ: JUAN DE LA VALLE 30-56 Y OLMEDO ESQUINA - TELEFONO: 0999270627<br/>RIOBAMBA - ECUADOR &reg; Copyright &copy; 2015 - ". date("Y") );
    
    //Título del Sistema Web
    define( "TITULO_EMPRESA_REPORTE", "ELECTROPARC CIA. LTDA." );
    define( "TITULO_EMPRESA_EMAIL_REPORTE", "electroparc10@gmail.com" );
    define( "TITULO_EMPRESA_SIGNIFICADO_REPORTE", "ELECTRODOMESTICOS PARCO" );
    
    // Pie de Pagina
    //define( "PIEPAGINA_REPORTE", "Dirección: Matriz Lavalle 30-56 y Olmedo Esquina || Teléfonos: (03)2993317 - 0999270627 || Puyo - Ecuador");
    define( "PIEPAGINA_DIRECCION_REPORTE", "Dirección: Matriz Lavalle 30-56 y Olmedo Esquina");
    define( "PIEPAGINA_TELEFONOS_REPORTE", "Teléfonos: 0994161053");
    define( "PIEPAGINA_CIUDAD_REPORTE", "Electroparc Cia. Ltda. © Riobamba - Ecuador");
    
    //Siglas Sistema Producto
    define( "SIGLA_PRODUCTO", "RP-" );

	define( "HOST_NAME", $_SERVER['HTTP_HOST'] );
	define( "DOC_ROOT", $_SERVER['DOCUMENT_ROOT'] ."/". NAME ."/" );
	define( "HOST", "http://" . HOST_NAME ."/" );

        //Directorio de Imagenes
        define( "IMAGENES_PATH", HOST. NAME. "/imagenes/" );
        define( "IMAGENES_URL", DOC_ROOT . "imagenes/" );

	//Codificacion
	define("CHARSET", "UTF-8" );
        //define("CHARSET", "ISO-8859-1" );

	//Directorio Clases
	define( "CLASS_PATH", DOC_ROOT ."class/" );
	define( "CLASS_URL", HOST. NAME. "/class/" );

        //habilitar y Desactivar campos (Lectura)
	define("LECTURA",'readonly="readonly"');
        define("DESABILITAR",'disabled="disabled"');

	//Index
	define( "INICIO_URL", HOST. NAME.'/index.php' );        
        define( "MODAL_URL", HOST. NAME.'/modal/modal.php' );
        define( "AUTOCOMPLETAR_URL", HOST. NAME."/autocompletar/autocompletar.php" );

        //Fuentes
	define( "FONT_PATH", DOC_ROOT . "font/" );
	define( "FONT_URL", HOST. NAME. "/font/" );
        
	//Directorio Login
//	define( "LOGIN_PATH", DOC_ROOT ."login/" );
//	define( "LOGIN_URL", HOST. NAME."/login/" );
        
        //Directorio Administracion Usuarios
	define( "ADMINISTRACION_PATH", DOC_ROOT ."administracion/" );
	define( "ADMINISTRACION_URL", HOST. NAME."/administracion/" );

        //Directorio Cambiar Contraseña Usuario
	define( "CONTRASENA_PATH", DOC_ROOT ."contrasena/" );
	define( "CONTRASENA_URL", HOST. NAME. "/contrasena/" );

        //Directorio Sucursal
	define( "SUCURSAL_PATH", DOC_ROOT ."sucursal/" );
	define( "SUCURSAL_URL", HOST. NAME."/sucursal/" );

        //Directorio Empresa
	define( "EMPRESA_PATH", DOC_ROOT ."empresa/" );
	define( "EMPRESA_URL", HOST. NAME."/empresa/" );

        //Directorio Proveedor
	define( "PROVEEDOR_PATH", DOC_ROOT ."proveedor/" );
	define( "PROVEEDOR_URL", HOST. NAME."/proveedor/" );

        //Directorio Cliente
	define( "CLIENTE_PATH", DOC_ROOT ."cliente/" );
	define( "CLIENTE_URL", HOST. NAME."/cliente/" );

        //Directorio Producto
	define( "PRODUCTO_PATH", DOC_ROOT ."producto/" );
	define( "PRODUCTO_URL", HOST. NAME."/producto/" );

        //Directorio Configuracion de Facturas y NotaVenta
	define( "CONFIGURACION_PATH", DOC_ROOT ."configuracion/" );
	define( "CONFIGURACION_URL", HOST. NAME."/configuracion/" );
        
        //Directorio Producto
	define( "STOCK_PATH", DOC_ROOT ."stock/" );
	define( "STOCK_URL", HOST. NAME."/stock/" );

        //Directorio Distribucion Producto
	define( "DISTRIBUCION_PATH", DOC_ROOT ."distribucion/" );
	define( "DISTRIBUCION_URL", HOST. NAME."/distribucion/" );

        //Directorio Mercaderia
	define( "MERCADERIA_PATH", DOC_ROOT ."mercaderia/" );
	define( "MERCADERIA_URL", HOST. NAME."/mercaderia/" );

        //Directorio Proforma
	define( "PROFORMA_PATH", DOC_ROOT ."proforma/" );
	define( "PROFORMA_URL", HOST. NAME."/proforma/" );

        //Directorio Detalle Proforma
	define( "PROFORMADETALLE_PATH", DOC_ROOT ."proformadetalle/" );
	define( "PROFORMADETALLE_URL", HOST. NAME."/proformadetalle/" );


        //Directorio Mercaderia
	define( "MERCADERIADETALLE_PATH", DOC_ROOT ."mercaderiadetalle/" );
	define( "MERCADERIADETALLE_URL", HOST. NAME."/mercaderiadetalle/" );

        
        //Directorio Administracion Usuarios
	define( "COMPROBANTE_PATH", DOC_ROOT ."comprobante/" );
	define( "COMPROBANTE_URL", HOST. NAME."/comprobante/" );

        //Directorio Caja Efectivo
	define( "CAJA_PATH", DOC_ROOT ."caja/" );
	define( "CAJA_URL", HOST. NAME."/caja/" );

        //Directorio tipoUsuario
	define( "TIPOUSURIO_PATH", DOC_ROOT ."tipousuario/" );
	define( "TIPOUSUARIO_URL", HOST. NAME."/tipousuario/" );


        //Total Etiqueta factura - Nota Venta
	define("FACTURATOTAL",'13');
    define("NOTAVENTATOTAL",'13');

     //Directorio CUOTA
	define( "CUOTA_PATH", DOC_ROOT ."cuota/" );
	define( "CUOTA_URL", HOST. NAME."/cuota/" );
    
    //Directorio CUOTA
	define( "ABONO_PATH", DOC_ROOT ."abono/" );
	define( "ABONO_URL", HOST. NAME."/abono/" );
    
    //Directorio Serie
	define( "SERIE_PATH", DOC_ROOT ."serie/" );
	define( "SERIE_URL", HOST. NAME."/serie/" );
    
    //Redireccionar a la Descargar de Archivos
	define( "ARCHIVOS_PATH", DOC_ROOT . "archivos/" );
	define( "ARCHIVOS_URL", HOST .NAME. "/archivos/" );
    
    //Archivos Linux (/) - Windows (\\)
    define("LINUXWINDOWS","/");
        
    //Total Provincias
	define("NUMEROPROVINCIAS",'24');
