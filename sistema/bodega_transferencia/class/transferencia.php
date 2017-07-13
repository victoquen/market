<?php

class Transferencia
{




    private $id_transferencia;
    private $fecha;
	private $borrado;



    public function __construct()
    {
        $this->id_transferencia=null;
        $this->fecha=null;
		$this->borrado=0;
        
    }

    public function save($conn, $fecha)
    {
        $query="INSERT INTO transferencia VALUES (null,'$fecha',0)";
        $result= mysql_query($query, $conn);
        $idtransferencia=mysql_insert_id();
        return $idtransferencia;
    }

    public function delete($conn, $idtransferencia)
    {
        $query = "UPDATE transferencia SET borrado = 1 WHERE id_transferencia='$idtransferencia'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function get_id($conn, $id)
    {
        $query="SELECT fecha
                FROM transferencia
                WHERE id_transferencia ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_borrado_id($conn, $id)
    {
        $query="SELECT fecha
                FROM transferencia
                WHERE id_transferencia ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
}
?>