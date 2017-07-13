<?php

class Porcentaje_iva
{
    private $id;
    private $porcentaje;
	private $activo; //0 no - 1 si
    private $borrado;


    public function __construct()
    {
        $this->id=null;
		$this->porcentaje = null;
		$this->activo = null;
        $this->borrado=null;
    }

    public function activo_iva_update($conn){
        $query = "UPDATE iva SET   activo = '0'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function save($conn,$porcentaje, $activo)
    {
        if($activo==1){
            if($activo==1){
                $querya = "UPDATE iva SET   activo = '0'";
                $resulta= mysql_query($querya, $conn);
            }
        }

        $query="INSERT INTO iva VALUES (null,'$porcentaje','$activo','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete($conn, $id)
    {
        $query = "UPDATE iva SET borrado = 1 WHERE id='$id'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update($conn, $id, $porcentaje, $activo)
    {

       if($activo==1){
            $querya = "UPDATE iva SET   activo = '0'";
            $resulta= mysql_query($querya, $conn);
        }
       
        $query = "UPDATE iva SET   porcentaje = '$porcentaje', activo = '$activo'
                  WHERE id = '$id'";
        $result = mysql_query($query, $conn);

        return $result;

    }



    public function get_iva_id($conn, $id)
    {

        $query="SELECT  porcentaje, activo FROM iva WHERE id ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
     public function get_iva_borrado_id($conn, $id)
    {

        $query="SELECT   porcentaje, activo FROM iva WHERE id ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

}
?>