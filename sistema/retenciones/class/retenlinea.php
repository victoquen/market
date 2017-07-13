<?php

class Retenlinea
{
    private $id_retenlinea;
    private $id_retencion;
    private $ejercicio_fiscal;
    private $base_imponible;
    private $impuesto;
    private $codigo_impuesto;
    private $porcentaje_retencion;
    private $valor_retenido;


    public function __construct()
    {
        $this->id_retenlinea=null;
        $this->id_retencion=null;
        $this->ejercicio_fiscal=null;
        $this->base_imponible=null;
        $this->impuesto=null;
        $this->codigo_impuesto=null;
        $this->porcentaje_retencion=null;
        $this->valor_retenido=null;

    }

    public function save_retenlinea($conn,$id_retencion, $ejercicio_fiscal, $base_imponible, $impuesto, $codigo_impuesto, $porcentaje_retencion, $valor_retenido)
    {
        $query="INSERT INTO retenlinea VALUES (null,'$id_retencion','$ejercicio_fiscal','$base_imponible','$impuesto','$codigo_impuesto','$porcentaje_retencion','$valor_retenido')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete_retenlineas($conn, $idretencion)
    {
        $query = "DELETE FROM retenlinea  WHERE id_retencion='$idretencion'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    /*public function update_retenlinea($conn, $idretenlinea, $id_retencion, $id_producto, $cantidad, $precio, $dcto, $subtotal)
    {

        $query = "DELETE FROM retenlinea WHERE id_retencion=";

        $result = mysql_query($query, $conn);

        return $result;

    }*/

    public function get_retenlinea_id($conn, $id)
    {
        $rows;
        $query="SELECT id_retencion,ejercicio_fiscal,base_imponible,impuesto,codigo_impuesto,porcentaje_retencion,valor_retenido
                FROM retenlinea WHERE id_retenlinea ='$id' ";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


}
?>