<?php

class Grupo
{
    private $id_grupo;
    private $codigo;
    private $nombre;
    private $borrado;

    public function __construct()
    {
        $this->id_grupo=null;
        $this->codigo=null;
        $this->nombre=null;
        $this->borrado=null;
    }

    public function save_grupo($conn, $codigo, $nombre)
    {
        $this->codigo=strtoupper($codigo);
        $this->nombre=strtoupper($nombre);
        $query="INSERT INTO grupo VALUES (null,'$this->codigo','$this->nombre','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete_grupo($conn, $idgrupo)
    {
        $query = "UPDATE grupo SET borrado = 1 WHERE id_grupo='$idgrupo'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_grupo($conn, $idgrupo, $codigo, $nombre)
    {
        $this->codigo=strtoupper($codigo);
        $this->nombre=strtoupper($nombre);
        $query = "UPDATE grupo SET codigo = '$this->codigo', nombre = '$this->nombre'
                  WHERE id_grupo = '$idgrupo'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_grupo_id($conn, $id)
    {
        $rows;
        $query="SELECT codigo, nombre FROM grupo WHERE id_grupo ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
     public function get_grupo_borrado_id($conn, $id)
    {
        $rows;
        $query="SELECT codigo, nombre FROM grupo WHERE id_grupo ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

}
?>