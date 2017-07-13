<?php

class Relacion_empleado_contrato
{
    private $id_contrato;
    private $id_empleado;
    private $fecha_inicio;
    private $fecha_fin;
    private $activo;
    private $codigo;
    private $sueldo;

    private $leyendaempleado;
    private $leyendacontrato;

    public function __construct()
    {
        $this->id_contrato = null;
        $this->id_empleado = null;
        $this->fecha_inicio = null;
        $this->fecha_fin = null;
        $this->activo = null;
        $this->codigo = null;
        $this->sueldo = null;
    }

    public function save($conn, $id_empleado, $id_contrato, $fecha_inicio, $fecha_fin, $codigo, $sueldo)
    {

        $query="INSERT INTO relacion_empleado_contrato VALUES (null, '$id_empleado','$id_contrato','$fecha_inicio', '$fecha_fin','1', '$codigo', '$sueldo')";
        $result= mysql_query($query, $conn);
        return $result;
    }

    public function delete($conn, $id)
    {
        $query = "UPDATE relacion_empleado_contrato SET borrado = 1 WHERE id='$id'";
        $result = mysql_query($query, $conn);
        return $result;
    }

    public function update($conn, $id, $id_empleado, $id_contrato, $fecha_inicio, $fecha_fin, $codigo, $sueldo)
    {

        
        $query = "UPDATE relacion_empleado_contrato SET  id_empleado = '$id_empleado', id_contrato = '$id_contrato', fecha_inicio = '$fecha_inicio', fecha_fin = '$fecha_fin', activo = '$activo', codigo = '$codigo', sueldo= '$sueldo'
                  WHERE id = '$id'";

        $result = mysql_query($query, $conn);

        return $result;

    }

    public function update_desactivados($conn, $id)
    {
        $query = "UPDATE relacion_empleado_contrato SET activo = 0 WHERE id_empleado='$id'";
        $result = mysql_query($query, $conn);
        return $result;
    }


    public function get_id($conn, $id)
    {

        $query="SELECT  * FROM relacion_empleado_contrato u   WHERE u.id ='$id' ";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_activo_id($conn, $id)
    {
        $query="SELECT  nombre FROM relacion_empleado_contrato WHERE id ='$id' AND activo = 1";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }


    public function get_leyenda_empleado($conn, $id){
        $query="SELECT CONCAT( nombre,  '-', cedula ) AS leyendaempleado  FROM empleado   WHERE id='$id' ";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    public function get_leyenda_contrato($conn, $id){
        $query="SELECT nombre AS leyendacontrato  FROM contrato   WHERE id='$id' ";
        $result = mysql_query($query, $conn);
        $row = mysql_fetch_assoc($result);
        return $row;

    }

}
?>