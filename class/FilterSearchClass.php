<?php
class FilterSearchClass{
    private $sqlProductProveedor;
    private $sqlProductPedidos;
    public function verifiedParamProduct($searchName,$searchPriceMenor,
    $searchPriceMayor,$searchCategory,$searchBrand,$searchOfert){

        $sql = "";
        //FILTRO POR TODOS
        if(!empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)){
            
            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
                JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
                WHERE p.Nombre_Producto like '%$searchName%'
                AND p.Marca_Producto like '%$searchBrand%'
                AND p.Precio_Producto BETWEEN $searchPriceMenor AND $searchPriceMayor
                AND c.Nombre_Categoria like '%$searchCategory%'";

        //FILTRO POR TODOS EXCEPTO MARCA
        }else if(!empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && empty($searchBrand)){

            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Nombre_Producto like '%$searchName%'
            AND p.Precio_Producto BETWEEN $searchPriceMenor AND $searchPriceMayor
            AND c.Nombre_Categoria like '%$searchCategory%'";
        //FILTRO TODO EXCEPTO MARCA Y CATEGORIA
        }else if(!empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && empty($searchCategory) 
        && empty($searchBrand)){

            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Nombre_Producto like '%$searchName%'
            AND p.Precio_Producto BETWEEN $searchPriceMenor AND $searchPriceMayor";
            
         //FILTRO TODO EXCEPTO MARCA,CATEGORIA Y PRECIO MAYOR
        }else if(!empty($searchName) 
            && !empty($searchPriceMenor) 
            && empty($searchPriceMayor) 
            && empty($searchCategory) 
            && empty($searchBrand)){

                $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
                JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
                WHERE p.Nombre_Producto like '%$searchName%'
                AND p.Precio_Producto > $searchPriceMenor";


             //FILTRO POR NOMBRE PRODUCTO
        }else if(!empty($searchName) 
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && empty($searchCategory) 
        && empty($searchBrand)){

            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Nombre_Producto like '%$searchName%'";

            //FILTRO POR TODO EXCEPTO NOMBRE
        }else if(empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)){

            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Marca_Producto like '%$searchBrand%'
            AND p.Precio_Producto BETWEEN $searchPriceMenor AND $searchPriceMayor
            AND c.Nombre_Categoria like '%$searchCategory%'";

            //FILTRO POR TODO EXCEPTO NOMBRE Y PRECIO MENOR
        }else if(empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && empty($searchBrand)){
            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Precio_Producto BETWEEN $searchPriceMenor AND $searchPriceMayor
            AND c.Nombre_Categoria like '%$searchCategory%'";
        
        //FILTRO POR NOMBRE, CATEGORIA Y MARCA
        }else if(!empty($searchName) 
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)){
            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Marca_Producto like '%$searchBrand%'
            AND p.Nombre_Producto like '%$searchName%'
            AND c.Nombre_Categoria like '%$searchCategory%'";


        //FILTRO POR MARCA
        }else if(empty($searchName)
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && empty($searchCategory) 
        && !empty($searchBrand)){

            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Marca_Producto like '%$searchBrand%'";

        //FILTRO POR CATEGORIA
        }else if(empty($searchName)
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && empty($searchBrand)){

            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE c.Nombre_Categoria like '%$searchCategory%'";

        //FILTRO PRECIO MAYOR
        }else if(empty($searchName)
        && empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && empty($searchCategory) 
        && empty($searchBrand)){
            
            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Precio_Producto < $searchPriceMayor";
        
        //FIILTRO PRECIO MENOR
        }else if(empty($searchName)
        && !empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && empty($searchCategory) 
        && empty($searchBrand)){
            
            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
                JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
                WHERE p.Precio_Producto > $searchPriceMenor";
        
        }else if(!empty($searchName)
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && empty($searchBrand)){
            
            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE c.Nombre_Categoria like '%$searchCategory%' 
            AND p.Nombre_Producto like '%$searchName%'";
        
        }else if(!empty($searchName)
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && empty($searchCategory) 
        && !empty($searchBrand)){
            
            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Marca_Producto like '%$searchBrand%' 
            AND p.Nombre_Producto like '%$searchName%'
            AND p.Precio_Producto BETWEEN $searchPriceMenor AND $searchPriceMayor";
        
        }else if(empty($searchName)
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)){
            
            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Marca_Producto like '%$searchBrand%' 
            AND c.Nombre_Categoria like '%$searchCategory%'";
        
        }

        if(!empty($searchOfert)){

            $sqlPorcion = explode("WHERE", $sql);
            $sql = $sqlPorcion[0] . " JOIN productos_ofertas pf ON p.Id_Producto = pf.Id_Producto WHERE " . $sqlPorcion[1];
            
        }

        return $sql;

    }

    public function verifiedParamUsers($searchId,$searchNameUser,$searchApellido,$searchCiudad,$searchDepartment){
        $sql="";
        //FILTRO POR NOMBRE, APELLIDO, CIUDAD Y DEPARTAMENTO
        if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)){
            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_localidad
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE l.Nombre_Municipio LIKE '$searchCiudad%'
            AND d.Nombre_Departamento LIKE '$searchDepartment%'
            AND u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'";

        //FILTRO POR NOMBRE, APELLIDO Y CIUDAD  
        }else if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && empty($searchDepartment)){
            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_localidad
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE l.Nombre_Municipio LIKE '$searchCiudad%'
            AND u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'";

             //FILTRO POR NOMBRE Y  APELLIDO 
        }else if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)){
            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_localidad
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'";

             //FILTRO POR NOMBRE  
        }else if(!empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)){
          
            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_localidad
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'";

            //FILTRO POR DEPARTAMENTO, CIUDAD Y APELLIDO
        }else if(empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)){

            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_localidad
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE l.Nombre_Municipio LIKE '$searchCiudad%'
            AND d.Nombre_Departamento LIKE '$searchDepartment%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'";
         //FILTRO POR DEPARTAMENTO Y CIUDAD 
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)){

            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_localidad
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE l.Nombre_Municipio LIKE '$searchCiudad%'
            AND d.Nombre_Departamento LIKE '$searchDepartment%'";
        
        //FILTRO POR DEPARTAMENTO 
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && !empty($searchDepartment)){

            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_localidad
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE d.Nombre_Departamento LIKE '$searchDepartment%'";
        
        //FILTRO POR CIUDAD 
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && !empty($searchCiudad) 
        && empty($searchDepartment)){

            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_localidad
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE l.Nombre_Municipio LIKE '$searchCiudad%'";
        
        //FILTRO POR APELLIDO
        }else if(empty($searchNameUser) 
        && !empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)){

            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_localidad
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE u.Apellidos_Usuario LIKE '$searchApellido%'";
        //FILTRO POR ID
        }else if(!empty($searchId)
        && empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)){
            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_localidad
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE u.Id_Usuario  LIKE '$searchId%'";

        }

        return $sql;    
    }

    public function verifiedParamProveedors($searchNameProve,$searchApellidoProve,$searchCiudad,$searchDepartment){
        $sql="";
        //FILTRO POR NOMBRE, APELLIDO, CIUDAD Y DEPARTAMENTO
        if(!empty($searchNameProve) 
        && !empty($searchApellidoProve) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)){
            
            

            $sql="SELECT DISTINCT u.Id_Usuario,u.Nombre_Usuario,u.Apellidos_Usuario,u.Email_Usuario,
            u.Telefono_Usuario,u.Direccion_Usuario, 
                l.Nombre_Municipio,d.Nombre_Departamento
                FROM usuarios u
                JOIN productos_proveedores pr ON u.Id_Usuario = pr.Id_Proveedor
                JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
                JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
                WHERE l.Nombre_Municipio LIKE '$searchCiudad%'
                AND d.Nombre_Departamento LIKE '$searchDepartment%'
                AND u.Nombre_Usuario LIKE '$searchNameProve%'
                AND u.Apellidos_Usuario LIKE '$searchApellidoProve%'";
                
                $this->sqlProductProveedor = "SELECT u.Id_Usuario,p.Nombre_Producto,p.Marca_Producto,p.Descripcion_Producto,
				p.Imagen_Producto,p.Garantia_Producto,p.Existencia_Producto,p.Id_Producto
				,p.Precio_Producto FROM productos_proveedores pr
				JOIN usuarios u ON u.Id_Usuario = pr.Id_Proveedor
				JOIN productos p ON p.Id_Producto = pr.Id_Producto
				JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
				JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
				WHERE  l.Nombre_Municipio LIKE '$searchCiudad%'
                AND d.Nombre_Departamento LIKE '$searchDepartment%'
                AND u.Nombre_Usuario LIKE '$searchNameProve%'
                AND u.Apellidos_Usuario LIKE '$searchApellidoProve%'";
                
        //FILTRO POR NOMBRE, APELLIDO Y CIUDAD  
        }else if(!empty($searchNameProve) 
        && !empty($searchApellidoProve) 
        && !empty($searchCiudad) 
        && empty($searchDepartment)){

            $sql="SELECT DISTINCT u.Id_Usuario,u.Nombre_Usuario,u.Apellidos_Usuario,u.Email_Usuario,
            u.Telefono_Usuario,u.Direccion_Usuario, 
                l.Nombre_Municipio,d.Nombre_Departamento
                FROM usuarios u
                JOIN productos_proveedores pr ON u.Id_Usuario = pr.Id_Proveedor
                JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
                JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
                WHERE l.Nombre_Municipio LIKE '$searchCiudad%'
                AND u.Nombre_Usuario LIKE '$searchNameProve%'
                AND u.Apellidos_Usuario LIKE '$searchApellidoProve%'";

            $this->sqlProductProveedor = "SELECT u.Id_Usuario,p.Nombre_Producto,p.Marca_Producto,p.Descripcion_Producto,
            p.Imagen_Producto,p.Garantia_Producto,p.Existencia_Producto,p.Id_Producto
            ,p.Precio_Producto FROM productos_proveedores pr
            JOIN usuarios u ON u.Id_Usuario = pr.Id_Proveedor
            JOIN productos p ON p.Id_Producto = pr.Id_Producto
            JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
            JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
            WHERE  l.Nombre_Municipio LIKE '$searchCiudad%'
            AND u.Nombre_Usuario LIKE '$searchNameProve%'
            AND u.Apellidos_Usuario LIKE '$searchApellidoProve%'";


             //FILTRO POR NOMBRE Y  APELLIDO 
        }else if(!empty($searchNameProve) 
        && !empty($searchApellidoProve) 
        && empty($searchCiudad) 
        && empty($searchDepartment)){
            $sql="SELECT DISTINCT u.Id_Usuario,u.Nombre_Usuario,u.Apellidos_Usuario,u.Email_Usuario,
            u.Telefono_Usuario,u.Direccion_Usuario, 
                l.Nombre_Municipio,d.Nombre_Departamento
                FROM usuarios u
                JOIN productos_proveedores pr ON u.Id_Usuario = pr.Id_Proveedor
                JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
                JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
                WHERE u.Nombre_Usuario LIKE '$searchNameProve%'
                AND u.Apellidos_Usuario LIKE '$searchApellidoProve%'";

        $this->sqlProductProveedor = "SELECT u.Id_Usuario,p.Nombre_Producto,p.Marca_Producto,p.Descripcion_Producto,
        p.Imagen_Producto,p.Garantia_Producto,p.Existencia_Producto,p.Id_Producto
        ,p.Precio_Producto FROM productos_proveedores pr
        JOIN usuarios u ON u.Id_Usuario = pr.Id_Proveedor
        JOIN productos p ON p.Id_Producto = pr.Id_Producto
        JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
        JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
        WHERE u.Nombre_Usuario LIKE '$searchNameProve%'
        AND u.Apellidos_Usuario LIKE '$searchApellidoProve%'";

             //FILTRO POR NOMBRE  
        }else if(!empty($searchNameProve) 
        && empty($searchApellidoProve) 
        && empty($searchCiudad) 
        && empty($searchDepartment)){
          
            $sql="SELECT DISTINCT u.Id_Usuario,u.Nombre_Usuario,u.Apellidos_Usuario,u.Email_Usuario,
            u.Telefono_Usuario,u.Direccion_Usuario, 
                l.Nombre_Municipio,d.Nombre_Departamento
                FROM usuarios u
                JOIN productos_proveedores pr ON u.Id_Usuario = pr.Id_Proveedor
                JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
                JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
                WHERE u.Nombre_Usuario LIKE '$searchNameProve%'";

                $this->sqlProductProveedor = "SELECT u.Id_Usuario,p.Nombre_Producto,p.Marca_Producto,p.Descripcion_Producto,
				p.Imagen_Producto,p.Garantia_Producto,p.Existencia_Producto,p.Id_Producto
				,p.Precio_Producto FROM productos_proveedores pr
				JOIN usuarios u ON u.Id_Usuario = pr.Id_Proveedor
				JOIN productos p ON p.Id_Producto = pr.Id_Producto
				JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
				JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
				WHERE u.Nombre_Usuario LIKE '$searchNameProve%'";

            //FILTRO POR DEPARTAMENTO, CIUDAD Y APELLIDO
        }else if(empty($searchNameProve) 
        && !empty($searchApellidoProve) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)){

            $sql="SELECT DISTINCT u.Id_Usuario,u.Nombre_Usuario,u.Apellidos_Usuario,u.Email_Usuario,
            u.Telefono_Usuario,u.Direccion_Usuario, 
                l.Nombre_Municipio,d.Nombre_Departamento
                FROM usuarios u
                JOIN productos_proveedores pr ON u.Id_Usuario = pr.Id_Proveedor
                JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
                JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
                WHERE l.Nombre_Municipio LIKE '$searchCiudad%'
                AND d.Nombre_Departamento LIKE '$searchDepartment%'
                AND u.Apellidos_Usuario LIKE '$searchApellidoProve%'";

            $this->sqlProductProveedor = "SELECT u.Id_Usuario,p.Nombre_Producto,p.Marca_Producto,p.Descripcion_Producto,
            p.Imagen_Producto,p.Garantia_Producto,p.Existencia_Producto,p.Id_Producto
            ,p.Precio_Producto FROM productos_proveedores pr
            JOIN usuarios u ON u.Id_Usuario = pr.Id_Proveedor
            JOIN productos p ON p.Id_Producto = pr.Id_Producto
            JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
            JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
            WHERE  l.Nombre_Municipio LIKE '$searchCiudad%'
            AND d.Nombre_Departamento LIKE '$searchDepartment%'
            AND u.Apellidos_Usuario LIKE '$searchApellidoProve%'";


         //FILTRO POR DEPARTAMENTO Y CIUDAD 
        }else if(empty($searchNameProve) 
        && empty($searchApellidoProve) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)){

            $sql="SELECT DISTINCT u.Id_Usuario,u.Nombre_Usuario,u.Apellidos_Usuario,u.Email_Usuario,
            u.Telefono_Usuario,u.Direccion_Usuario, 
                l.Nombre_Municipio,d.Nombre_Departamento
                FROM usuarios u
                JOIN productos_proveedores pr ON u.Id_Usuario = pr.Id_Proveedor
                JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
                JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
                WHERE l.Nombre_Municipio LIKE '$searchCiudad%'
                AND d.Nombre_Departamento LIKE '$searchDepartment%'";

            $this->sqlProductProveedor = "SELECT u.Id_Usuario,p.Nombre_Producto,p.Marca_Producto,p.Descripcion_Producto,
            p.Imagen_Producto,p.Garantia_Producto,p.Existencia_Producto,p.Id_Producto
            ,p.Precio_Producto FROM productos_proveedores pr
            JOIN usuarios u ON u.Id_Usuario = pr.Id_Proveedor
            JOIN productos p ON p.Id_Producto = pr.Id_Producto
            JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
            JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
            WHERE  l.Nombre_Municipio LIKE '$searchCiudad%'
            AND d.Nombre_Departamento LIKE '$searchDepartment%'";


        //FILTRO POR DEPARTAMENTO 
        }else if(empty($searchNameProve) 
        && empty($searchApellidoProve) 
        && empty($searchCiudad) 
        && !empty($searchDepartment)){

            $sql="SELECT DISTINCT u.Id_Usuario,u.Nombre_Usuario,u.Apellidos_Usuario,u.Email_Usuario,
            u.Telefono_Usuario,u.Direccion_Usuario, 
                l.Nombre_Municipio,d.Nombre_Departamento
                FROM usuarios u
                JOIN productos_proveedores pr ON u.Id_Usuario = pr.Id_Proveedor
                JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
                JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
                WHERE d.Nombre_Departamento LIKE '$searchDepartment%'";

            $this->sqlProductProveedor = "SELECT u.Id_Usuario,p.Nombre_Producto,p.Marca_Producto,p.Descripcion_Producto,
            p.Imagen_Producto,p.Garantia_Producto,p.Existencia_Producto,p.Id_Producto
            ,p.Precio_Producto FROM productos_proveedores pr
            JOIN usuarios u ON u.Id_Usuario = pr.Id_Proveedor
            JOIN productos p ON p.Id_Producto = pr.Id_Producto
            JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
            JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
            WHERE d.Nombre_Departamento LIKE '$searchDepartment%''";


        //FILTRO POR CIUDAD 
        }else if(empty($searchNameProve) 
        && empty($searchApellidoProve) 
        && !empty($searchCiudad) 
        && empty($searchDepartment)){

            $sql="SELECT DISTINCT u.Id_Usuario,u.Nombre_Usuario,u.Apellidos_Usuario,u.Email_Usuario,
            u.Telefono_Usuario,u.Direccion_Usuario, 
                l.Nombre_Municipio,d.Nombre_Departamento
                FROM usuarios u
                JOIN productos_proveedores pr ON u.Id_Usuario = pr.Id_Proveedor
                JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
                JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
                WHERE l.Nombre_Municipio LIKE '$searchCiudad%'";

            $this->sqlProductProveedor = "SELECT u.Id_Usuario,p.Nombre_Producto,p.Marca_Producto,p.Descripcion_Producto,
            p.Imagen_Producto,p.Garantia_Producto,p.Existencia_Producto,p.Id_Producto
            ,p.Precio_Producto FROM productos_proveedores pr
            JOIN usuarios u ON u.Id_Usuario = pr.Id_Proveedor
            JOIN productos p ON p.Id_Producto = pr.Id_Producto
            JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
            JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
            WHERE  l.Nombre_Municipio LIKE '$searchCiudad%'";

        //FILTRO POR APELLIDO
        }else if(empty($searchNameProve) 
        && !empty($searchApellidoProve) 
        && empty($searchCiudad) 
        && empty($searchDepartment)){

            $sql="SELECT DISTINCT u.Id_Usuario,u.Nombre_Usuario,u.Apellidos_Usuario,u.Email_Usuario,
            u.Telefono_Usuario,u.Direccion_Usuario, 
                l.Nombre_Municipio,d.Nombre_Departamento
                FROM usuarios u
                JOIN productos_proveedores pr ON u.Id_Usuario = pr.Id_Proveedor
                JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
                JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
                WHERE u.Apellidos_Usuario LIKE '$searchApellidoProve%'";

                $this->sqlProductProveedor = "SELECT u.Id_Usuario,p.Nombre_Producto,p.Marca_Producto,p.Descripcion_Producto,
				p.Imagen_Producto,p.Garantia_Producto,p.Existencia_Producto,p.Id_Producto
				,p.Precio_Producto FROM productos_proveedores pr
				JOIN usuarios u ON u.Id_Usuario = pr.Id_Proveedor
				JOIN productos p ON p.Id_Producto = pr.Id_Producto
				JOIN localidad l ON u.Id_Usuario = l.Id_Municipio
				JOIN departamentos d ON d.Id_Departamento = l.Id_Departamento 
				WHERE u.Apellidos_Usuario LIKE '$searchApellidoProve%'";
        }

        return $sql;

    }
    public function verifiedParamPqrs($searchNameUser,$searchApellido,$searchCiudad,$searchDepartment,$searchState,$searchReason,$searchId){
        $sql="";
        //FILTRO POR TODO
        if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && !empty($searchState)
        && !empty($searchReason)){

            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
		dp.Nombre_Departamento,l.Nombre_Municipio,
		p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
		FROM usuarios u 
		JOIN localidad l ON l.Id_localidad = u.Id_localidad
		JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
		JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
		WHERE p.Tipo_Estado.Tipo_Estado = '$searchState'
		AND p.Razon_Estado = '$searchReason'
		AND u.Nombre_Usuario LIKE '$searchNameUser%'
		AND u.Apellidos_Usuario LIKE '$searchApellido%'
		AND l.Nombre_Municipio = '$searchCiudad'
		AND dp.Nombre_Departamento = '$searchDepartment'";

        //FILTRO POR NOMBRE, APELLIDO, CIUDAD, DEPARTAMENTO Y ESTADO  
        }else if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && !empty($searchState)
        && empty($searchReason)){

            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE p.Tipo_Estado = '$searchState'
            AND u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            AND l.Nombre_Municipio = '$searchCiudad'
            AND dp.Nombre_Departamento = '$searchDepartment'";

             //FILTRO POR NOMBRE , APELLIDO, CIUDAD Y DEPARTAMENTO
        }else if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && empty($searchState)
        && empty($searchReason)){

            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            AND l.Nombre_Municipio = '$searchCiudad'
            AND dp.Nombre_Departamento = '$searchDepartment'";

             //FILTRO POR NOMBRE , APELLIDO Y CIUDAD 
        }else if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && empty($searchDepartment)
        && empty($searchState)
        && empty($searchReason)){
          
           $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            AND l.Nombre_Municipio = '$searchCiudad'";

            //FILTRO POR NOMBRE Y APELLIDO
        }else if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)
        && empty($searchState)
        && empty($searchReason)){

            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'";
         //FILTRO POR NOMBRE
        }else if(!empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)
        && empty($searchState)
        && empty($searchReason)){

            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'";
        
        //FILTRO POR APELLIDO,CIUDAD, DEPARTAMENTO,ESTADO Y RAZON
        }else if(empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && !empty($searchState)
        && !empty($searchReason)){

            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE p.Tipo_Estado = '$searchState'
            AND p.Razon_Estado = '$searchReason'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            AND l.Nombre_Municipio = '$searchCiudad'
            AND dp.Nombre_Departamento = '$searchDepartment'";
        
        //FILTRO POR CIUDAD ,DEPARTAMENTO , ESTADO Y RAZON
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && !empty($searchState)
        && !empty($searchReason)){

            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE p.Tipo_Estado = '$searchState'
            AND p.Razon_Estado = '$searchReason'
            AND l.Nombre_Municipio = '$searchCiudad'
            AND dp.Nombre_Departamento = '$searchDepartment'";
        
        //FILTRO POR DEPARTAMENTO , ESTADO Y RAZON
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && !empty($searchDepartment)
        && !empty($searchState)
        && !empty($searchReason)){

            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE p.Tipo_Estado = '$searchState'
            AND p.Razon_Estado = '$searchReason'
            AND dp.Nombre_Departamento = '$searchDepartment'";
        // FILTRO POR ESTADO Y RAZON
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)
        && !empty($searchState)
        && !empty($searchReason)){

            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE p.Tipo_Estado = '$searchState'
            AND p.Razon_Estado = '$searchReason'";
        //FILTRO POR RAZON
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)
        && empty($searchState)
        && !empty($searchReason)){
            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,u.Email_Usuario,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE p.Razon_Estado = '$searchReason'";
        //FILTRO POR ESTADO
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)
        && !empty($searchState)
        && empty($searchReason)){
            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE p.Tipo_Estado = '$searchState'";

        //FILTRO POR DEPARTAMENTO
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && !empty($searchDepartment)
        && empty($searchState)
        && empty($searchReason)){
            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE dp.Nombre_Departamento = '$searchDepartment'";
        //FILTRO POR CIUDAD
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && !empty($searchCiudad) 
        && empty($searchDepartment)
        && empty($searchState)
        && empty($searchReason)){
            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE l.Nombre_Municipio = '$searchCiudad'";
        //FILTRO POR APELLIDO
        }else if(empty($searchNameUser) 
        && !empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)
        && empty($searchState)
        && empty($searchReason)){
            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario 
            WHERE u.Apellidos_Usuario LIKE '$searchApellido%'";

            // FILTRO POR EMAIL
        }else if(!empty($searchId)
        && empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad)  
        && empty($searchDepartment)
        && empty($searchState)
        && empty($searchReason)){

            $sql = "SELECT p.Id_PQRS, u.Nombre_Usuario,u.Apellidos_Usuario,
            dp.Nombre_Departamento,l.Nombre_Municipio,
            p.Detalles_PQRS,p.Razon_Estado,p.Tipo_Estado
            FROM usuarios u 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
            JOIN pqrs p ON p.Id_Usuario = u.Id_Usuario  
            WHERE u.Id_Usuario = '$searchId'";

        }
        return $sql;    
    }

    public function verifiedParamProductOfert($searchName,$searchPriceMenor,
    $searchPriceMayor,$searchCategory,$searchBrand,$searchTypeOfert){

        $sql = "";
        //FILTRO POR TODOS
        if(!empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)
        && !empty($searchTypeOfert)){
            
            $sql = "SELECT po.Id_Produc_Ofert,po.Precio_Produc_Ofert,
            po.Porcen_Oferta,po.Cant_Product_Ofert,po.Garantia_Product_Ofert,
            p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,
            p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
            o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
            FROM productos p
            JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
            JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta
            JOIN categorias_productos cp ON cp.Id_Categoria = p.Id_Categoria
            WHERE p.Nombre_Producto LIKE '$searchName%'
            AND p.Marca_Producto LIKE '$searchBrand%'
            AND o.Tipo_de_Oferta = '$searchTypeOfert'
            AND po.Precio_Produc_Ofert < $searchPriceMenor
            AND po.Precio_Produc_Ofert > $searchPriceMayor
            AND cp.Nombre_Categoria LIKE '$searchCategory'";

        //FILTRO POR TIPO OFERTA, PRECIO MAYOR Y MENOR, CATEGORIA Y MARCA
        }else if(empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)
        && !empty($searchTypeOfert)){
            
            $sql = "SELECT po.Id_Produc_Ofert,po.Precio_Produc_Ofert,
            po.Porcen_Oferta,po.Cant_Product_Ofert,po.Garantia_Product_Ofert,
            p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,
            p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
            o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
            FROM productos p
            JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
            JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta
            JOIN categorias_productos cp ON cp.Id_Categoria = p.Id_Categoria
            WHERE p.Marca_Producto LIKE '$searchBrand%'
            AND o.Tipo_de_Oferta = '$searchTypeOfert'
            AND po.Precio_Produc_Ofert < $searchPriceMenor
            AND po.Precio_Produc_Ofert > $searchPriceMayor
            AND cp.Nombre_Categoria LIKE '$searchCategory'";

        //FILTRO POR TIPO OFERTA, PRECIO MAYOR , CATEGORIA Y MARCA
        }else if(empty($searchName) 
        && empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)
        && !empty($searchTypeOfert)){
            
            $sql = "SELECT po.Id_Produc_Ofert,po.Precio_Produc_Ofert,
            po.Porcen_Oferta,po.Cant_Product_Ofert,po.Garantia_Product_Ofert,
            p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,
            p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
            o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
            FROM productos p
            JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
            JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta
            JOIN categorias_productos cp ON cp.Id_Categoria = p.Id_Categoria
            WHERE p.Marca_Producto LIKE '$searchBrand%'
            AND o.Tipo_de_Oferta = '$searchTypeOfert'
            AND po.Precio_Produc_Ofert > $searchPriceMayor
            AND cp.Nombre_Categoria LIKE '$searchCategory'";

        //FILTRO POR CATEGORIA, MARCA Y TIPO OFERTA
        }else if(empty($searchName) 
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)
        && !empty($searchTypeOfert)){
            
            $sql = "SELECT po.Id_Produc_Ofert,po.Precio_Produc_Ofert,
            po.Porcen_Oferta,po.Cant_Product_Ofert,po.Garantia_Product_Ofert,
            p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,
            p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
            o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
            FROM productos p
            JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
            JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta
            JOIN categorias_productos cp ON cp.Id_Categoria = p.Id_Categoria
            WHERE p.Marca_Producto LIKE '$searchBrand%'
            AND o.Tipo_de_Oferta = '$searchTypeOfert'
            AND cp.Nombre_Categoria LIKE '$searchCategory'";

        //FILTRO POR  MARCA Y TIPO OFERTA
        }else if(empty($searchName) 
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && empty($searchCategory) 
        && !empty($searchBrand)
        && !empty($searchTypeOfert)){
            
            $sql = "SELECT po.Id_Produc_Ofert,po.Precio_Produc_Ofert,
            po.Porcen_Oferta,po.Cant_Product_Ofert,po.Garantia_Product_Ofert,
            p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,
            p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
            o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
            FROM productos p
            JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
            JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta
            JOIN categorias_productos cp ON cp.Id_Categoria = p.Id_Categoria
            WHERE p.Marca_Producto LIKE '$searchBrand%'
            AND o.Tipo_de_Oferta = '$searchTypeOfert'";

         //FILTRO TIPO OFERTA
        }else if(empty($searchName) 
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && empty($searchCategory) 
        && empty($searchBrand)
        && !empty($searchTypeOfert)){
            
            $sql = "SELECT po.Id_Produc_Ofert,po.Precio_Produc_Ofert,
            po.Porcen_Oferta,po.Cant_Product_Ofert,po.Garantia_Product_Ofert,
            p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,
            p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
            o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
            FROM productos p
            JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
            JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta
            JOIN categorias_productos cp ON cp.Id_Categoria = p.Id_Categoria
            WHERE o.Tipo_de_Oferta = '$searchTypeOfert'";

        //FILTRO POR NOMBRE, PRECIO MAYOR Y MENOR, CATEGORIA Y MARCA
        }else if(!empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)
        && empty($searchTypeOfert)){
            
            $sql = "SELECT po.Id_Produc_Ofert,po.Precio_Produc_Ofert,
            po.Porcen_Oferta,po.Cant_Product_Ofert,po.Garantia_Product_Ofert,
            p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,
            p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
            o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
            FROM productos p
            JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
            JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta
            JOIN categorias_productos cp ON cp.Id_Categoria = p.Id_Categoria
            WHERE p.Nombre_Producto LIKE '$searchName%'
            AND p.Marca_Producto LIKE '$searchBrand%'
            AND po.Precio_Produc_Ofert < $searchPriceMenor
            AND po.Precio_Produc_Ofert > $searchPriceMayor
            AND cp.Nombre_Categoria LIKE '$searchCategory'";

        //FILTRO POR NOMBRE, PRECIO MAYOR Y MENOR, CATEGORIA 
        }else if(!empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && empty($searchBrand)
        && empty($searchTypeOfert)){
            
            $sql = "SELECT po.Id_Produc_Ofert,po.Precio_Produc_Ofert,
            po.Porcen_Oferta,po.Cant_Product_Ofert,po.Garantia_Product_Ofert,
            p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,
            p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
            o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
            FROM productos p
            JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
            JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta
            JOIN categorias_productos cp ON cp.Id_Categoria = p.Id_Categoria
            WHERE p.Nombre_Producto LIKE '$searchName%'
            AND po.Precio_Produc_Ofert < $searchPriceMenor
            AND po.Precio_Produc_Ofert > $searchPriceMayor
            AND cp.Nombre_Categoria LIKE '$searchCategory'";

        //FILTRO POR NOMBRE, PRECIO MAYOR Y MENOR
        }else if(!empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && empty($searchCategory) 
        && empty($searchBrand)
        && empty($searchTypeOfert)){
            
            $sql = "SELECT po.Id_Produc_Ofert,po.Precio_Produc_Ofert,
            po.Porcen_Oferta,po.Cant_Product_Ofert,po.Garantia_Product_Ofert,
            p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,
            p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
            o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
            FROM productos p
            JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
            JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta
            JOIN categorias_productos cp ON cp.Id_Categoria = p.Id_Categoria
            WHERE p.Nombre_Producto LIKE '$searchName%'
            AND po.Precio_Produc_Ofert < $searchPriceMenor
            AND po.Precio_Produc_Ofert > $searchPriceMayor";

        //FILTRO POR NOMBRE, PRECIO MENOR
        }else if(!empty($searchName) 
        && !empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && empty($searchCategory) 
        && empty($searchBrand)
        && empty($searchTypeOfert)){
            
            $sql = "SELECT po.Id_Produc_Ofert,po.Precio_Produc_Ofert,
            po.Porcen_Oferta,po.Cant_Product_Ofert,po.Garantia_Product_Ofert,
            p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,
            p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
            o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
            FROM productos p
            JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
            JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta
            JOIN categorias_productos cp ON cp.Id_Categoria = p.Id_Categoria
            WHERE p.Nombre_Producto LIKE '$searchName%'
            AND po.Precio_Produc_Ofert < $searchPriceMenor";

        //FILTRO POR NOMBRE
        }else if(!empty($searchName) 
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && empty($searchCategory) 
        && empty($searchBrand)
        && empty($searchTypeOfert)){
            
            $sql = "SELECT po.Id_Produc_Ofert,po.Precio_Produc_Ofert,
            po.Porcen_Oferta,po.Cant_Product_Ofert,po.Garantia_Product_Ofert,
            p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,
            p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
            o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
            FROM productos p
            JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
            JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta
            JOIN categorias_productos cp ON cp.Id_Categoria = p.Id_Categoria
            WHERE p.Nombre_Producto LIKE '$searchName%'";

        //FILTRO POR PRECIO MENOR Y MAYOR
        }else if(empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && empty($searchCategory) 
        && empty($searchBrand)
        && empty($searchTypeOfert)){
            
            $sql = "SELECT po.Id_Produc_Ofert,po.Precio_Produc_Ofert,
            po.Porcen_Oferta,po.Cant_Product_Ofert,po.Garantia_Product_Ofert,
            p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,
            p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
            o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
            FROM productos p
            JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
            JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta
            JOIN categorias_productos cp ON cp.Id_Categoria = p.Id_Categoria
            WHERE po.Precio_Produc_Ofert < $searchPriceMenor
            AND po.Precio_Produc_Ofert > $searchPriceMayor";

        //FILTRO POR CATEGORIA Y MARCA
        }else if(empty($searchName) 
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)
        && empty($searchTypeOfert)){
            
            $sql = "SELECT po.Id_Produc_Ofert,po.Precio_Produc_Ofert,
            po.Porcen_Oferta,po.Cant_Product_Ofert,po.Garantia_Product_Ofert,
            p.Nombre_Producto,p.Marca_Producto,p.Ref_Producto,
            p.Descripcion_Producto,p.Precio_Producto,p.Imagen_Producto,
            o.Caracteristicas_oferta,o.Fecha_Inicio,o.Fecha_Fin,o.Tipo_de_Oferta
            FROM productos p
            JOIN productos_ofertas po ON p.Id_Producto = po.Id_Producto
            JOIN ofertas o ON o.Id_Oferta = po.Id_Oferta
            JOIN categorias_productos cp ON cp.Id_Categoria = p.Id_Categoria
            WHERE p.Marca_Producto LIKE '$searchBrand%'
            AND cp.Nombre_Categoria LIKE '$searchCategory'";

        }

        return $sql;

    }

    public function verifiedParamPedidos($searchNameUser,$searchApellido,$searchCiudad,$searchDepartment,$searchState){
        $sql="";
        //FILTRO POR TODO
        if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && !empty($searchState)){

            $sql = "SELECT DISTINCT p.Id_Pedido,p.Estado_Pedido,p.Fecha_Pedido, 
            sum(dp.Cantidad_Producto) as cantidad_productos ,p.Valor_Total,en.Fecha_Entrega,pg.Tipo_Pago ,u.Nombre_Usuario,u.Apellidos_Usuario,u.Id_Usuario,u.Direccion_Usuario,l.Nombre_Municipio 
            FROM pedidos p 
            JOIN usuarios u ON u.Id_Usuario = p.Id_Usuario 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento =  l.Id_Departamento
            JOIN detalle_pedidos dp ON dp.Id_Pedido = p.Id_Pedido 
            JOIN productos pd ON pd.Id_Producto = dp.Id_Producto 
            JOIN envios en ON en.Id_Pedido = p.Id_Pedido
			JOIN pagos pg ON pg.Id_Pago = en.Id_Pago
            WHERE p.Estado_Pedido = '$searchState'
            AND u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            AND l.Nombre_Municipio = '$searchCiudad'
            AND dep.Nombre_Departamento = '$searchDepartment'
            GROUP BY p.Id_Pedido";


            $this->sqlProductPedidos ="SELECT pd.Nombre_Producto,pd.Id_Producto,dp.Cantidad_Producto
            ,dp.Precio_Producto,p.Id_Pedido,pd.Imagen_Producto 
            FROM productos pd
            JOIN detalle_pedidos dp ON pd.Id_Producto = dp.Id_Producto
            JOIN pedidos p ON p.Id_Pedido = dp.Id_Pedido
            JOIN usuarios u  ON u.Id_Usuario = p.Id_Usuario
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento = l.Id_Departamento
            WHERE p.Estado_Pedido = '$searchState'
            AND u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            AND l.Nombre_Municipio = '$searchCiudad'
            AND dep.Nombre_Departamento = '$searchDepartment'";


        //FILTRO POR NOMBRE, APELLIDO, CIUDAD Y DEPARTAMENTO   
        }else if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && empty($searchState)){

            $sql = "SELECT DISTINCT p.Id_Pedido,p.Estado_Pedido,p.Fecha_Pedido, 
            sum(dp.Cantidad_Producto) as cantidad_productos ,p.Valor_Total,en.Fecha_Entrega,pg.Tipo_Pago ,
             u.Nombre_Usuario,u.Apellidos_Usuario,u.Id_Usuario ,u.Direccion_Usuario,l.Nombre_Municipio 
            FROM pedidos p 
            JOIN usuarios u ON u.Id_Usuario = p.Id_Usuario 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento =  l.Id_Departamento
            JOIN detalle_pedidos dp ON dp.Id_Pedido = p.Id_Pedido 
            JOIN productos pd ON pd.Id_Producto = dp.Id_Producto 
            JOIN envios en ON en.Id_Pedido = p.Id_Pedido
			JOIN pagos pg ON pg.Id_Pago = en.Id_Pago
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            AND l.Nombre_Municipio = '$searchCiudad'
            AND dep.Nombre_Departamento = '$searchDepartment'
            GROUP BY p.Id_Pedido";


            
            $this->sqlProductPedidos ="SELECT pd.Nombre_Producto,pd.Imagen_Producto,pd.Id_Producto,dp.Cantidad_Producto
            ,dp.Precio_Producto,p.Id_Pedido
            FROM productos pd
            JOIN detalle_pedidos dp ON pd.Id_Producto = dp.Id_Producto
            JOIN pedidos p ON p.Id_Pedido = dp.Id_Pedido
            JOIN usuarios u  ON u.Id_Usuario = p.Id_Usuario
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento = l.Id_Departamento
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            AND l.Nombre_Municipio = '$searchCiudad'
            AND dep.Nombre_Departamento = '$searchDepartment'";
        
             //FILTRO POR NOMBRE , APELLIDO Y CIUDAD 
        }else if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && empty($searchDepartment)
        && empty($searchState)){

            $sql = "SELECT DISTINCT p.Id_Pedido,p.Estado_Pedido,p.Fecha_Pedido, 
            sum(dp.Cantidad_Producto) as cantidad_productos ,p.Valor_Total,
             u.Nombre_Usuario,u.Apellidos_Usuario,u.Id_Usuario,en.Fecha_Entrega,pg.Tipo_Pago ,u.Direccion_Usuario,l.Nombre_Municipio 
            FROM pedidos p 
            JOIN usuarios u ON u.Id_Usuario = p.Id_Usuario 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento =  l.Id_Departamento
            JOIN detalle_pedidos dp ON dp.Id_Pedido = p.Id_Pedido 
            JOIN productos pd ON pd.Id_Producto = dp.Id_Producto 
            JOIN envios en ON en.Id_Pedido = p.Id_Pedido
			JOIN pagos pg ON pg.Id_Pago = en.Id_Pago
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            AND l.Nombre_Municipio = '$searchCiudad'
            GROUP BY p.Id_Pedido";

            $this->sqlProductPedidos ="SELECT pd.Nombre_Producto,pd.Imagen_Producto,pd.Id_Producto,dp.Cantidad_Producto
            ,dp.Precio_Producto,p.Id_Pedido
            FROM productos pd
            JOIN detalle_pedidos dp ON pd.Id_Producto = dp.Id_Producto
            JOIN pedidos p ON p.Id_Pedido = dp.Id_Pedido
            JOIN usuarios u  ON u.Id_Usuario = p.Id_Usuario
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento = l.Id_Departamento
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            AND l.Nombre_Municipio = '$searchCiudad'";

             //FILTRO POR NOMBRE Y APELLIDO 
        }else if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)
        && empty($searchState)){
          
            $sql = "SELECT DISTINCT p.Id_Pedido,p.Estado_Pedido,p.Fecha_Pedido, 
            sum(dp.Cantidad_Producto) as cantidad_productos ,p.Valor_Total,en.Fecha_Entrega,pg.Tipo_Pago ,
             u.Nombre_Usuario,u.Apellidos_Usuario,u.Id_Usuario ,u.Direccion_Usuario,l.Nombre_Municipio 
            FROM pedidos p 
            JOIN usuarios u ON u.Id_Usuario = p.Id_Usuario 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento =  l.Id_Departamento
            JOIN detalle_pedidos dp ON dp.Id_Pedido = p.Id_Pedido 
            JOIN productos pd ON pd.Id_Producto = dp.Id_Producto 
            JOIN envios en ON en.Id_Pedido = p.Id_Pedido
			JOIN pagos pg ON pg.Id_Pago = en.Id_Pago
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            GROUP BY p.Id_Pedido";


            $this->sqlProductPedidos ="SELECT pd.Nombre_Producto,pd.Imagen_Producto,pd.Id_Producto,dp.Cantidad_Producto
            ,dp.Precio_Producto,p.Id_Pedido
            FROM productos pd
            JOIN detalle_pedidos dp ON pd.Id_Producto = dp.Id_Producto
            JOIN pedidos p ON p.Id_Pedido = dp.Id_Pedido
            JOIN usuarios u  ON u.Id_Usuario = p.Id_Usuario
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento = l.Id_Departamento
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'";

            //FILTRO POR NOMBRE
        }else if(!empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)
        && empty($searchState)){

            $sql = "SELECT DISTINCT p.Id_Pedido,p.Estado_Pedido,p.Fecha_Pedido, 
            sum(dp.Cantidad_Producto) as cantidad_productos ,p.Valor_Total,en.Fecha_Entrega,pg.Tipo_Pago ,
             u.Nombre_Usuario,u.Apellidos_Usuario,u.Id_Usuario ,u.Direccion_Usuario,l.Nombre_Municipio 
            FROM pedidos p 
            JOIN usuarios u ON u.Id_Usuario = p.Id_Usuario 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento =  l.Id_Departamento
            JOIN detalle_pedidos dp ON dp.Id_Pedido = p.Id_Pedido 
            JOIN productos pd ON pd.Id_Producto = dp.Id_Producto 
            JOIN envios en ON en.Id_Pedido = p.Id_Pedido
			JOIN pagos pg ON pg.Id_Pago = en.Id_Pago
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            GROUP BY p.Id_Pedido";

            $this->sqlProductPedidos ="SELECT pd.Nombre_Producto,pd.Imagen_Producto,pd.Id_Producto,dp.Cantidad_Producto
            ,dp.Precio_Producto,p.Id_Pedido
            FROM productos pd
            JOIN detalle_pedidos dp ON pd.Id_Producto = dp.Id_Producto
            JOIN pedidos p ON p.Id_Pedido = dp.Id_Pedido
            JOIN usuarios u  ON u.Id_Usuario = p.Id_Usuario
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento = l.Id_Departamento
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'";
         //FILTRO POR APELLIDO, CIUDAD,DEPARTAMENTO Y ESTADO
        }else if(empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && !empty($searchState)){
            $sql = "SELECT DISTINCT p.Id_Pedido,p.Estado_Pedido,p.Fecha_Pedido, 
            sum(dp.Cantidad_Producto) as cantidad_productos ,p.Valor_Total,en.Fecha_Entrega,pg.Tipo_Pago ,
             u.Nombre_Usuario,u.Apellidos_Usuario,u.Id_Usuario ,u.Direccion_Usuario,l.Nombre_Municipio 
            FROM pedidos p 
            JOIN usuarios u ON u.Id_Usuario = p.Id_Usuario 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento =  l.Id_Departamento
            JOIN detalle_pedidos dp ON dp.Id_Pedido = p.Id_Pedido 
            JOIN productos pd ON pd.Id_Producto = dp.Id_Producto
            JOIN envios en ON en.Id_Pedido = p.Id_Pedido
			JOIN pagos pg ON pg.Id_Pago = en.Id_Pago 
            WHERE p.Estado_Pedido = '$searchState'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            AND l.Nombre_Municipio = '$searchCiudad'
            AND dep.Nombre_Departamento = '$searchDepartment'
            GROUP BY p.Id_Pedido";

            $this->sqlProductPedidos ="SELECT pd.Nombre_Producto,pd.Imagen_Producto,pd.Id_Producto,dp.Cantidad_Producto
            ,dp.Precio_Producto,p.Id_Pedido
            FROM productos pd
            JOIN detalle_pedidos dp ON pd.Id_Producto = dp.Id_Producto
            JOIN pedidos p ON p.Id_Pedido = dp.Id_Pedido
            JOIN usuarios u  ON u.Id_Usuario = p.Id_Usuario
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento = l.Id_Departamento
            WHERE p.Estado_Pedido = '$searchState'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            AND l.Nombre_Municipio = '$searchCiudad'
            AND dep.Nombre_Departamento = '$searchDepartment'";
        
        //FILTRO POR CIUDAD, DEPARTAMENTO,ESTADO 
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && !empty($searchState)){

            $sql = "SELECT DISTINCT p.Id_Pedido,p.Estado_Pedido,p.Fecha_Pedido, 
            sum(dp.Cantidad_Producto) as cantidad_productos ,p.Valor_Total,en.Fecha_Entrega,pg.Tipo_Pago ,
             u.Nombre_Usuario,u.Apellidos_Usuario,u.Id_Usuario ,u.Direccion_Usuario,l.Nombre_Municipio 
            FROM pedidos p 
            JOIN usuarios u ON u.Id_Usuario = p.Id_Usuario 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento =  l.Id_Departamento
            JOIN detalle_pedidos dp ON dp.Id_Pedido = p.Id_Pedido 
            JOIN productos pd ON pd.Id_Producto = dp.Id_Producto 
            JOIN envios en ON en.Id_Pedido = p.Id_Pedido
			JOIN pagos pg ON pg.Id_Pago = en.Id_Pago
            WHERE p.Estado_Pedido = '$searchState'
            AND l.Nombre_Municipio = '$searchCiudad'
            AND dep.Nombre_Departamento = '$searchDepartment'
            GROUP BY p.Id_Pedido";

            $this->sqlProductPedidos ="SELECT pd.Nombre_Producto,pd.Imagen_Producto,pd.Id_Producto,dp.Cantidad_Producto
            ,dp.Precio_Producto,p.Id_Pedido
            FROM productos pd
            JOIN detalle_pedidos dp ON pd.Id_Producto = dp.Id_Producto
            JOIN pedidos p ON p.Id_Pedido = dp.Id_Pedido
            JOIN usuarios u  ON u.Id_Usuario = p.Id_Usuario
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento = l.Id_Departamento
            WHERE p.Estado_Pedido = '$searchState'
            AND l.Nombre_Municipio = '$searchCiudad'
            AND dep.Nombre_Departamento = '$searchDepartment'";
        
        //FILTRO POR CIUDAD Y DEPARTAMENTO 
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && empty($searchState)){

            $sql = "SELECT DISTINCT p.Id_Pedido,p.Estado_Pedido,p.Fecha_Pedido, 
            sum(dp.Cantidad_Producto) as cantidad_productos ,p.Valor_Total,en.Fecha_Entrega,pg.Tipo_Pago ,
             u.Nombre_Usuario,u.Apellidos_Usuario,u.Id_Usuario ,u.Direccion_Usuario,l.Nombre_Municipio 
            FROM pedidos p 
            JOIN usuarios u ON u.Id_Usuario = p.Id_Usuario 
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento =  l.Id_Departamento
            JOIN detalle_pedidos dp ON dp.Id_Pedido = p.Id_Pedido 
            JOIN productos pd ON pd.Id_Producto = dp.Id_Producto 
            JOIN envios en ON en.Id_Pedido = p.Id_Pedido
			JOIN pagos pg ON pg.Id_Pago = en.Id_Pago
            WHERE l.Nombre_Municipio = '$searchCiudad'
            AND dep.Nombre_Departamento = '$searchDepartment'
            GROUP BY p.Id_Pedido";

            $this->sqlProductPedidos ="SELECT pd.Nombre_Producto,pd.Imagen_Producto,pd.Id_Producto,dp.Cantidad_Producto
            ,dp.Precio_Producto,p.Id_Pedido
            FROM productos pd
            JOIN detalle_pedidos dp ON pd.Id_Producto = dp.Id_Producto
            JOIN pedidos p ON p.Id_Pedido = dp.Id_Pedido
            JOIN usuarios u  ON u.Id_Usuario = p.Id_Usuario
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento = l.Id_Departamento
            WHERE l.Nombre_Municipio = '$searchCiudad'
            AND dep.Nombre_Departamento = '$searchDepartment'";
        
        //FILTRO POR ESTADO
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)
        && !empty($searchState)){

            $sql = "SELECT DISTINCT p.Id_Pedido,p.Estado_Pedido,p.Fecha_Pedido, 
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
            WHERE p.Estado_Pedido = '$searchState'
            GROUP BY p.Id_Pedido";

                

            $this->sqlProductPedidos ="SELECT pd.Nombre_Producto,pd.Imagen_Producto,pd.Id_Producto,dp.Cantidad_Producto
            ,dp.Precio_Producto,p.Id_Pedido
            FROM productos pd
            JOIN detalle_pedidos dp ON pd.Id_Producto = dp.Id_Producto
            JOIN pedidos p ON p.Id_Pedido = dp.Id_Pedido
            JOIN usuarios u  ON u.Id_Usuario = p.Id_Usuario
            JOIN localidad l ON l.Id_localidad = u.Id_localidad
            JOIN departamentos dep ON dep.Id_Departamento = l.Id_Departamento
            WHERE p.Estado_Pedido = '$searchState'";

        
        }
        return $sql;
    }
    public function verifiedParamEnvios($searchNameUser,$searchApellido,$searchCiudad,$searchDepartment,$searchDate){
        
        $sql="";
        //FILTRO POR TODO
        if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && !empty($searchDate)){

            $sql = "SELECT e.Id_Envio,e.Cobertura,e.Fecha_Entrega
			,e.Id_Pedido,p.Tipo_Pago,pd.Valor_Total,u.Nombre_Usuario,u.Apellidos_Usuario
				FROM envios e 
				JOIN pedidos pd ON pd.Id_Pedido = e.Id_Pedido
				JOIN usuarios u ON u.Id_Usuario = pd.Id_Usuario
                JOIN localidad l ON l.Id_localidad = u.Id_localidad
                JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
				JOIN pagos p ON e.Id_Pago = p.Id_Pago
                WHERE e.Fecha_Entrega = '$searchDate'
           		AND u.Nombre_Usuario LIKE '$searchNameUser%'
            	AND u.Apellidos_Usuario LIKE '$searchApellido%'
            	AND l.Nombre_Municipio = '$searchCiudad'
            	AND dp.Nombre_Departamento = '$searchDepartment'";


          

        //FILTRO POR NOMBRE, APELLIDO, CIUDAD Y DEPARTAMENTO   
        }else if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && empty($searchDate)){

            $sql = "SELECT e.Id_Envio,e.Cobertura,e.Fecha_Entrega
			,e.Id_Pedido,p.Tipo_Pago,pd.Valor_Total,u.Nombre_Usuario,u.Apellidos_Usuario
				FROM envios e 
				JOIN pedidos pd ON pd.Id_Pedido = e.Id_Pedido
				JOIN usuarios u ON u.Id_Usuario = pd.Id_Usuario
                JOIN localidad l ON l.Id_localidad = u.Id_localidad
                JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
				JOIN pagos p ON e.Id_Pago = p.Id_Pago
                WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            	AND u.Apellidos_Usuario LIKE '$searchApellido%'
            	AND l.Nombre_Municipio = '$searchCiudad'
            	AND dp.Nombre_Departamento = '$searchDepartment'";


            
        
             //FILTRO POR NOMBRE , APELLIDO Y CIUDAD 
        }else if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && empty($searchDepartment)
        && empty($searchDate)){

            $sql = "SELECT e.Id_Envio,e.Cobertura,e.Fecha_Entrega
			,e.Id_Pedido,p.Tipo_Pago,pd.Valor_Total,u.Nombre_Usuario,u.Apellidos_Usuario
				FROM envios e 
				JOIN pedidos pd ON pd.Id_Pedido = e.Id_Pedido
				JOIN usuarios u ON u.Id_Usuario = pd.Id_Usuario
                JOIN localidad l ON l.Id_localidad = u.Id_localidad
                JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
				JOIN pagos p ON e.Id_Pago = p.Id_Pago
                WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            	AND u.Apellidos_Usuario LIKE '$searchApellido%'
            	AND l.Nombre_Municipio = '$searchCiudad'";

        

             //FILTRO POR NOMBRE Y APELLIDO 
        }else if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)
        && empty($searchDate)){
          
            $sql = "SELECT e.Id_Envio,e.Cobertura,e.Fecha_Entrega
			,e.Id_Pedido,p.Tipo_Pago,pd.Valor_Total,u.Nombre_Usuario,u.Apellidos_Usuario
				FROM envios e 
				JOIN pedidos pd ON pd.Id_Pedido = e.Id_Pedido
				JOIN usuarios u ON u.Id_Usuario = pd.Id_Usuario
                JOIN localidad l ON l.Id_localidad = u.Id_localidad
                JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
				JOIN pagos p ON e.Id_Pago = p.Id_Pago
                WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            	AND u.Apellidos_Usuario LIKE '$searchApellido%'";


        

            //FILTRO POR NOMBRE
        }else if(!empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)
        && empty($searchDate)){

            $sql = "SELECT e.Id_Envio,e.Cobertura,e.Fecha_Entrega
			,e.Id_Pedido,p.Tipo_Pago,pd.Valor_Total,u.Nombre_Usuario,u.Apellidos_Usuario
				FROM envios e 
				JOIN pedidos pd ON pd.Id_Pedido = e.Id_Pedido
				JOIN usuarios u ON u.Id_Usuario = pd.Id_Usuario
                JOIN localidad l ON l.Id_localidad = u.Id_localidad
                JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
				JOIN pagos p ON e.Id_Pago = p.Id_Pago
                WHERE u.Nombre_Usuario LIKE '$searchNameUser%'";

         //FILTRO POR APELLIDO, CIUDAD,DEPARTAMENTO Y FECHA
        }else if(empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && !empty($searchDate)){
            $sql = "SELECT e.Id_Envio,e.Cobertura,e.Fecha_Entrega
			,e.Id_Pedido,p.Tipo_Pago,pd.Valor_Total,u.Nombre_Usuario,u.Apellidos_Usuario
				FROM envios e 
				JOIN pedidos pd ON pd.Id_Pedido = e.Id_Pedido
				JOIN usuarios u ON u.Id_Usuario = pd.Id_Usuario
                JOIN localidad l ON l.Id_localidad = u.Id_localidad
                JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
				JOIN pagos p ON e.Id_Pago = p.Id_Pago
                WHERE e.Fecha_Entrega = '$searchDate'
           		AND u.Apellidos_Usuario LIKE '$searchApellido%'
            	AND l.Nombre_Municipio = '$searchCiudad'
            	AND dp.Nombre_Departamento = '$searchDepartment'";

           
        
        //FILTRO POR CIUDAD, DEPARTAMENTO,FECHA 
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && !empty($searchDate)){

            $sql = "SELECT e.Id_Envio,e.Cobertura,e.Fecha_Entrega
			,e.Id_Pedido,p.Tipo_Pago,pd.Valor_Total,u.Nombre_Usuario,u.Apellidos_Usuario
				FROM envios e 
				JOIN pedidos pd ON pd.Id_Pedido = e.Id_Pedido
				JOIN usuarios u ON u.Id_Usuario = pd.Id_Usuario
                JOIN localidad l ON l.Id_localidad = u.Id_localidad
                JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
				JOIN pagos p ON e.Id_Pago = p.Id_Pago
                WHERE e.Fecha_Entrega = '$searchDate'
            	AND l.Nombre_Municipio = '$searchCiudad'
            	AND dp.Nombre_Departamento = '$searchDepartment'";

     
        
        //FILTRO POR CIUDAD Y DEPARTAMENTO 
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)
        && empty($searchDate)){

            $sql = "SELECT e.Id_Envio,e.Cobertura,e.Fecha_Entrega
			,e.Id_Pedido,p.Tipo_Pago,pd.Valor_Total,u.Nombre_Usuario,u.Apellidos_Usuario
				FROM envios e 
				JOIN pedidos pd ON pd.Id_Pedido = e.Id_Pedido
				JOIN usuarios u ON u.Id_Usuario = pd.Id_Usuario
                JOIN localidad l ON l.Id_localidad = u.Id_localidad
                JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
				JOIN pagos p ON e.Id_Pago = p.Id_Pago
                WHERE l.Nombre_Municipio = '$searchCiudad'
            	AND dp.Nombre_Departamento = '$searchDepartment'";

        
        
        //FILTRO POR FECHA
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)
        && !empty($searchDate)){

            $sql = "SELECT e.Id_Envio,e.Cobertura,e.Fecha_Entrega
			,e.Id_Pedido,p.Tipo_Pago,pd.Valor_Total,u.Nombre_Usuario,u.Apellidos_Usuario
				FROM envios e 
				JOIN pedidos pd ON pd.Id_Pedido = e.Id_Pedido
				JOIN usuarios u ON u.Id_Usuario = pd.Id_Usuario
                JOIN localidad l ON l.Id_localidad = u.Id_localidad
                JOIN departamentos dp ON dp.Id_Departamento = l.Id_Departamento
				JOIN pagos p ON e.Id_Pago = p.Id_Pago
                WHERE e.Fecha_Entrega = '$searchDate'";

           

        
        }
        return $sql;

    }
    public function verifiedParamComentarios($searchNameUser,$searchApellido,$searchDate){

        $sql="";
        //FILTRO POR TODO
        if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchDate)){

            $sql = "SELECT C.*,P.Nombre_Producto,P.Marca_Producto,U.Nombre_Usuario,U.Apellidos_Usuario FROM comentarios c 
            JOIN usuarios u ON c.Id_Usuario = u.Id_Usuario
            JOIN productos p ON p.Id_Producto = c.Id_Producto
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'
            AND c.Fecha_Comentario = '$searchDate'";


          

        //FILTRO POR NOMBRE, APELLIDO 
        }else if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && empty($searchDate)){

            $sql = "SELECT C.*,P.Nombre_Producto,P.Marca_Producto,U.Nombre_Usuario,U.Apellidos_Usuario FROM comentarios c 
            JOIN usuarios u ON c.Id_Usuario = u.Id_Usuario
            JOIN productos p ON p.Id_Producto = c.Id_Producto
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'";


        //FILTRO POR NOMBRE  
        }else if(!empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchDate)){

            $sql = "SELECT C.*,P.Nombre_Producto,P.Marca_Producto,U.Nombre_Usuario,U.Apellidos_Usuario FROM comentarios c 
            JOIN usuarios u ON c.Id_Usuario = u.Id_Usuario
            JOIN productos p ON p.Id_Producto = c.Id_Producto
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'";


        //FILTRO POR FECHA
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && !empty($searchDate)){
            $sql = "SELECT C.*,P.Nombre_Producto,P.Marca_Producto,U.Nombre_Usuario,U.Apellidos_Usuario FROM comentarios c 
            JOIN usuarios u ON c.Id_Usuario = u.Id_Usuario
            JOIN productos p ON p.Id_Producto = c.Id_Producto
            WHERE c.Fecha_Comentario = '$searchDate'";
        }

        return $sql;
    }

    public function verifiedParamLogin($seachEmail,$searchPass){
        $sql = "";
        if(!empty($seachEmail)
        && !empty($searchPass)){

                $sql="SELECT u.*,p.Rol_Permiso,d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
                JOIN roles r ON r.Id_Usuario = u.Id_Usuario
                JOIN permisos p ON p.Id_Permiso = r.Id_Permiso
                JOIN localidad l ON u.Id_localidad = l.Id_localidad
                JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
                WHERE u.Email_Usuario = '$seachEmail'
                ORDER BY p.Id_Permiso DESC
                LIMIT 1";
                
        }

        return $sql;
    }

    public function verifiedParamProductProveedors(){
        return $this->sqlProductProveedor;
    }
    public function verifiedParamProductPedidos(){
        return $this->sqlProductPedidos;
    }
    
}
