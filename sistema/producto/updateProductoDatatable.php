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
  
  if($columnId==3)
  {
    $query="UPDATE producto SET stock ='$value' WHERE id_producto=$id";
  }
  
  if($columnId==5)
  {
    $query="UPDATE producto SET costo ='$value' WHERE id_producto=$id";
  }
  
  if($columnId==6)
  {
    $query="UPDATE producto SET pvp ='$value' WHERE id_producto=$id";
  }
  
  $result= mysql_query($query, $conn);
  if($result)
  {
      echo "Modificacion exitosa\nNuevo Valor: " +$value;
  }
  else
  {
      echo "Modificacion Fallida";
  }
?>