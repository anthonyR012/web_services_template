<?php
include_once('Conexion.php');

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
    





}


if (!empty($json)) {
	echo json_encode($json);
} else {
	echo json_encode(array("response" => "Error","Code 001"=>"No found param"));
}

?>