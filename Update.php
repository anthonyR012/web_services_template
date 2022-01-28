<?php
include_once('Conexion.php');
include_once('class/SecurityPassClass.php');

header('Access-Control-Allow-Origin: *');
$case = $_GET["case"];
$json = array();

$objConectar = new Conectar();
$conDb = $objConectar->getConnection();
$entityBody = json_decode(file_get_contents('php://input'), true);


switch ($case) {
	case "productos":
        

    break;
    case "usuarios":

        $implement->ValidatorUser();
        $sql = $implement->verifiedParamEnvios(
			!empty($entityBody["insertName"]) ? $entityBody["insertName"] : null,
			!empty($entityBody["insertApellido"]) ? $entityBody["insertApellido"] : null,
			!empty($entityBody["searchCity"]) ? $entityBody["searchCity"] : null,
			!empty($entityBody["searchDepartment"]) ? $entityBody["searchDepartment"] : null,
			!empty($entityBody["searchDate"]) ? $entityBody["searchDate"] : null
		);
        if(!empty($entityBody["id"]) && !empty($entityBody["nombre"]) && !empty($entityBody["apellido"]) && !empty($entityBody["email"]) && !empty($entityBody["telefono"]) && !empty($entityBody["direccion"]) && !empty($entityBody["ciudad"]) && !empty($entityBody["departamento"]) && !empty($entityBody["password"])){


        }
    
    break;

	case "actividad":
		if(!empty($_GET["id"])){
			$sql = $conDb->prepare("UPDATE `usuarios` SET `Log_Usuario` = 'inactivo' WHERE `usuarios`.`Id_Usuario` = :id");
       
        
			$sql->bindParam(':id', $_GET["id"]);
			$result = $sql->execute();
		   
			if($result){
				$item = array("response"=>"update complete");
				$json['response'][]=$item;
				
			}
		}
		
		break;
	case "entregado":
		if(!empty($_GET["id"])){
			$sql = $conDb->prepare("UPDATE `pedidos` SET `Estado_Pedido` = 'Finalizado' WHERE `pedidos`.`Id_Pedido` = :id");
	   
			$sql->bindParam(':id', $_GET["id"]);
				$result = $sql->execute();
			   
			if($result){
				$item = array("response"=>"update complete");
				$json['response'][]=$item;
				
			}
		}
			
	break;	
    
	case "perfil":
		
		if(isset($_GET["editcredential"])
		&& !empty($_GET["id"])
		&& !empty($_POST["email"])
		&& !empty($_POST["password"])
		&& !empty($_POST["lastpassword"])){

			
			$sql = $conDb->prepare("SELECT Password_Usuario FROM usuarios WHERE `usuarios`.`Id_Usuario` = :id");
			$sql->bindParam(':id', $_GET["id"]);
			$sql->execute();
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			
			$hash = new SecurityPassClass($_POST["lastpassword"]);
			if($hash->verify($row['Password_Usuario'])){
				
				$hash2 = new SecurityPassClass($_POST["password"]);
				$getHash = $hash2->hash();

				$sql = $conDb->prepare("UPDATE `usuarios` SET `Email_Usuario` = :email, `Password_Usuario` = :pass WHERE `usuarios`.`Id_Usuario` = :id");
		
				$sql->bindParam(':email', $_POST["email"]);
				$sql->bindParam(':pass', $getHash);
				$sql->bindParam(':id', $_GET["id"]);
				
				$result = $sql->execute();
			   
			if($result){
					$item = array("response"=>"update complete");
					$json['response'][]=$item;
					
			}

			}else{
			
			
				$item = array("response"=>"failed update");
					$json['response'][]=$item;
			}
			
		}else if(isset($_GET["editinformation"])
		&& !empty($_GET["id"])
		&& !empty($_GET["nombres"])
		&& !empty($_GET["apellidos"])
		&& !empty($_GET["direccion"])
		&& !empty($_GET["telefono"])){


				$sql = $conDb->prepare("UPDATE `usuarios` SET `Nombre_Usuario` = :nombres, `Apellidos_Usuario` = :apellidos, `Telefono_Usuario` = :telefono, `Direccion_Usuario` = :direccion WHERE `usuarios`.`Id_Usuario` = :id");
				$sql->bindParam(':nombres', $_GET["nombres"]);
				$sql->bindParam(':apellidos', $_GET["apellidos"]);
				$sql->bindParam(':telefono', $_GET["telefono"]);
				$sql->bindParam(':direccion', $_GET["direccion"]);
				$sql->bindParam(':id', $_GET["id"]);
				
				$result = $sql->execute();
			   
			if($result){
					$item = array("response"=>"update complete");
					$json['response'][]=$item;
					
			}
		 }
		 
			
		break;




}


if (!empty($json)) {
	echo json_encode($json);
} else {
	echo json_encode(array("response" => "Error","Code 001"=>"No found param"));
}

?>