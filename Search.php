<?PHP
include_once('Conexion.php');
include_once('class/FilterSearchClass.php');
include_once('class/SecurityPassClass.php');
// CORS es un acrónimo que refiere a las reglas de seguridad que garantizan la comunicación entre dos puntos con una precedencia diferente al dominio desde el cual se llama (es decir: diferentes dominios).

// En general, dichas reglas son implementadas por el cliente web y es éste quien se encarga de validar la entrega de la información o rechazarla con base a lo que el servidor responda.
header('Access-Control-Allow-Origin: *');


//CAPTURA PARAMETRO DE GET 
$case = $_GET["case"];
$json = array();
//INSTANCIACION DE MI CONEXION A BBDD
$objConectar = new Conectar();
$conDb = $objConectar->getConnection();
$implement = new FilterSearchClass();
//RECIBIR JSON


switch ($case) {
	
	case "productos":
		//FILTRO POR TODOS LOS VALORES
		

		$sql = $implement->verifiedParamProduct(
			!empty($_GET["searchName"]) ? $_GET["searchName"] : null,
			!empty($_GET["searchPMenor"]) ? $_GET["searchPMenor"] : null,
			!empty($_GET["searchPMayor"]) ? $_GET["searchPMayor"] : null,
			!empty($_GET["searchCategory"]) ? $_GET["searchCategory"] : null,
			!empty($_GET["searchBrand"]) ? $_GET["searchBrand"] : null,
			!empty($_GET["searchOfert"]) ? $_GET["searchOfert"] : null
		);

		
		if(!empty($sql)){

		$result = $conDb->prepare($sql);
		$result->execute();

			if($result->rowCount()>0){

				while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

				$item = array(
				"id" => $row["Id_Producto"],
				"Nombre" => $row["Nombre_Producto"],
				"Marca" => $row["Marca_Producto"],
				"Referencia" => $row["Ref_Producto"],
				"Descripcion" => $row["Descripcion_Producto"],
				"Precio" => $row["Precio_Producto"],
				"Existencias" => $row["Existencia_Producto"],
				"Imagen" => $row["Imagen_Producto"],
				"Garantia" => $row["Garantia_Producto"],
				"Categoria" => $row["Nombre_Categoria"],
				);
				$json['response'][] = $item;
			}

			}else{
				$item = array("response" => "No found product");
				$json['response'] = $item;
			}
		}


		break;
		case "misProductos":	
			$id=$_GET['id'];

		$sql = 'SELECT pd.* FROM productos_proveedores pp 
	JOIN productos pd ON pp.Id_Producto = pd.Id_Producto
	JOIN usuarios u ON u.Id_Usuario = pp.Id_Proveedor
	WHERE u.Id_Usuario='.$id;

		$result = $conDb->prepare($sql);
		$result->execute();
		
			
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
		
					$item=array(
					"id" => $row["Id_Producto"],
					"Nombre"=> $row["Nombre_Producto"],
					"Marca" => $row["Marca_Producto"],
					"Referencia" => $row["Ref_Producto"],
					"Descripcion" => $row["Descripcion_Producto"],
					"Precio" => $row["Precio_Producto"],
					"Existencias" => $row["Existencia_Producto"],
					"Imagen" => $row["Imagen_Producto"],
					"Garantia" => $row["Garantia_Producto"],
				
					);
					$json['response'][]=$item;
			}

		

		 break;
		 
	
	case "usuarios":

		$sql = $implement->verifiedParamUsers(
			!empty($_GET["searchId"]) ? $_GET["searchId"] : null,
			!empty($_GET["searchName"]) ? $_GET["searchName"] : null,
			!empty($_GET["searchApellido"]) ? $_GET["searchApellido"] : null,
			!empty($_GET["searchCity"]) ? $_GET["searchCity"] : null,
			!empty($_GET["searchDepartment"]) ? $_GET["searchDepartment"] : null
		); 

		// VERIFICA QUE CONSULTA RETORNE ALGO
		if(!empty($sql)){

		
		$result = $conDb->prepare($sql);
		$result->execute();
		//SI Y SOLO SI RESPUESTA TIENE DATOS PARA MOSTRAR
		if($result->rowCount()>0){
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

			$item = array(
				"id" => $row["Id_Usuario"],
				"Nombre" => $row["Nombre_Usuario"],
				"Apellido" => $row["Apellidos_Usuario"],
				"Email" => $row["Email_Usuario"],
				"Telefono" => $row["Telefono_Usuario"],
				"Ciudad" => $row["Nombre_Municipio"],
				"Departamento" => $row["Nombre_Departamento"],
				"Direccion" => $row["Direccion_Usuario"],
				"Contrasena" => $row["Password_Usuario"]

			);
			//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
			$json['response'][] = $item;
			//IMPRIMIMOS OBJETO JSON

		}
		}else{
			$item = array("response" => "No found user");
			$json['usuarios'] = $item;
		}
	}
		break;
	case "login":
		
		$sql = $implement->verifiedParamLogin(
			!empty($_POST["searchEmail"]) ? $_POST["searchEmail"] : null,
			!empty($_POST["searchPass"]) ? $_POST["searchPass"] : null
		);

		if (!empty($sql)) {
			$result = $conDb->prepare($sql);
			$result->execute();


			if($result->rowCount()>0){

			$row = $result->fetch(PDO::FETCH_ASSOC);
			$security = new SecurityPassClass($_POST["searchPass"]);
			

			if ($security->verify($row["Password_Usuario"])) {
				$idUser = $row['Id_Usuario'];
				$item = array(
					"id" => $idUser,
					"Nombre" => $row["Nombre_Usuario"],
					"Apellido" => $row["Apellidos_Usuario"],
					"Email" => $row["Email_Usuario"],
					"Telefono" => $row["Telefono_Usuario"],
					"Ciudad" => $row["Nombre_Municipio"],
					"Departamento" => $row["Nombre_Departamento"],
					"Direccion" => $row["Direccion_Usuario"],
					"Contrasena" => $row["Password_Usuario"],
					"rol" => $row["Rol_Permiso"]

				);
				$sql2 = "UPDATE usuarios
				SET Log_Usuario = 'activo'
				WHERE Id_Usuario = '$idUser'";
				$result2 = $conDb->prepare($sql2);
				$result2->execute();
				
			}else{
				$item =  array("response" => "Login_failed");

			}
		}else{
			$item = array("response" => "No_found_user");
			
		}
			//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
				
			$json['response'] = $item;
		}
		break;
	case "proveedores":
		
		$sql1 = $implement->verifiedParamProveedors(
			!empty($_GET["searchName"]) ? $_GET["searchName"] : null,
			!empty($_GET["searchApellido"]) ? $_GET["searchApellido"] : null,
			!empty($_GET["searchCity"]) ? $_GET["searchCity"] : null,
			!empty($_GET["searchDepartment"]) ? $_GET["searchDepartment"] : null
		);

		//EJECUTA DOS CONSULTAS, UNA: PROVEEDORES, DOS: PRODUCTOS DE PROVEEDORES
		
		if (!empty($sql1)) {
			$result = $conDb->prepare($sql1);
			$result->execute();

			
			//VERIFIQUE QUE HAYA RESPUESTA
			if($result->rowCount() > 0){
			
				//SI CONSULTA ES IGUAL A CERO
			if ($result->rowCount() == 1) {
				
				$row = $result->fetch(PDO::FETCH_ASSOC);
				//GUARDAMOS EN ARRAY DATOS DE PRIMER PROVEEDOR
				$user = $row["Id_Usuario"];
				//EJECUTAMOS CONSULTA DE PRODUCTOS POR UNICO PROVEEDOR
				$sql2 = "SELECT u.Id_Usuario,p.Nombre_Producto,p.Marca_Producto,p.Descripcion_Producto,
				p.Imagen_Producto,p.Garantia_Producto,p.Existencia_Producto,p.Id_Producto
							,p.Precio_Producto FROM productos_proveedores pr
							JOIN usuarios u ON u.Id_Usuario = pr.Id_Proveedor
							JOIN productos p ON p.Id_Producto = pr.Id_Producto
							JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
							JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
							WHERE u.Id_Usuario = $user";
							
				$result2 = $conDb->prepare($sql2);
				$result2->execute();
				
				$item = array(

					"id" => $row["Id_Usuario"],
					"Nombre" => $row["Nombre_Usuario"] . " " . $row["Apellidos_Usuario"],
					"Email" => $row["Email_Usuario"],
					"Telefono" => $row["Telefono_Usuario"],
					"Direccion" => $row["Direccion_Usuario"],
					"Ciudad" => $row["Nombre_Municipio"],
					"Departamento" => $row["Nombre_Departamento"],

				);
			

				while ($rowProduct = $result2->fetch(PDO::FETCH_ASSOC)) {

				$itemDetail = array(
					"id_usuario_productos" => $rowProduct["Id_Usuario"],
					"id_producto" => $rowProduct["Id_Producto"],
					"nombre_producto" => $rowProduct["Nombre_Producto"],
					"marca_producto" => $rowProduct["Marca_Producto"],
					"descripcion_producto" => $rowProduct["Descripcion_Producto"],
					"imagen_producto" => $rowProduct["Imagen_Producto"],
					"garantia_producto" => $rowProduct["Garantia_Producto"],
					"existencia_producto" => $rowProduct["Existencia_Producto"],
				);
				$item["response"][] = $itemDetail;
				//GUARDAMOS EN JSON LOS DATOS COMPLETOS DE PROVEEDOR CON SUS PRODUCTOS
				}
				$json['response'][] = $item;
				//SI CONSULTA ES MAYOR A UN REGISTRO
			}else{

				//TRAEMOS CONSULTA CON LAS CLAUSURAS CORRESPONDIENTE
				$sql2 = $implement->verifiedParamProductProveedors();
							
				$result2 = $conDb->prepare($sql2);
				$result2->execute();
				$countArray = array();
				
			//GUARDAMOS EN ARRAY SEGUNDA CONSULTA (CONSULTA PRODUCTOS)
			while($row = $result2 ->fetch(PDO::FETCH_ASSOC)){
				
				$item = array(
					"id_usuario_productos" => $row["Id_Usuario"],
					"id_producto"=> $row["Id_Producto"],
					"nombre_producto"=> $row["Nombre_Producto"],
					"marca_producto"=> $row["Marca_Producto"],
					"descripcion_producto"=> $row["Descripcion_Producto"],
					"imagen_producto"=> $row["Imagen_Producto"],
					"garantia_producto"=> $row["Garantia_Producto"],
					"existencia_producto"=> $row["Existencia_Producto"],
					

				);
				$countArray[] = $item;

			}
			
			//RECORREMOS PRIMER CONSULTA (DATOS PROVEEDORES)
			while($row = $result ->fetch(PDO::FETCH_ASSOC)){
				//GUARDAMOS EN ARRAY DATOS DE PRIMER PROVEEDOR
				$condition = $row["Id_Usuario"];
					$item =array(

						"id" => $row["Id_Usuario"],
						"Nombre"=> $row["Nombre_Usuario"] . " " . $row["Apellidos_Usuario"],
						"Email" => $row["Email_Usuario"],
						"Telefono" => $row["Telefono_Usuario"],
						"Direccion" => $row["Direccion_Usuario"],
						"Ciudad" =>$row["Nombre_Municipio"],
						"Departamento" =>$row["Nombre_Departamento"],
				
					);
					$count = 0;
					//ITERA ARRAY DE PRODUCTOS
					while($count < count($countArray)){
						//COMPRUEBA QUE PRODUCTO PERTENECEN A ESTE PROVEEDOR, Y LOS GUARDA COMO
						// UN ARRAY
						if($countArray[$count]["id_usuario_productos"] == $condition){
							$itemDetail =array(
								"id_producto" => $countArray[$count]["id_producto"],
								"nombre_producto" => $countArray[$count]["nombre_producto"],
								"marca_producto" => $countArray[$count]["marca_producto"],
								"descripcion_producto" => $countArray[$count]["descripcion_producto"],
								"precio_producto"=>$countArray[$count]["id_usuario_productos"],
								"garantia_producto"=>$countArray[$count]["garantia_producto"],
								"existencia_producto"=>$countArray[$count]["existencia_producto"],
								"imagen_producto"=>$countArray[$count]["imagen_producto"],
							);
							
							$item ["productos"][] = $itemDetail;
						}
						$count++;
					}
					//GUARDAMOS EN JSON LOS DATOS COMPLETOS DE PROVEEDOR CON SUS PRODUCTOS
					
					$json['response'][] = $item;	
					
				}
			}
			//SI CONSULTA NO TIENE REGISTROS
		}else{
			$item = array("response" => "No found provider");
			$json['response'] = $item;	
		}


		}



		break;



	case "pqrs":

		$sql = $implement->verifiedParamPqrs(
			!empty($_GET["searchName"]) ? $_GET["searchName"] : null,
			!empty($_GET["searchApellido"]) ? $_GET["searchApellido"] : null,
			!empty($_GET["searchCity"]) ? $_GET["searchCity"] : null,
			!empty($_GET["searchDepartment"]) ? $_GET["searchDepartment"] : null,
			!empty($_GET["searchState"]) ? $_GET["searchState"] : null,
			!empty($_GET["searchReason"]) ? $_GET["searchReason"] : null,
			!empty($_GET["searchId"]) ? $_GET["searchId"] : null
		);
	
		if(!empty($sql)){
			$result = $conDb->prepare($sql);
			$result->execute();

			if ($result->rowCount() > 0) {

			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$item = array(
					"id" => $row["Id_PQRS"],
					"usuario" => $row["Nombre_Usuario"] . " " . $row["Apellidos_Usuario"],
					"detalle" => $row["Detalles_PQRS"],
					"correo" => $row["Email_Usuario"],
					"estado" => $row["Razon_Estado"],
					"razon" => $row["Tipo_Estado"]
	
				);
				//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
				$json['response'][] = $item;
				//IMPRIMIMOS OBJETO JSON
			}

			}else{
				$item = array("response" => "No found pqrs");
				$json['response'] = $item;	
			}
		}
			

		
		break;

	case "productosOfertas":
		$sql = $implement->verifiedParamProductOfert(
			!empty($_GET["searchName"]) ? $_GET["searchName"] : null,
			!empty($_GET["searchPMenor"]) ? $_GET["searchPMenor"] : null,
			!empty($_GET["searchPMayor"]) ? $_GET["searchPMayor"] : null,
			!empty($_GET["searchCategory"]) ? $_GET["searchCategory"] : null,
			!empty($_GET["searchBrand"]) ? $_GET["searchBrand"] : null,
			!empty($_GET["searchTypeOfert"]) ? $_GET["searchTypeOfert"] : null
		);
		
		if(!empty($sql)){
			$result = $conDb->prepare($sql);
			$result->execute();


			if ($result->rowCount() > 0) {
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$item = array(
					"id" => $row["Id_Produc_Ofert"],
					"porcentaje_oferta" => $row["Porcen_Oferta"],
					"referencia" => $row["Ref_Producto"],
					"marca" => $row["Marca_Producto"],
					"garantia" => $row["Garantia_Product_Ofert"],
					"precio_oferta" => $row["Precio_Produc_Ofert"],
					"precio_original" => $row["Nombre_Producto"],
					"nombre" => $row["Precio_Producto"],
					"descripcion_producto" => $row["Descripcion_Producto"],
					"tipo" => $row["Tipo_de_Oferta"],
					"fecha_inicio" => $row["Fecha_Inicio"],
					"fecha_fin" => $row["Fecha_Fin"],
					"imagen" => $row["Imagen_Producto"],
					"caracteristicas_oferta" => $row["Caracteristicas_oferta"]
	
				);
				//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
				$json['response'][] = $item;
				//IMPRIMIMOS OBJETO JSON
		}
		}else{
			$item = array("response" => "No found product ofert");
			$json['response'] = $item;	
		}

		
	}
		break;

	case "pedidos":


		$sql1 = $implement->verifiedParamPedidos(
			!empty($_GET["searchName"]) ? $_GET["searchName"] : null,
			!empty($_GET["searchApellido"]) ? $_GET["searchApellido"] : null,
			!empty($_GET["searchCity"]) ? $_GET["searchCity"] : null,
			!empty($_GET["searchDepartment"]) ? $_GET["searchDepartment"] : null,
			!empty($_GET["searchState"]) ? $_GET["searchState"] : null
		);
		
		if(!empty($sql1)){
			$resultPedidos = $conDb->prepare($sql1);
			$resultPedidos->execute();

			if($resultPedidos->rowCount() > 0){
			
			
				if($resultPedidos->rowCount() == 1){
					$row = $resultPedidos->fetch(PDO::FETCH_ASSOC);
					
					$id_pedido = $row['Id_Pedido'];

					$item = array(
						"id" => $id_pedido,
						"localidad"=> $row["Nombre_Municipio"],
						"estado"=> $row["Estado_Pedido"],
						"usuario"=> $row["Nombre_Usuario"] . " " . $row["Apellidos_Usuario"],
						"id_usuario"=> $row["Id_Usuario"],
						"direccion"=> $row["Direccion_Usuario"],
						"tomado_en"=> $row["Fecha_Pedido"],
						"entregar_en"=> $row["Fecha_Entrega"],
						"pago"=> $row["Tipo_Pago"],
						"cantidad_productos"=> $row["cantidad_productos"],
						"total_a_pagar"=> $row["Valor_Total"],

					);
					
					
					$sql2 = "SELECT p.Nombre_Producto,p.Id_Producto,dp.Cantidad_Producto,p.Imagen_Producto
					,dp.Precio_Producto,pd.Id_Pedido
					FROM productos p
					JOIN detalle_pedidos dp ON p.Id_Producto = dp.Id_Producto
					JOIN pedidos pd ON pd.Id_Pedido = dp.Id_Pedido
					WHERE pd.Id_Pedido = $id_pedido";
			
					$resultDetalles = $conDb->prepare($sql2);
					$resultDetalles->execute();

					while ($row = $resultDetalles->fetch(PDO::FETCH_ASSOC)) {

						$itemDetail = array(
							"id_pedido" => $row["Id_Pedido"],
							"id_producto" => $row["Id_Producto"],
							"nombre_producto" => $row["Nombre_Producto"],
							"cantidad_producto" => $row["Cantidad_Producto"],
							"precio_producto" => $row["Precio_Producto"],
							"imagen_producto" => $row["Imagen_Producto"],
							
						);

					$item["productos"][] = $itemDetail;
					}

					$json['response'][] = $item;

				}else{

				$sql2 = $implement->verifiedParamProductPedidos();
				$resultDetalles = $conDb->prepare($sql2);
				$resultDetalles->execute();
				while ($row = $resultDetalles->fetch(PDO::FETCH_ASSOC)) {

					$item = array(
						"id_pedido" => $row["Id_Pedido"],
						"id_producto" => $row["Id_Producto"],
						"nombre_producto" => $row["Nombre_Producto"],
						"cantidad_producto" => $row["Cantidad_Producto"],
						"precio_producto" => $row["Precio_Producto"],
						"imagen_producto" => $row["Imagen_Producto"],

					);
					$countArray[] = $item;
				}

				while ($row = $resultPedidos->fetch(PDO::FETCH_ASSOC)) {
					$condition = $row['Id_Pedido'];
					$item = array(
						"id" => $condition,
						"estado" => $row["Estado_Pedido"],
						"localidad"=> $row["Nombre_Municipio"],
						"usuario" => $row["Nombre_Usuario"] . " " . $row["Apellidos_Usuario"],
						"id_usuario" => $row["Id_Usuario"],
						"fecha_pedido" => $row["Fecha_Pedido"],
						"tomado_en"=> $row["Fecha_Pedido"],
						"direccion"=> $row["Direccion_Usuario"],
						"entregar_en"=> $row["Fecha_Entrega"],
						"pago"=> $row["Tipo_Pago"],
						"cantidad_productos" => $row["cantidad_productos"],
						"total_a_pagar" => $row["Valor_Total"],

					);
					$count = 0;
					//ITERA ARRAY DE PRODUCTOS
					while ($count < count($countArray)) {
						//COMPRUEBA QUE PRODUCTO PERTENECEN A ESTE PROVEEDOR, Y LOS GUARDA COMO
						// UN ARRAY
						if ($countArray[$count]["id_pedido"] == $condition) {
							$itemDetail = array(
								"id_producto" => $countArray[$count]["id_producto"],
								"nombre_producto" => $countArray[$count]["nombre_producto"],
								"cantidad_producto" => $countArray[$count]["cantidad_producto"],
								"precio_producto" => $countArray[$count]["precio_producto"],
								"imagen_producto"=>$countArray[$count]["imagen_producto"],
							);
							$item["productos"][] = $itemDetail;
						}
						$count++;
					}



			//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
			$json['response'][] = $item;
			//IMPRIMIMOS OBJETO JSON
			}
			}
		}else{
			$item = array("response" => "No found pedido");
			$json['response'] = $item;	
		}
	}
		break;

	case "envios":

		$sql = $implement->verifiedParamEnvios(
			!empty($_GET["searchName"]) ? $_GET["searchName"] : null,
			!empty($_GET["searchApellido"]) ? $_GET["searchApellido"] : null,
			!empty($_GET["searchCity"]) ? $_GET["searchCity"] : null,
			!empty($_GET["searchDepartment"]) ? $_GET["searchDepartment"] : null,
			!empty($_GET["searchDate"]) ? $_GET["searchDate"] : null
		);

		if(!empty($sql)){
			$result = $conDb->prepare($sql);
			$result->execute();
			if($result->rowCount() > 0){
				while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	
					$item = array(
						"id" => $row["Id_Envio"],
						"usuario_a_enviar" => $row["Nombre_Usuario"] . ' ' . $row["Apellidos_Usuario"],
						"cobertura" => $row["Cobertura"],
						"fecha_entrega" => $row["Fecha_Entrega"],
						"id_pedido" => $row["Id_Pedido"],
						"pago" => $row["Tipo_Pago"],
						"total" => $row["Valor_Total"]
		
					);
					//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
					$json['response'][] = $item;
					//IMPRIMIMOS OBJETO JSON
				}
				
			}else{
				$item = array("response" => "No found envio");
				$json['response'] = $item;	
			}
			
		}
		
		break;
		case "comentarios":

			$sql = $implement->verifiedParamComentarios(
				!empty($_GET["searchName"]) ? $_GET["searchName"] : null,
				!empty($_GET["searchApellido"]) ? $_GET["searchApellido"] : null,
				!empty($_GET["searchFecha"]) ? $_GET["searchFecha"] : null,
			);
	
			if(!empty($sql)){
				$result = $conDb->prepare($sql);
				$result->execute();
				if($result->rowCount() > 0){
					while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		
						$item = array(
							"id" => $row["Id_Comentario"],
							"comentario"=> $row["Descripcion_Comentario"],
							"producto"=> $row["Nombre_Producto"],
							"marca"=> $row["Marca_Producto"],
							"fecha_entrega"=> $row["Fecha_Comentario"],
							"usuario"=> $row["Nombre_Usuario"] . " " . $row["Apellidos_Usuario"],
			
						);
						//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
						$json['response'][] = $item;
						//IMPRIMIMOS OBJETO JSON
					}
					
				}else{
					$item = array("response" => "No found envio");
					$json['response'] = $item;	
				}
				
			}
			
			break;
			
}

if (!empty($json)) {
	echo json_encode($json);
} else {
	echo json_encode(array("response" => "Error","Code001"=>"No found param"));
}
