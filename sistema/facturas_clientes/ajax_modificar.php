<?php 
	require_once("ajax_table.class_modificar.php");
	$obj = new ajax_table();

	if(isset($_POST) && count($_POST)){
		
		// whats the action ??

		$action = $_POST['action'];
		unset($_POST['action']);

		if($action == "save"){		
			// remove 'action' key from array, we no longer need it

			// Never ever believe on end user, he could be a evil minded
			$escapedPost = array_map('mysql_real_escape_string', $_POST);
			$escapedPost = array_map('htmlentities', $escapedPost);

			$id_producto = $escapedPost['id_producto'];
			$cod = $escapedPost['id_factura'];
			
			$check = $obj->getRecord($id_producto,$cod);
			//$check["dproducto"] = $check["id_producto"] ;
			if($check){

				$cantidad =$escapedPost['cantidad'] + $check['cantidad'];
				$rid = $check['id_factulinea'];

				$escapedPostUpd = array("cantidad"=>$cantidad,"rid"=>$rid,"rcod"=>$cod);

				//$row=array_merge(array("dproducto"=>$rid),$check);
				$row = $obj->update_column($escapedPostUpd);
				if($row) {
					$totalesPost = $obj->actualizar_totales($cod);
					$escapedPost = $row;
					$escapedPost["action"] = "update";
					$res1 =array_merge(array("success" => "1", "id"=>$rid), $escapedPost);
					echo json_encode(array_merge($res1, $totalesPost));
				}else
					echo $obj->error("update");

			}else{
				$res = $obj->save($escapedPost);
				if($res){
					$escapedPost["success"] = "1";
					$escapedPost["id"] = $res;
					$escapedPost["action"] = $action;
					$totalesPost = $obj->actualizar_totales($escapedPost["id_factura"]);

					//echo json_encode($escapedPost);
					echo json_encode(array_merge($escapedPost,$totalesPost));
				}
				else
					echo $obj->error("save");
			}
			
			
			

			

		}else if($action == "del"){
			$id = $_POST['rid'];
			$cod = $_POST['rcod'];
			$res = $obj->delete_record($id,$cod);
			if($res){
				$totalesPost = $obj->actualizar_totales($cod);
				echo json_encode(array_merge(array("success" => "1","id" => $id,"action"=>$action),$totalesPost));
			}
			else
				echo $obj->error("delete");
		}
		else if($action == "update"){
			
			$escapedPost = array_map('mysql_real_escape_string', $_POST);
			$escapedPost = array_map('htmlentities', $escapedPost);

			$id = $obj->update_record($escapedPost);
			if($id) {
				$escapedPost["action"] = $action;
				$totalesPost = $obj->actualizar_totales($escapedPost["id_factura"]);
				$res1 =array_merge(array("success" => "1", "id" => $id), $escapedPost);
				echo json_encode(array_merge($res1, $totalesPost));
			}
			else
				echo $obj->error("update");
		}
		else if($action == "updatetd"){
			
			$escapedPost = array_map('mysql_real_escape_string', $_POST);
			$escapedPost = array_map('htmlentities', $escapedPost);
			$cod = $escapedPost['rcod'];
			//$id = $obj->update_column($escapedPost);
			//if($id){
			$row = $obj->update_column($escapedPost);
			if($row) {
				$totalesPost = $obj->actualizar_totales($cod);
				$escapedPost = $row;
				$escapedPost["action"] = $action;
				$res1 =array_merge(array("success" => "1"), $escapedPost);
				echo json_encode(array_merge($res1, $totalesPost));
			}else
				echo $obj->error("updatetd");
		}
		else if($action == "descuentos"){
			$cod = $_POST['rcod'];
			$tipo_precio = $_POST['tipo_precio'];
			$rows = $obj->update_descuentos($cod,$tipo_precio);
			if($rows){
				$totalesPost = $obj->actualizar_totales($cod);
				$escapedPost = array("records"=>$rows);
				$escapedPost["action"] = $action;
				echo json_encode(array_merge($escapedPost,$totalesPost));
			
			}
			else
				echo $obj->error("descuentos");
		}
	}
?>