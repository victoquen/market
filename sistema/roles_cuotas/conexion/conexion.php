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
                
            $this->server = "localhost";
            $this->user = "root";
            $this->password = "23142314";
           // $this->password = "123456";
            $this->base_datos = "ideweb";
            $this->conectar_base_datos();
        }
        public function conectar_base_datos()
        {
            $this->descriptor = mysql_connect($this->server, $this->user, $this->password);
            mysql_query("SET NAMES 'utf8'");
            mysql_select_db($this->base_datos);
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