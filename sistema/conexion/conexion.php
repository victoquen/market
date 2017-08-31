<?php
    class ServidorBaseDatos
    {
        private $server;
        private $user;
        private $password;
        private $base_datos;
        private $descriptor;

        public function __construct()
        {
            
            /*$this->server = "localhost";
            $this->user = "ombugame_root";
            $this->password = "1234qweasd";
            $this->base_datos = "ombugame_ideweb";*/


            /*$this->server = "localhost";
            $this->user = "root";
            $this->password = "23142314";
            $this->base_datos = "market";*/

            $this->server = "192.168.1.147";
            $this->user = "root";
            $this->password = "123456";
            $this->base_datos = "market";

            $this->conectar_base_datos();
        }

        public function conectar_base_datos()
        {
            
            $this->descriptor = mysql_connect($this->server, $this->user, $this->password) or die ("<div style='color:red;'><h3>Could not connect to MySQL server</h3></div>");
            mysql_query("SET NAMES 'utf8'");

            mysql_select_db($this->base_datos) or die ("<div style='color:red;'><h3>Could not select the indicated database</h3></div>");
        }

        public function getConexion()
        {
            return $this->descriptor;
        }

        public function getServer()
        {
            return $this->server;
        }
        public function getUser()
        {
            return $this->user;
        }
        public function getPassword()
        {
            return $this->password;
        }
        public function getBaseDatos()
        {
            return $this->base_datos;
        }
    }

?>