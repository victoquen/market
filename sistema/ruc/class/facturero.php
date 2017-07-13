<?php

class Facturero
{
    private $id_facturero;
    private $id_ruc;
    private $serie1;
    private $serie2;
    private $autorizacion;
    private $inicio;
    private $fin;
    private $fecha_caducidad;

    public function __construct()
    {
        $this->id_facturero=null;
        $this->id_ruc = null;
        $this->serie1=null;
        $this->serie2=null;
        $this->autorizacion=null;
        $this->inicio=null;
        $this->fin=null;
        $this->fecha_caducidad=null;
    }

    public function save_facturero($conn, $id_ruc, $serie1,$serie2,$autorizacion,$inicio,$fin,$fecha_caducidad)
    {

        $query="INSERT INTO facturero VALUES (null,'$id_ruc','$serie1','$serie2','$autorizacion','$inicio','$fin','$fecha_caducidad')";
        $result= mysql_query($query, $conn);
        return $result;
    }



    public function update_facturero($conn, $idfacturero, $serie1,$serie2,$autorizacion,$inicio,$fin,$fecha_caducidad)
    {

        $query = "UPDATE facturero SET  serie1 = '$serie1', serie2 = '$serie2',autorizacion = '$autorizacion',
                                        inicio = '$inicio', fin = '$fin', fecha_caducidad = '$fecha_caducidad'
                  WHERE id_facturero = '$idfacturero'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_facturero_id($conn, $id)
    {
        $query="SELECT  * FROM facturero WHERE id_facturero ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


}
?>