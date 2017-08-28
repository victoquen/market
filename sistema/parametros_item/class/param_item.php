<?php

/**
 * Created by PhpStorm.
 * User: VICTOR OQUENDO
 * Date: 7/14/2017
 * Time: 3:18 PM
 */
class Param_item
{
    private $id;
    private $serie_unica;
    private $item;
    private $borrado;


    public function __construct()
    {
        $this->id = null;
        $this->serie_unica = null;
        $this->item = null;
        $this->borrado = null;


    }

    public function save($conn, $serie_unica, $item)
    {


        $query="INSERT INTO param_item VALUES (null, '$serie_unica','$item','0')";
        $result= mysql_query($query, $conn);
        return $result;
    }


    public function update($conn, $id, $serie_unica, $item)
    {


        $query = "UPDATE param_item SET  serie_unica = '$serie_unica', item = '$item'
                  WHERE id = '$id'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function delete($conn, $id)
    {
        $query = "UPDATE param_item SET borrado = 1 WHERE id='$id'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function get_id($conn, $id)
    {

        $query="SELECT  serie_unica, item FROM param_item    WHERE id ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_borrado_id($conn, $id)
    {
        $query="SELECT  serie_unica, item FROM param_item WHERE id ='$id' AND borrado = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
}

?>