<?php

class Subgrupo
{
    private $id_subgrupo;
    private $id_grupo;
    private $codigo;
    private $nombre;
    private $borrado;

    public function __construct()
    {
        $this->id_subgrupo=null;
        $this->id_subgrupo=null;
        $this->codigo=null;
        $this->nombre=null;
        $this->borrado=null;
    }

    public function save_subgrupo($conn, $id_grupo, $codigo, $nombre)
    {
        $this->codigo=strtoupper($codigo);
        $this->nombre=strtoupper($nombre);
        $query="INSERT INTO subgrupo VALUES (null,'$id_grupo','$this->codigo','$this->nombre','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete_subgrupo($conn, $idsubgrupo)
    {
        $query = "UPDATE subgrupo SET borrado = 1 WHERE id_subgrupo='$idsubgrupo'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update_subgrupo($conn, $idsubgrupo, $id_grupo, $codigo, $nombre)
    {
        $this->codigo=strtoupper($codigo);
        $this->nombre=strtoupper($nombre);
        $query = "UPDATE subgrupo SET id_grupo='$id_grupo',codigo = '$this->codigo', nombre = '$this->nombre'
                  WHERE id_subgrupo = '$idsubgrupo'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_subgrupo_id($conn, $id)
    {
        $rows;
        $query="SELECT id_grupo, codigo, nombre FROM subgrupo WHERE id_subgrupo ='$id' AND borrado = 0";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
     public function get_subgrupo_borrado_id($conn, $id)
    {
        $rows;
        $query="SELECT id_grupo, codigo, nombre FROM subgrupo WHERE id_subgrupo ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_nombregrupo($id, $conn)
    {
        $query = "SELECT id_grupo, nombre FROM grupo WHERE id_grupo='$id' AND borrado = 0";
        $result= mysql_query($query, $conn);
        $row=mysql_fetch_assoc($result);
        return $row;
    }

    public function listado_grupos($conn)
    {

        $query = "SELECT id_grupo, nombre FROM grupo WHERE borrado = 0";
        $result= mysql_query($query, $conn);
        while ($row=mysql_fetch_assoc($result))
        {
            $rows[]=$row;
        }
        return $rows;
    }
}
?>