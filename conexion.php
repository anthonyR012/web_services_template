<?php
class Conectar{
//CONEXION BASE DE DATOS, DEVUELVE PDO CONEXION

	private $name = "buyme";
	private $host = "localhost";
	private $user = "rubioAdminStore";
	private $passUser = "sI9Y5xTfSWm065WO";

	public function getConnection(){
		try{
			$this->connection = new PDO("mysql:host=$this->host;
			dbname=$this->name","$this->user","$this->passUser");
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $this->connection;
		}catch(Exception $e){
			die("ERROR AL CONECTAR CON LA BASE DE DATOS" . $e->getmessage());

		}

	}



}

	?> 