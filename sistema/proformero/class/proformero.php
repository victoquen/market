<?php

class Proformero
{
    private $id_proformero;
    private $serie1;
    private $serie2;
    private $autorizacion;
    private $inicio;
    private $fin;
    private $fecha_caducidad;

    public function __construct()
    {
        $this->id_proformero=null;
        $this->serie1=null;
        $this->serie2=null;
        $this->autorizacion=null;
        $this->inicio=null;
        $this->fin=null;
        $this->fecha_caducidad=null;
    }

    public function save_proformero($conn, $serie1,$serie2,$autorizacion,$inicio,$fin,$fecha_caducidad)
    {

        $query="INSERT INTO proformero VALUES (null,'$serie1','$serie2','$autorizacion','$inicio','$fin','$fecha_caducidad')";
        $result= mysql_query($query, $conn);
        return $result;
    }



    public function update_proformero($conn, $idproformero, $serie1,$serie2,$autorizacion,$inicio,$fin,$fecha_caducidad)
    {

        $query = "UPDATE proformero SET  serie1 = '$serie1', serie2 = '$serie2',autorizacion = '$autorizacion',
                                        inicio = '$inicio', fin = '$fin', fecha_caducidad = '$fecha_caducidad'
                  WHERE id_proformero = '$idproformero'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_proformero_id($conn, $id)
    {
        $rows;
        $query="SELECT  * FROM proformero WHERE id_proformero ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


}
?>