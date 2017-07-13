<?php
  $id = $_REQUEST['id'] ;
  $value = $_REQUEST['value'] ;
  $column = $_REQUEST['columnName'] ;
  $columnPosition = $_REQUEST['columnPosition'] ;
  $columnId = $_REQUEST['columnId'] ;
  $rowId = $_REQUEST['rowId'] ;
  
  
  
  include '../conexion/conexion.php';
  $usuario = new ServidorBaseDatos();
  $conn = $usuario->getConexion();
  
  
  $query="UPDATE proveedor SET empresa ='$value' WHERE id_proveedor=$id";
  $result= mysql_query($query, $conn);
  if($result)
  {
      echo "success";
  }
  else
  {
      echo "fail";
  }
  
  
?>