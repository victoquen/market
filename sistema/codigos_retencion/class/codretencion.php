<?php

class Codretencion
{
    private $id_codretencion;
    private $codigo;
	private $nombre;
	private $porcentaje;
	private $tipo;
    private $borrado;

    public function __construct()
    {
        $this->id_codretencion=null;
		$this->codigo = null;
        $this->nombre=null;
		$this->porcentaje = null;
		$this->tipo = null;
        $this->borrado=null;
    }

    public function save($conn,$codigo, $nombre, $porcentaje, $tipo)
    {
        $this->nombre=strtoupper($nombre);
        $query="INSERT INTO codretencion VALUES (null,'$codigo','$this->nombre', $porcentaje, '$tipo','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete($conn, $idcodretencion)
    {
        $query = "UPDATE codretencion SET borrado = 1 WHERE id_codretencion='$idcodretencion'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update($conn, $idcodretencion, $codigo, $nombre, $porcentaje, $tipo)
    {

        $this->nombre=strtoupper($nombre);
        $query = "UPDATE codretencion SET codigo = '$codigo',  nombre = '$this->nombre', porcentaje = $porcentaje, tipo = '$tipo'
                  WHERE id_codretencion = '$idcodretencion'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_codretencion_id($conn, $id)
    {
        $rows;
        $query="SELECT  codigo, nombre, porcentaje, tipo FROM codretencion WHERE id_codretencion ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
     public function get_codretencion_borrado_id($conn, $id)
    {
        $rows;
        $query="SELECT  codigo, nombre, porcentaje, tipo FROM codretencion WHERE id_codretencion ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

}
?>