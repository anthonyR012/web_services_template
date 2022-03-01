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
       
		if(!empty($_GET["nombre"]) 
		&& !empty($_GET["marca"])  
		&& !empty($_GET["referencia"])  
		&& !empty($_GET["descripcion"])
		&& !empty($_GET["precio"])  
		&& !empty($_GET["existencia"])
		&& !empty($entityBody["imagen"])  || !empty($_POST["imagen"])
		&& !empty($_GET["garantia"])
		&& !empty($_GET["categoria"])
		&& !empty($_GET["id_proveedor"])){

			$path = "img/".$_GET['referencia'].".jpg";
		    $url = "https://buyme.hotmarketing.info/WebServices/$path";

			if(!empty($entityBody["imagen"])){
				file_put_contents($path,base64_decode($entityBody["imagen"]));
				$bytes = file_get_contents($path);
			}else{
				file_put_contents($path,base64_decode($_POST["imagen"]));
				$bytes = file_get_contents($path);
			}
		    

			$sql = $conDb->prepare("INSERT INTO productos (Id_Producto, Nombre_Producto, Marca_Producto, Ref_Producto, Descripcion_Producto, Precio_Producto, Existencia_Producto,Imagen_Producto, Garantia_Producto, Id_Categoria,Id_Proveedor) VALUES (NULL, :nombre, :marca, :referencia, :descripcion, :precio, :existencia,:imagen, :garantia,:categoria,:id_proveedor)");

			//TODO HACER DISPARADOR PARA INSERTAR EL PRODUCTO 
			
			$sql->bindParam(':nombre', $_GET["nombre"]);
			$sql->bindParam(':marca', $_GET["marca"]);
			$sql->bindParam(':referencia',$_GET["referencia"]);
			$sql->bindParam(':descripcion', $_GET["descripcion"]);
			$sql->bindParam(':precio', $_GET["precio"]);
			$sql->bindParam(':existencia', $_GET["existencia"]);
			$sql->bindParam(':imagen', $url);
			$sql->bindParam(':garantia', $_GET["garantia"]);
			$sql->bindParam(':categoria', $_GET["categoria"]);
			$sql->bindParam(':id_proveedor', $_GET["id_proveedor"]);
			
			$result = $sql->execute();
			
			if($result){
				$item = array("response"=>"insert complete");
				$json['response'][]=$item;
				
			}
			
		}
			break;

			
	case "ofertarProductos":
		
		if(!empty($_GET["Tipo_de_Oferta"]) 
		&& !empty($_GET["Caracteristicas_oferta"])  
		&& !empty($_GET["Fecha_Inicio"])  
		&& !empty($_GET["Fecha_Fin"])
		&& !empty($_GET["Porc_Oferta"])
		&& !empty($_GET["Precio_Oferta"])   
		&& !empty($_GET["Cantidad_Oferta"])
		&& !empty($_GET["Id_Producto"])){
			
				
			$sql = $conDb->prepare("INSERT INTO ofertas
			 (Id_Oferta,Tipo_de_Oferta, Caracteristicas_oferta,Fecha_Inicio,Fecha_Fin, 
			 Porc_Oferta,Precio_Oferta,Cantidad_Oferta,Id_Producto) VALUES (NULL,:tipo, :caracteristicas, :fechaI, :fechaF, :porcentaje,:precioOferta,:cantidadOf,
			:idProducto)");



		
			
			$sql->bindParam(':tipo',$_GET["Tipo_de_Oferta"]);
			$sql->bindParam(':caracteristicas', $_GET["Caracteristicas_oferta"]);
			$sql->bindParam(':fechaI', $_GET["Fecha_Inicio"]);
			$sql->bindParam(':fechaF', $_GET["Fecha_Fin"]);
			$sql->bindParam(':porcentaje', $_GET["Porc_Oferta"]);
			$sql->bindParam(':precioOferta', $_GET["Precio_Oferta"]);
			$sql->bindParam(':cantidadOf', $_GET["Cantidad_Oferta"]);
			$sql->bindParam(':idProducto', $_GET["Id_Producto"]);
			
		
		
			 
			
			$result= $sql->execute();

			 if($result){
				$item = array("response"=>"insert complete");
				$json['response'][]=$item;
				
			}
			
		}

		break;
	case "oferta":
		
		if(!empty($_GET["nombre"]) 
		&& !empty($_GET["marca"])  
		&& !empty($_GET["referencia"])  
		&& !empty($_GET["descripcion"])
		&& !empty($_GET["precio"])  
		&& !empty($_GET["existencia"])
		&& !empty($entityBody["imagen"])  
		&& !empty($_GET["garantia"])
		&& !empty($_GET["categoria"])
		&& !empty($_GET["id_proveedor"])){
			
			$path = "img/".$_GET['referencia'].".jpg";
		    $url = "http://localhost/webservice/$path";
		     file_put_contents($path,base64_decode($entityBody["imagen"]));
		      $bytes = file_get_contents($path);

			$sql = $conDb->prepare("INSERT INTO productos (Id_Producto, Nombre_Producto, Marca_Producto, Ref_Producto, Descripcion_Producto, Precio_Producto, Existencia_Producto,Imagen_Producto, Garantia_Producto, Id_Categoria,Id_Proveedor) VALUES (NULL, :nombre, :marca, :referencia, :descripcion, :precio, :existencia,:imagen, :garantia,:categoria,:id_proveedor)");

			//TODO HACER DISPARADOR PARA INSERTAR EL PRODUCTO 
			$ref = $_GET["referencia"];
			$sql->bindParam(':nombre', $_GET["nombre"]);
			$sql->bindParam(':marca', $_GET["marca"]);
			$sql->bindParam(':referencia',$ref);
			$sql->bindParam(':descripcion', $_GET["descripcion"]);
			$sql->bindParam(':precio', $_GET["precio"]);
			$sql->bindParam(':existencia', $_GET["existencia"]);
			$sql->bindParam(':imagen', $url);
			$sql->bindParam(':garantia', $_GET["garantia"]);
			$sql->bindParam(':categoria', $_GET["categoria"]);
			$sql->bindParam(':id_proveedor', $_GET["id_proveedor"]);
			
			 $result = $sql->execute();
			
			if($result){
				
				$sql="SELECT Id_Producto FROM productos
				WHERE Ref_Producto = '$ref'";
				
				$result = $conDb->prepare($sql);
				$result->execute();
				
				$row =  $result ->fetch(PDO::FETCH_ASSOC);

				$sql = $conDb->prepare("INSERT INTO `ofertas` (`Id_Oferta`, `Tipo_de_Oferta`, `Caracteristicas_oferta`, `Fecha_Inicio`, `Fecha_Fin`,`Porc_Oferta`,`Precio_Oferta`,`Cantidad_Oferta`, `Id_Producto`) VALUES (NULL, :tipo, :caracteristica, :inicio, :fin,:porc,:precio,:cantidad ,:producto)");
				
				$sql->bindParam(':tipo', $entityBody["tipo"]);
				$sql->bindParam(':caracteristica', $entityBody["caracteristica"]);
				$sql->bindParam(':inicio',$entityBody["inicio"]);
				$sql->bindParam(':fin',$entityBody["fin"]);
				$sql->bindParam(':porc',$entityBody["porcentaje"]);
				$sql->bindParam(':precio',$entityBody["precio"]);
				$sql->bindParam(':cantidad',$entityBody["cantidad"]);
				$sql->bindParam(':producto',$row['Id_Producto']);

				$sql->execute();

				$item = array("response"=>"insert complete");
				$json['response'][]=$item;
				
			}
			
		}

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
	
    break;

	case "pqrs":
		
		if(isset($_GET["validacion"])) 
	{

		// INSERT INTO `pqrs` (`Id_PQRS`, `Detalles_PQRS`, `Razon_Estado`, `Tipo_Estado`, `Id_Usuario`) VALUES (NULL, 'Excelente servicio, pero implementar mejoras', 'Peticion', 'Activo', '16');


		$sql = $conDb->prepare("INSERT INTO pqrs (Id_PQRS,Detalles_PQRS,Razon_Estado,Tipo_Estado,Id_Usuario ) VALUES ( NULL,:validacion,:estado,:rates,:id)");
		 $activo = 'activo';
		$sql->bindParam(':validacion', $_GET["validacion"]);
		$sql->bindParam(':estado',$activo);
		$sql->bindParam(':rates', $_GET["rates"]);
		$sql->bindParam(':id', $_GET["id"]);
		$result = $sql->execute();

		if($result){
			$item = array("response"=>"insert complete");
			$json['response'][]=$item;
		}else{
			echo "malo";
		}

	}

	break;

	/* POOLL */
case "pedidos":
		
	if(!empty($_GET["Estado_Pedido"])	
	&& !empty($_GET["Valor_Total"])		
	&& !empty($_GET["Id_Usuario"])){
		
	/*$fecha = date ( 'd-m-Y' );*/
		$sql = $conDb->prepare("INSERT INTO pedidos (Id_Pedido, Fecha_Pedido, Estado_Pedido, Valor_Total, Id_Usuario) VALUES (NULL, NOW(), :estado, :valor, :id_Usuario)");

				
		/*$sql->bindParam(':fecha', $fecha);*/
		$sql->bindParam(':estado', $_GET["Estado_Pedido"]);
		$sql->bindParam(':valor', $_GET["Valor_Total"]);
		$sql->bindParam(':id_Usuario', $_GET["Id_Usuario"]);
		
		 $result = $sql->execute();
		
		if($result){				

			$item = array("response"=>"insert complete");
			$json['response'][]=$item;
			
		}
		
	}

	break;

	case "detalle_pedidos":
		
		if(!empty($_GET["arrayProductos"])){
			$datosProduct = $_GET["arrayProductos"];
			$datosProductDeco = json_decode($datosProduct, true);
						
					$id_lastpedido = "SELECT COUNT(*) FROM pedidos";
					$resId_last = $conDb->prepare($id_lastpedido);
					$resId_last->execute();        
					$count = $resId_last->fetchColumn();					
					$idNewpedido = ($count+1);					

			foreach ($datosProductDeco as $row) {
				$idProducto = $row['id'];
				$cantidadProducto = $row['cantidad'];
				$precioProducto = $row['precio'];		

				
				$sql = $conDb->prepare("INSERT INTO detalle_pedidos (Id_Detalle, Id_Pedido, Id_Producto , Cantidad_Producto, Precio_Producto) VALUES (NULL, '$idNewpedido', '$idProducto', '$cantidadProducto', '$precioProducto')");			
				
					 $result = $sql->execute();					
			 }


			
			if($result){				
	
				$item = array("response"=>"insert complete");
				$json['response'][]=$item;
				
			}
			
		}
	
		break;	
		case "envios":

			$id_lastpedido = "SELECT COUNT(*) FROM pedidos";
			$resId_last = $conDb->prepare($id_lastpedido);
			$resId_last->execute();        
			$count = $resId_last->fetchColumn();					
			$idNewpedido = ($count+1);		


			$cobertura = "Local";
			$fecha =$_GET["fecha"];
			$idPago = $_GET["idPago"];



			$sql = $conDb->prepare("INSERT INTO `envios` (`Id_Envio`, `Cobertura`, `Fecha_Entrega`, `Id_Pedido`, `Id_Pago`) VALUES (NULL, :cobertura, :fecha, :idPedido, :idPago)");
		
			$sql->bindParam(':cobertura', $cobertura);
			$sql->bindParam(':fecha', $fecha);
			$sql->bindParam(':idPedido', $idNewpedido);
			$sql->bindParam(':idPago',$idPago);

		
			$result = $sql->execute();		
			
	
				
				if($result){				
		
					$item = array("response"=>"insert complete");
					$json['response'][]=$item;
					
				}
				
			
		
			break;	

		case "comentarios":
		
			
			$comentario = $_GET['comentario'];
			$producto = $_GET['Id_producto'];
			$usuario = $_GET['Id_usuario'];
			$fecha = $_GET['fecha'];

			$sql = $conDb->prepare("INSERT INTO comentarios (Descripcion_Comentario, Fecha_Comentario,Id_Producto,Id_Usuario) VALUES ('$comentario', '$fecha', $producto, $usuario)");

		
			$result = $sql->execute();

			if($result){
				$item = array("response"=>"insert complete");
				$json['response'][]=$item;
			}else{
				echo "malo";
			}


		break;


}


if (!empty($json)) {
	echo json_encode($json);
} else {
	echo json_encode(array("response" => "Error","Code 001"=>"No found param"));
}

?>