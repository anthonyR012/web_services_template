<?PHP
include_once('Conexion.php');
header('Access-Control-Allow-Origin: *');

//CAPTURA PARAMETRO DE GET 
$case = $_GET["case"];

 
$json=array();
//INSTANCIACION DE MI CONEXION A BBDD
$objConectar = new Conectar();
$conDb = $objConectar->getConnection();

switch ($case) {
    	case "productos":	
			
			$sql="SELECT p.*,c.Nombre_Categoria FROM productos p
			JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria";
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
						"Categoria"=>$row["Nombre_Categoria"],
						);
						$json['response'][]=$item;
				}

			

     		break;

		case "usuarios":
			$sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_Localidad
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento";
				

				$result = $conDb->prepare($sql);
				$result->execute();
				
					while($row =$result ->fetch(PDO::FETCH_ASSOC)){
						
						$item =array(
							"id" => $row["Id_Usuario"],
							"Nombre"=> $row["Nombre_Usuario"],
							"Apellido" => $row["Apellidos_Usuario"],
							"Email" => $row["Email_Usuario"],
							"Telefono" => $row["Telefono_Usuario"],
							"Ciudad" =>$row["Nombre_Municipio"],
							"Departamento" =>$row["Nombre_Departamento"],
							"Direccion" => $row["Direccion_Usuario"],
							"Contrasena" => $row["Password_Usuario"]
							
						);
						//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
						$json['response'][]=$item;
						//IMPRIMIMOS OBJETO JSON
						
					}
			
			break;

		case "proveedores":

			//EJECUTA DOS CONSULTAS, UNA: PROVEEDORES, DOS: PRODUCTOS DE PROVEEDORES
			$sql1="SELECT DISTINCT u.Id_Usuario,u.Nombre_Usuario,u.Apellidos_Usuario,u.Email_Usuario,u.Telefono_Usuario,u.Direccion_Usuario, 
			l.Nombre_Municipio,d.Nombre_Departamento
			FROM productos_proveedores pr
			JOIN usuarios u ON u.Id_Usuario = pr.Id_Proveedor
			JOIN localidad l ON u.Id_Localidad = l.Id_Localidad
			JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
            ORDER BY u.Id_Usuario";
			
			$sql2 = "SELECT u.Id_Usuario,p.Nombre_Producto,p.Marca_Producto,p.Descripcion_Producto,
			p.Imagen_Producto,p.Garantia_Producto,p.Existencia_Producto,p.Id_Producto
						,p.Precio_Producto FROM productos_proveedores pr
						JOIN usuarios u ON u.Id_Usuario = pr.Id_Proveedor
						JOIN productos p ON p.Id_Producto = pr.Id_Producto
						JOIN localidad l ON u.Id_Localidad = l.Id_Localidad
						JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
						ORDER BY u.Id_Usuario";

			$result = $conDb->prepare($sql1);
			$result2 = $conDb->prepare($sql2);
			$result->execute();
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
	
				
			
			
			
		break;

		

		case "pqrs":
			$sql="SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
			p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado 
			FROM usuarios u 
			JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario";

			$result = $conDb->prepare($sql);
			$result->execute();

			while($row =$result ->fetch(PDO::FETCH_ASSOC)){
				$item =array(
					"id" => $row["Id_PQRS"],
					"usuario"=> $row["Nombre_Usuario"]. " ".$row["Apellidos_Usuario"],
					"detalle" => $row["Detalles_PQRS"],
					"razon" => $row["Razon_Estado"],
					"estado" =>$row["Tipo_Estado"]
					
				);
				//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
				$json['response'][]=$item;
				//IMPRIMIMOS OBJETO JSON
			}
			break;

			case "productosOfertas": 
				$sql="SELECT po.Id_Produc_Ofert,o.Porc_Oferta,o.Precio_Oferta,
				p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,p.Garantia_Producto,
				p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
				o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
				FROM productos p
				JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
				JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta LIMIT 5";
	
				$result = $conDb->prepare($sql);
				$result->execute();
	
				while($row =$result ->fetch(PDO::FETCH_ASSOC)){
					$item =array(
						"id" => $row["Id_Produc_Ofert"],
						"porcentaje_oferta"=> $row["Porc_Oferta"],
						"referencia"=> $row["Ref_Producto"],
						"marca"=> $row["Marca_Producto"],
						"garantia"=> $row["Garantia_Producto"],
						"precio_oferta"=> $row["Precio_Oferta"],
						"precio_original" => $row["Precio_Producto"],
						"nombre" => $row["Nombre_Producto"],
						"descripcion_producto" => $row["Descripcion_Producto"],
						"tipo" => $row["Tipo_de_Oferta"],
						"fecha_inicio" =>$row["Fecha_Inicio"],
						"fecha_fin" =>$row["Fecha_Fin"],
						"imagen" =>$row["Imagen_Producto"],
						"caracteristicas_oferta" =>$row["Caracteristicas_oferta"]
						
					);
					//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
					$json['response'][]=$item;
					//IMPRIMIMOS OBJETO JSON
				}
				break;
			case "categorias":
				$sql="SELECT * FROM categorias_productos";
	
				$result = $conDb->prepare($sql);
				$result->execute();
	
				while($row =$result ->fetch(PDO::FETCH_ASSOC)){
				
						$item =array(
							"id" => $row["Id_Categoria"],
							"Nombre"=> $row["Nombre_Categoria"],
									   
						);
					//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
					$json['response'][]=$item;
					//IMPRIMIMOS OBJETO JSON
					}
				break;

			case "pedidos":
				$sql1="SELECT DISTINCT p.Id_Pedido,p.Estado_Pedido,p.Fecha_Pedido, 
				sum(dp.Cantidad_Producto) as cantidad_productos ,p.Valor_Total,
				 u.Nombre_Usuario,u.Apellidos_Usuario,u.Id_Usuario ,u.Direccion_Usuario,l.Nombre_Municipio,en.Fecha_Entrega,pg.Tipo_Pago 
				FROM pedidos p 
				JOIN usuarios u ON u.Id_Usuario = p.Id_Usuario 
				JOIN localidad l ON l.Id_localidad = u.Id_localidad
				JOIN departamentos dep ON dep.Id_Departamento =  l.Id_Departamento
				JOIN detalle_pedidos dp ON dp.Id_Pedido = p.Id_Pedido 
				JOIN productos pd ON pd.Id_Producto = dp.Id_Producto 
				JOIN envios en ON en.Id_Pedido = p.Id_Pedido
				JOIN pagos pg ON pg.Id_Pago = en.Id_Pago
				GROUP BY p.Id_Pedido";

				$sql2 ="SELECT p.Nombre_Producto,p.Id_Producto,dp.Cantidad_Producto
				,dp.Precio_Producto,pd.Id_Pedido,p.Imagen_Producto 
				FROM productos p
				JOIN detalle_pedidos dp ON p.Id_Producto = dp.Id_Producto
				JOIN pedidos pd ON pd.Id_Pedido = dp.Id_Pedido";
				$resultPedidos = $conDb->prepare($sql1);
				$resultPedidos->execute();

				$resultDetalles = $conDb->prepare($sql2);
				$resultDetalles->execute();

				while($row = $resultDetalles ->fetch(PDO::FETCH_ASSOC)){
				
					$item = array(
							"id_pedido" => $row["Id_Pedido"],
							"id_producto" => $row["Id_Producto"],
							"nombre_producto" => $row["Nombre_Producto"],
							"cantidad_producto" => $row["Cantidad_Producto"],
							"precio_producto"=>$row["Precio_Producto"],
							"imagen_producto"=>$row["Imagen_Producto"],
						
					);
					$countArray[] = $item;
	
				}
				
				while($row =$resultPedidos ->fetch(PDO::FETCH_ASSOC)){
						$condition = $row['Id_Pedido'];
						$item =array(
							"id" => $condition,
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
						$count = 0;
						//ITERA ARRAY DE PRODUCTOS
						while($count < count($countArray)){
							//COMPRUEBA QUE PRODUCTO PERTENECEN A ESTE PROVEEDOR, Y LOS GUARDA COMO
							// UN ARRAY
							if($countArray[$count]["id_pedido"] == $condition){
								$itemDetail =array(
									"id_producto" => $countArray[$count]["id_producto"],
									"nombre_producto" => $countArray[$count]["nombre_producto"],
									"cantidad_producto" => $countArray[$count]["cantidad_producto"],
									"precio_producto"=>$countArray[$count]["precio_producto"],
									"imagen_producto"=>$countArray[$count]["imagen_producto"],
								);
								$item ["productos"][] = $itemDetail;

							}
							$count++;
						}
						
				

					//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
					$json['response'][]=$item;
					//IMPRIMIMOS OBJETO JSON
					}
				break;
			
			case "envios":
				$sql="SELECT e.Id_Envio,e.Cobertura,e.Fecha_Entrega
				,e.Id_Pedido,p.Tipo_Pago,pd.Valor_Total,u.Nombre_Usuario,u.Apellidos_Usuario
				FROM envios e 
				JOIN pedidos pd ON pd.Id_Pedido = e.Id_Pedido
				JOIN usuarios u ON u.Id_Usuario = pd.Id_Usuario
				JOIN pagos p ON e.Id_Pago = p.Id_Pago";

				$result = $conDb->prepare($sql);
				$result->execute();
	
				while($row = $result ->fetch(PDO::FETCH_ASSOC)){
				
						$item =array(
							"id" => $row["Id_Envio"],
							"usuario_a_enviar"=> $row["Nombre_Usuario"] . ' ' .$row["Apellidos_Usuario"],
							"cobertura"=> $row["Cobertura"],
							"fecha_entrega"=> $row["Fecha_Entrega"],
							"id_pedido"=> $row["Id_Pedido"],
							"pago"=> $row["Tipo_Pago"],
							"total"=> $row["Valor_Total"]
							
									   
						);
					//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
					$json['response'][]=$item;
					//IMPRIMIMOS OBJETO JSON
					}
				break;
				
			case "comentarios":
					$sql="SELECT C.*,P.Nombre_Producto,P.Marca_Producto,U.Nombre_Usuario,U.Apellidos_Usuario FROM comentarios c 
					JOIN usuarios u ON c.Id_Usuario = u.Id_Usuario
					JOIN productos p ON p.Id_Producto = c.Id_Producto";
	
					$result = $conDb->prepare($sql);
					$result->execute();
		
					while($row = $result ->fetch(PDO::FETCH_ASSOC)){
					
					$item =array(
						"id" => $row["Id_Comentario"],
						"comentario"=> $row["Descripcion_Comentario"],
						"producto"=> $row["Nombre_Producto"],
						"marca"=> $row["Marca_Producto"],
						"fecha_entrega"=> $row["Fecha_Comentario"],
						"usuario"=> $row["Nombre_Usuario"] . " " . $row["Apellidos_Usuario"],
								
					);
						//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
						$json['response'][]=$item;
						//IMPRIMIMOS OBJETO JSON
						}
					break;

			case "departamentos":
						$sql="SELECT * FROM departamentos";
		
						$result = $conDb->prepare($sql);
						$result->execute();
			
						while($row = $result ->fetch(PDO::FETCH_ASSOC)){
						
						$item =array(
							"id" => $row["Id_Departamento"],
							"nombre"=> $row["Nombre_Departamento"],
						);
							//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
							$json['response'][]=$item;
							//IMPRIMIMOS OBJETO JSON
							}
						break;
			case "municipios":
							$sql="SELECT Id_Localidad,Nombre_Municipio
							FROM localidad";
			
							$result = $conDb->prepare($sql);
							$result->execute();
				
							while($row = $result ->fetch(PDO::FETCH_ASSOC)){
							
							$item =array(
								"id" => $row["Id_Localidad"],
								"nombre"=> $row["Nombre_Municipio"],
							);
								//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
								$json['response'][]=$item;
								//IMPRIMIMOS OBJETO JSON
								}
							break;
								
			case "activos":
								$sql="SELECT COUNT(Id_Usuario) as total FROM `usuarios` WHERE `Log_Usuario` = 'activo'";
					
								$result = $conDb->prepare($sql);
								$result->execute();
					
								while($row =$result ->fetch(PDO::FETCH_ASSOC)){
								
										$item =array(
											"cuenta" => $row["total"],
										);
									//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
									$json['response'][]=$item;
									//IMPRIMIMOS OBJETO JSON
									}
								break;
			case "registradosUsuarios":
						$sql="SELECT COUNT(*) as cuenta,MONTH(Creado_En) as mes
						FROM usuarios 
						GROUP BY MONTH(Creado_En) 
						ORDER BY MONTH(Creado_En) ASC";

						$result = $conDb->prepare($sql);
						$result->execute();
				
						while($row = $result ->fetch(PDO::FETCH_ASSOC)){
						
						$item =array(
							$row["mes"] => $row["cuenta"]
						);
						
							//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
						$json['response'][]=$item;
							//IMPRIMIMOS OBJETO JSON
							}
					break;	
					
			case "registradosProductos":
						$sql="SELECT COUNT(*) as cuenta,MONTH(Creado_En) as mes
						FROM productos 
						GROUP BY MONTH(Creado_En) 
						ORDER BY MONTH(Creado_En) ASC";

						$result = $conDb->prepare($sql);
						$result->execute();
				
						while($row = $result ->fetch(PDO::FETCH_ASSOC)){
						
						$item =array(
							$row["mes"] => $row["cuenta"]
						);
						
							//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
						$json['response'][]=$item;
							//IMPRIMIMOS OBJETO JSON
							}
			break;	
			case "enviosProductos":
				$sql="SELECT COUNT(*) as cuenta,MONTH(Fecha_Entrega) as mes
				FROM envios 
				GROUP BY MONTH(Fecha_Entrega) 
				ORDER BY MONTH(Fecha_Entrega) ASC";

				$result = $conDb->prepare($sql);
				$result->execute();
		
				while($row = $result ->fetch(PDO::FETCH_ASSOC)){
				
				$item =array(
					$row["mes"] => $row["cuenta"]
				);
				
					//AGREGAMOS AL ARRAY LOS DATOS ITERADOS
				$json['response'][]=$item;
					//IMPRIMIMOS OBJETO JSON
					}
	break;
		
			

}

if (!empty($json)) {
	echo json_encode($json);
} else {
	echo json_encode(array("response" => "Error","Code001"=>"No found param"));
}
		
?>