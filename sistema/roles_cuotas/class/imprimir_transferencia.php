<?php
    //session_start();
    date_default_timezone_set ( 'America/Guayaquil' );


    require_once( '../config/config.configurar.php' );
    define('FPDF_FONTPATH','../font');

    include ("../js/fechas.php");
    include ("../conexion/conexion.php");
    include ( "class.clfpdf.php" );

    $usuario = new ServidorBaseDatos();
    $conn = $usuario->getConexion();
    $id_trasnferencia = $_GET["id_trasnferencia"];

           // define('FPDF_FONTPATH',FONT_PATH);
           // include_once ( CLASS_PATH . "class.clfpdf.php" );

            //Limpia el buffer si no sale un error
            ob_end_clean();

            $fechaimpresion = date("Y/m/d H:i:s a");


            //create a FPDF object
            $pdf = new FPDF('P' , 'mm' , 'A4');
            //Para poner la Pagina 1/(1...n)
            $pdf->AliasNbPages();

            //set document properties
            $pdf->SetAuthor('Personal');
            $pdf->SetTitle('Listado Mercaderia Distribuida');

            //encabezado
           /* $pdf->logoencabezado = 1;
            $pdf->logopiepagina = 1;
            $pdf->Header();
*/

            //Envia a otra pagina
            //$pdf->setAutoPagebreak(true,0);

            //set font for the entire document
            //$pdf->SetFont('Arial','B',35);
            //$pdf->SetTextColor(50,60,100);

            //set up a page
            $pdf->AddPage('P');
            $pdf->SetDisplayMode(75,'default');

            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(0,6,'LISTADO MECADERIA DISTRIBUIDA',1,1,'C',1);
            $pdf->Ln(2);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(30,5,utf8_decode("SUCURSAL ORIGEN"),1,0 ,'C',1);
            $pdf->Cell(30,5,utf8_decode("SUCURSAL DESTINO"),1,0 ,'C',1);
            $pdf->Cell(15,5,utf8_decode("CÓDIGO"),1,0 ,'C',1);
            $pdf->Cell(75,5,utf8_decode("PRODUCTO"),1,0 ,'C',1);
            $pdf->Cell(15,5,utf8_decode("CANTIDAD"),1,0 ,'C',1);
            $pdf->Cell(25,5,utf8_decode("FECHA"),1,1 ,'C',1);

            $pdf->SetFont('Arial','',6);

            $id_trasnferencia = $_REQUEST["id_transferencia"];

            $sql = "SELECT
                          t.id_transferencia as id_transferencia,
                          t.fecha AS fecha,
                          p.nombre as nombre,
                          p.codigo as codigo,
                          tl.cantidad as cantidad, 
                          bs.nombre as bodegaorigen,
                          bd.nombre as bodegadestino
                          
                    FROM
                          transferencia t INNER JOIN transferencialinea tl ON
                          t.id_transferencia = tl.id_transferencia
                          INNER JOIN producto p ON
                          p.id_producto = tl.id_producto
                          INNER JOIN bodega bs ON
                          tl.id_bodegaorigen = bs.id_bodega
                          INNER JOIN bodega bd ON
                          tl.id_bodegadestino = bd.id_bodega
                    WHERE t.id_transferencia = '$id_trasnferencia'
                    ORDER BY
                          p.nombre";


            /*$sql = "SELECT
                          tsucursalorigen.sucdescripcion AS sucdescripcionorigen,
                          tsucursaldestino.sucdescripcion AS sucdescripciondestino,
                          LPAD(tproducto.procodigo, 8, '0') AS procodigo,
                          tproducto.prodescripcion,
                          tdistribuir.discantidad,
                          tdistribuir.disfecha
                    FROM
                          tdistribuir INNER JOIN tstock ON
                          tdistribuir.stoid = tstock.stoid
                          INNER JOIN tproducto ON
                          tstock.proid = tproducto.proid
                          INNER JOIN tsucursal AS tsucursalorigen ON
                          tstock.sucid = tsucursalorigen.sucid
                          INNER JOIN tsucursal AS tsucursaldestino ON
                          tdistribuir.sucid = tsucursaldestino.sucid
                    ".  $where ."
                    ORDER BY
                          sucdescripciondestino, tdistribuir.disfecha";*/

            //$total = 0;            
            //$resultado = $query->getStrQuery($sql);

            $rs_lineas = mysql_query($sql, $conn);

            //$totalfilas = mysql_num_rows($rs_lineas);
            while ($rst = mysql_fetch_array($rs_lineas)) {

                $pdf->Cell(30,5,utf8_decode($rst["bodegaorigen"]),1,0 ,'L',0);
                $pdf->Cell(30,5,utf8_decode($rst["bodegadestino"]),1,0 ,'L',0);
                $pdf->Cell(15,5,utf8_decode($rst["codigo"]),1,0 ,'C',0);
                $pdf->Cell(75,5,utf8_decode($rst["nombre"]),1,0 ,'L',0);
                $pdf->Cell(15,5,utf8_decode($rst["cantidad"]),1,0 ,'C',0);
                $pdf->Cell(25,5,utf8_decode($rst["fecha"]),1,1 ,'C',0);

                //$total += (int)$rst["total"];

                if ($pdf->GetY() >= 265)
                 {
                    //$pdf->Ln(35);
                    //Envia a otra pagina
                    $pdf->setAutoPagebreak(true);
                    $pdf->Ln(40);
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(0,6,'LISTADO MECADERIA DISTRIBUIDA',1,1,'C',1);
                    $pdf->Ln(2);
                    $pdf->SetFont('Arial','B',7);
                    $pdf->Cell(30,5,utf8_decode("SUCURSAL ORIGEN"),1,0 ,'C',1);
                    $pdf->Cell(30,5,utf8_decode("SUCURSAL DESTINO"),1,0 ,'C',1);
                    $pdf->Cell(15,5,utf8_decode("CÓDIGO"),1,0 ,'C',1);
                    $pdf->Cell(75,5,utf8_decode("PRODUCTO"),1,0 ,'C',1);
                    $pdf->Cell(15,5,utf8_decode("CANTIDAD"),1,0 ,'C',1);
                    $pdf->Cell(25,5,utf8_decode("FECHA"),1,1 ,'C',1);

                    $pdf->SetFont('Arial','',6);
                 }
            }
            mysql_free_result($rs_lineas);

            $pdf->Ln(1);
            $pdf->SetFont('Arial','B',6);
            $pdf->Cell(20,4,utf8_decode('Fecha Impresión:'),0,0,'L',0);
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(20,4,"  ".utf8_decode($fechaimpresion),0,1,'L',0);

            //Pie Pagina
            //$pdf->Footer();

            //Output the document
            $fecha = date("YmdHis").'.pdf';
            $pdf->Output($fecha,'D');

 ?>


