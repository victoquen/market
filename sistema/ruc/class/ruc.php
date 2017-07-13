<?php

class Ruc
{
    private $id_ruc;
    private $idinformante;
    private $razonsocial;

    public function __construct()
    {
        $this->id_ruc = null;
        $this->idinformante=null;
        $this->razonsocial=null;        
    }

    public function save_ruc($conn, $idinformante, $razonsocial)
    {

        $query="INSERT INTO ruc VALUES (null,'$idinformante','$razonsocial')";
        $result= mysql_query($query, $conn);
        return $result;
    }



    public function update_ruc($conn, $idruc, $idinformante, $razonsocial)
    {

        $query = "UPDATE ruc SET  idinformante = '$idinformante', razonsocial = '$razonsocial'
                  WHERE id_ruc = '$idruc'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function get_ruc_id($conn, $id)
    {

        $query="SELECT  * FROM ruc WHERE id_ruc ='$id'";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


}
?>