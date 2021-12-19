<?php
include_once('Conexion.php');
include_once('class/SecurityPassClass.php');

header('Access-Control-Allow-Origin: *');
$case = $_GET["case"];
$json = array();

$objConectar = new Conectar();
$conDb = $objConectar->getConnection();


switch ($case) {
	case "productos":
        


    break;
    case "usuarios":

		if(!empty($_POST["nombre"]) 
		&& !empty($_POST["apellido"]) 
		&& !empty($_POST["email"])  
		&& !empty($_POST["telefono"])  
		&& !empty($_POST["direccion"])  
		&& !empty($_POST["password"])  
		&& !empty($_POST["log"])  
		&& !empty($_POST["localidad"])){

			$hash = new SecurityPassClass($_POST["password"]);
			$getHash = $hash->hash();

			
			$sql = $conDb->prepare("INSERT INTO usuarios (Id_Usuario, Nombre_Usuario, Apellidos_Usuario, Email_Usuario, Telefono_Usuario, Direccion_Usuario, Password_Usuario, Log_Usuario, Id_localidad) VALUES (NULL, :nombre, :apellido, :correo, :tel, :direccion, :pass, :estado, :localidad)");

			//TODO HACER DISPARADOR PARA INSERTAR EL ROLL DEL USUARIO
			
			$sql->bindParam(':nombre', $_POST["nombre"]);
			$sql->bindParam(':apellido', $_POST["apellido"]);
			$sql->bindParam(':correo', $_POST["email"]);
			$sql->bindParam(':tel', $_POST["telefono"]);
			$sql->bindParam(':direccion', $_POST["direccion"]);
			$sql->bindParam(':pass', $getHash);
			$sql->bindParam(':estado', $_POST["log"]);
			$sql->bindParam(':localidad', $_POST["localidad"]);
			$result = $sql->execute();
			
			if($result){
				$item = array("response"=>"insert complete");
				$json['response'][]=$item;
				
			}
			
		}
		
	// TODO INSERT PARA DEFINIR QUE ROL TENDRA
    // $sql2 = $conDb->prepare("INSERT INTO roles ('Id_Usuario', 'Id_Permiso') VALUES ('12', '3')");
	
    break;


}


if (!empty($json)) {
	echo json_encode($json);
} else {
	echo json_encode(array("response" => "Error","Code 001"=>"No found param"));
}

?>