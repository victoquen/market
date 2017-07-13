<?php

class Bodega
{
    private $id_bodega;
	private $nombre;
	private $direccion;
	

    public function __construct()
    {
        $this->id_bodega=null;
        $this->nombre=null;
		$this->direccion = null;

    }

    public function save($conn, $nombre, $direccion)
    {
        $this->nombre=strtoupper($nombre);
		 $this->direccion=strtoupper($direccion);
        $query="INSERT INTO bodega VALUES (null,'$this->nombre', '$this->direccion','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete($conn, $idbodega)
    {
        $query = "UPDATE bodega SET borrado = 1 WHERE id_bodega='$idbodega'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update($conn, $idbodega, $nombre, $direccion)
    {

        $this->nombre=strtoupper($nombre);
		$this->direccion=strtoupper($direccion);
        $query = "UPDATE bodega SET  nombre = '$this->nombre', direccion = '$this->direccion'
                  WHERE id_bodega = $idbodega";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_bodega_id($conn, $id)
    {
        $rows;
        $query="SELECT  nombre, direccion FROM bodega WHERE id_bodega ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
     public function get_bodega_borrado_id($conn, $id)
    {
        $rows;
        $query="SELECT  nombre, direccion FROM bodega WHERE id_bodega ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

}
?>