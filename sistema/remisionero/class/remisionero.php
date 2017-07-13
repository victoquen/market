<?php

class remisionero
{
    private $id_remisionero;
    private $serie1;
    private $serie2;
    private $autorizacion;
    private $inicio;
    private $fin;
    private $fecha_caducidad;

    public function __construct()
    {
        $this->id_remisionero=null;
        $this->serie1=null;
        $this->serie2=null;
        $this->autorizacion=null;
        $this->inicio=null;
        $this->fin=null;
        $this->fecha_caducidad=null;
    }

    public function save_remisionero($conn, $serie1,$serie2,$autorizacion,$inicio,$fin,$fecha_caducidad)
    {

        $query="INSERT INTO remisionero VALUES (null,'$serie1','$serie2','$autorizacion','$inicio','$fin','$fecha_caducidad')";
        $result= mysql_query($query, $conn);
        return $result;
    }



    public function update_remisionero($conn, $idremisionero, $serie1,$serie2,$autorizacion,$inicio,$fin,$fecha_caducidad)
    {

        $query = "UPDATE remisionero SET  serie1 = '$serie1', serie2 = '$serie2',autorizacion = '$autorizacion',
                                        inicio = '$inicio', fin = '$fin', fecha_caducidad = '$fecha_caducidad'
                  WHERE id_remisionero = '$idremisionero'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_remisionero_id($conn, $id)
    {
        $rows;
        $query="SELECT  * FROM remisionero WHERE id_remisionero ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


}
?>