<?php

/*
* Add edit delete rows dynamically using jquery and php
* http://www.amitpatil.me/
*
* @version
* 2.0 (4/19/2014)
*
* @copyright
* Copyright (C) 2014-2015
*
* @Auther
* Amit Patil
* Maharashtra (India)
*
* @license
* This file is part of Add edit delete rows dynamically using jquery and php.
*
* Add edit delete rows dynamically using jquery and php is freeware script. you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Add edit delete rows dynamically using jquery and php is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this script.  If not, see <http://www.gnu.org/copyleft/lesser.html>.
*/

//require_once('config.php');


require_once("../conexion/conexion.php");


class ajax_table
{

    public function __construct()
    {
        $this->dbconnect();
    }

    private function dbconnect()
    {
        $db = new ServidorBaseDatos();
        $conn = $db->getConexion();
        /*$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
          or die ("<div style='color:red;'><h3>Could not connect to MySQL server</h3></div>");

        mysql_select_db(DB_DB,$conn)
          or die ("<div style='color:red;'><h3>Could not select the indicated database</h3></div>");*/

        return $conn;
    }

    function getRecords($id)
    {
        $this->res = mysql_query("select * from factulineatmp WHERE codfactura = '$id'  order by id desc");
        if (mysql_num_rows($this->res)) {
            while ($this->row = mysql_fetch_assoc($this->res)) {
                $record = array_map('stripslashes', $this->row);
                $this->records[] = $record;
            }
            return $this->records;
        }
        //else echo "No records found";
    }

    function getRecord($idp, $cod){
        $sel = "select codtmp, numlinea, cantidad FROM factulineatmp where id_articulo='$idp' AND codtmp = '$cod'";
        $res = mysql_query($sel);
        $row = mysql_fetch_assoc($res);

        return $row;
    }

    function saveRecord($data)
    {
        if (count($data)) {
            $values = implode("','", array_values($data));
            mysql_query("insert into factulineatmp (" . implode(",", array_keys($data)) . ") values ('" . $values . "')");

            if (mysql_insert_id()) {

                return mysql_insert_id();
            } else return 0;


        } else return 0;
    }

    function save($data)
    {
        if (count($data)) {
            $values = implode("','", array_values($data));
            mysql_query("insert into factulineatmp (" . implode(",", array_keys($data)) . ") values ('" . $values . "')");
            if (mysql_insert_id()) {
                return mysql_insert_id();
            } else return 0;
        } else return 0;
    }


    function delete_record($num, $cod)
    {
        if ($num) {

            mysql_query("delete from factulineatmp where codtmp = '$cod' AND numlinea = '$num' LIMIT 1");
            return mysql_affected_rows();
        }
    }

    function update_record($data)
    {
        if (count($data)) {
            $cod = $data['rcod'];
            $num = $data['rid'];
            unset($data['rid']);
            unset($data['rcod']);
            $values = implode("','", array_values($data));
            $str = "";
            foreach ($data as $key => $val) {
                $str .= $key . "='" . $val . "',";
            }
            $str = substr($str, 0, -1);
            $sql = "update factulineatmp set $str where codtmp = '$cod' AND numlinea = '$num' limit 1";

            $res = mysql_query($sql);

            if (mysql_affected_rows()) return $num;
            return 0;
        } else return 0;
    }

    function update_column($data)
    {
        if (count($data)) {
            $cod = $data['rcod'];
            $num = $data['rid'];
            unset($data['rid']);
            unset($data['rcod']);

            $sel_iva = "select porcentaje FROM iva where activo=1 AND borrado=0";
            $rs_iva = mysql_query($sel_iva);
            $ivaporcetaje = mysql_result($rs_iva, 0, "porcentaje");

            $query = "SELECT cantidad, precio, importe,  dcto, iva FROM factulineatmp WHERE codtmp ='$cod' AND numlinea = '$num'";
            $result = mysql_query($query);
            $row = mysql_fetch_assoc($result);

            $row[key($data)] = $data[key($data)];

            $ctd = $row["cantidad"];
            $prc = $row["precio"];
            $dcto = $row["dcto"];
            $row["importe"] = round((($ctd * $prc) - $dcto), 2);
            $impt = $row["importe"];
            if ($row["iva"] > 0)
                $row["iva"] = round(($impt * $ivaporcetaje / 100), 2);

            $str = "";
            foreach ($row as $key => $val) {
                $str .= $key . "='" . $val . "',";
            }
            $str = substr($str, 0, -1);

            //$sql = "update factulineatmp set ".key($data)."='".$data[key($data)]."' where codtmp = '$cod' AND numlinea = '$num' limit 1";
            $sql = "update factulineatmp set $str where codtmp = '$cod' AND numlinea = '$num' limit 1";
            $res = mysql_query($sql);
            if (mysql_affected_rows())
                return $row;
            else
                return 0;

        }
    }

    function error($act)
    {
        return json_encode(array("success" => "0", "action" => $act));
    }


    function actualizar_totales($codfact)
    {
        $resultado = array();

        $subtotal = 0;
        $iva0 = 0;
        $ivagrava = 0;
        $ivaimporte = 0;
        $descuento = 0;
        $total = 0;

        $this->res = mysql_query("select * from factulineatmp WHERE codtmp = '$codfact'  order by numlinea desc");
        if (mysql_num_rows($this->res)) {
            while ($this->row = mysql_fetch_assoc($this->res)) {
                $record = array_map('stripslashes', $this->row);

                $subtotal += ($record["cantidad"]* $record["precio"]);
                $descuento += $record["dcto"];
                if ($record["iva"] > 0) {
                    $ivagrava += $record["importe"];
                    $ivaimporte += $record["iva"];
                } else {
                    $iva0 += $record["importe"];
                }
            }
            //$total = $subtotal + $ivaimporte  - $descuento;
            $total = $subtotal + $ivaimporte;
        }

        $subtotal = round($subtotal, 2);
        $iva0 = round($iva0, 2);
        $ivagrava = round($ivagrava, 2);
        $ivaimporte = round($ivaimporte, 2);
        $descuento = round($descuento, 2);
        $total = round($total, 2);

        $resultado = array("baseimponible" => $subtotal, "iva0" => $iva0, "iva12" => $ivagrava, "importeiva" => $ivaimporte, "descuentototal" => $descuento, "preciototal" => $total, "preciototal_c" => $total);
        return $resultado;
    }

    function update_descuentos_formapago($cod, $tipo_precio, $tipo_pago)
    {

        switch ($tipo_precio) {
            case 1 :
                $aux = "pvp";
                break;
            case 2:
                $aux = "pvp2";
                break;
            case 3:
                $aux = "pvp3";
                break;
            case 4:
                $aux = "pvp4";
                break;
        }

        switch ($tipo_pago) {
            case 1 :
                $prorrateo_porcentaje = 0;
                break;
            case 5:
                $sel_tar = "select porcentaje FROM porcentaje_tarjetacredito where  borrado=0 limit 1";
                $rs_tar = mysql_query($sel_tar);
                $prorrateo_porcentaje = mysql_result($rs_tar, 0, "porcentaje");
                break;
            default:
                $prorrateo_porcentaje = 0;
                break;

        }


        $sel_iva = "select porcentaje FROM iva where activo=1 AND borrado=0";
        $rs_iva = mysql_query($sel_iva);
        $ivaporcetaje = mysql_result($rs_iva, 0, "porcentaje");


        $rest = mysql_query("select * from factulineatmp WHERE codtmp ='$cod' ");
        if (mysql_num_rows($rest)) {
            while ($row = mysql_fetch_assoc($rest)) {
                $record = array_map('stripslashes', $row);
                $idaux = $record["id_articulo"];
                $num = $record["numlinea"];

                $resprcio = mysql_query("SELECT $aux FROM producto WHERE id_producto = '$idaux'");
                $rowprecio = mysql_fetch_assoc($resprcio);
                $record["precio"] = round(($rowprecio[$aux] * (1 + $prorrateo_porcentaje/100)),2);


                $ctd = $record["cantidad"];
                $prc = $record["precio"];
                $dcto = $record["dcto"];
                $record["importe"] = round((($ctd * $prc) - $dcto), 2);
                $impt = $record["importe"];
                if ($record["iva"] > 0)
                    $record["iva"] = round(($impt * $ivaporcetaje / 100), 2);

                $str = "";
                foreach ($record as $key => $val) {
                    $str .= $key . "='" . $val . "',";
                }
                $str = substr($str, 0, -1);


                $sql = "update factulineatmp set $str where codtmp = '$cod' AND numlinea = '$num' limit 1";
                $res = mysql_query($sql);


                $records[] = $record;
            }
            return $records;
        }
    }


    
    function  getTotalRecords($cod){
        $sel = "select COUNT(numlinea) as total FROM factulineatmp WHERE  codtmp = '$cod' ";
        $rs = mysql_query($sel);
        $res = mysql_result($rs, 0, "total");
        return $res;
    }
}

?>