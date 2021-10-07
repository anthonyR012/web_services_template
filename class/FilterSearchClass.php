<?php
include_once('SecurityPassClass.php');
class FilterSearchClass{
    private $sqlProductProveedor;

    public function verifiedParamProduct($searchName,$searchPriceMenor,
    $searchPriceMayor,$searchCategory,$searchBrand){

        $sql = "";
        //FILTRO POR TODOS
        if(!empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)){
            
            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
                JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
                WHERE p.Nombre_Producto like '$searchName%'
                AND p.Marca_Producto like '$searchBrand%'
                AND p.Precio_Producto BETWEEN $searchPriceMenor AND $searchPriceMayor
                AND c.Nombre_Categoria like '$searchCategory%'";

        //FILTRO POR TODOS EXCEPTO MARCA
        }else if(!empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && empty($searchBrand)){

            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Nombre_Producto like '$searchName%'
            AND p.Precio_Producto BETWEEN $searchPriceMenor AND $searchPriceMayor
            AND c.Nombre_Categoria like '$searchCategory%'";
        //FILTRO TODO EXCEPTO MARCA Y CATEGORIA
        }else if(!empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && empty($searchCategory) 
        && empty($searchBrand)){

            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Nombre_Producto like '$searchName%'
            AND p.Precio_Producto BETWEEN $searchPriceMenor AND $searchPriceMayor";
         //FILTRO TODO EXCEPTO MARCA,CATEGORIA Y PRECIO MAYOR
        }else if(!empty($searchName) 
            && !empty($searchPriceMenor) 
            && empty($searchPriceMayor) 
            && empty($searchCategory) 
            && empty($searchBrand)){

                $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
                JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
                WHERE p.Nombre_Producto like '$searchName%'
                AND p.Precio_Producto > $searchPriceMenor";


             //FILTRO POR NOMBRE PRODUCTO
        }else if(!empty($searchName) 
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && empty($searchCategory) 
        && empty($searchBrand)){

            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Nombre_Producto like '$searchName%'";

            //FILTRO POR TODO EXCEPTO NOMBRE
        }else if(empty($searchName) 
        && !empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)){

            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Marca_Producto like '$searchBrand%'
            AND p.Precio_Producto BETWEEN $searchPriceMenor AND $searchPriceMayor
            AND c.Nombre_Categoria like '$searchCategory%'";

            //FILTRO POR TODO EXCEPTO NOMBRE Y PRECIO MENOR
        }else if(empty($searchName) 
        && empty($searchPriceMenor) 
        && !empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)){
            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Marca_Producto like '$searchBrand%'
            AND p.Precio_Producto < $searchPriceMayor
            AND c.Nombre_Categoria like '$searchCategory%'";
        
        //FILTRO POR TODO EXCEPTO NOMBRE,PRECIO MENOR Y PRECIO MAYOR
        }else if(empty($searchName) 
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && !empty($searchBrand)){
            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Marca_Producto like '$searchBrand%'
            AND c.Nombre_Categoria like '$searchCategory%'";


        //FILTRO POR MARCA
        }else if(empty($searchName)
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && empty($searchCategory) 
        && !empty($searchBrand)){

            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE p.Marca_Producto like '$searchBrand%'";

        //FILTRO POR CATEGORIA
        }else if(empty($searchName)
        && empty($searchPriceMenor) 
        && empty($searchPriceMayor) 
        && !empty($searchCategory) 
        && empty($searchBrand)){

            $sql = "SELECT p.*,c.Nombre_Categoria FROM productos p
            JOIN categorias_productos c ON p.Id_Categoria = c.Id_Categoria
            WHERE c.Nombre_Categoria like '$searchCategory%'";

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
        
        }

        return $sql;

    }

    public function verifiedParamUsers($searchNameUser,$searchApellido,$searchCiudad,$searchDepartment){
        $sql="";
        //FILTRO POR NOMBRE, APELLIDO, CIUDAD Y DEPARTAMENTO
        if(!empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)){
            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_Municipio
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
			JOIN localidad l ON u.Id_localidad = l.Id_Municipio
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
			JOIN localidad l ON u.Id_localidad = l.Id_Municipio
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'
            AND u.Apellidos_Usuario LIKE '$searchApellido%'";

             //FILTRO POR NOMBRE  
        }else if(!empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)){
          
            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_Municipio
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE u.Nombre_Usuario LIKE '$searchNameUser%'";

            //FILTRO POR DEPARTAMENTO, CIUDAD Y APELLIDO
        }else if(empty($searchNameUser) 
        && !empty($searchApellido) 
        && !empty($searchCiudad) 
        && !empty($searchDepartment)){

            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_Municipio
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
			JOIN localidad l ON u.Id_localidad = l.Id_Municipio
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE l.Nombre_Municipio LIKE '$searchCiudad%'
            AND d.Nombre_Departamento LIKE '$searchDepartment%'";
        
        //FILTRO POR DEPARTAMENTO 
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && empty($searchCiudad) 
        && !empty($searchDepartment)){

            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_Municipio
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE d.Nombre_Departamento LIKE '$searchDepartment%'";
        
        //FILTRO POR CIUDAD 
        }else if(empty($searchNameUser) 
        && empty($searchApellido) 
        && !empty($searchCiudad) 
        && empty($searchDepartment)){

            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_Municipio
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE l.Nombre_Municipio LIKE '$searchCiudad%'";
        
        //FILTRO POR APELLIDO
        }else if(empty($searchNameUser) 
        && !empty($searchApellido) 
        && empty($searchCiudad) 
        && empty($searchDepartment)){

            $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
			JOIN localidad l ON u.Id_localidad = l.Id_Municipio
			JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
            WHERE u.Apellidos_Usuario LIKE '$searchApellido%'";

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

  
    public function verifiedParamLogin($seachEmail,$searchPass){
        $sql = "";
        if(!empty($seachEmail)
        && !empty($searchPass)){

                $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
                JOIN localidad l ON u.Id_localidad = l.Id_Municipio
                JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
                WHERE u.Email_Usuario = '$seachEmail'";
                
        }

        return $sql;
    }

    public function verifiedParamProductProveedors(){
        return $this->sqlProductProveedor;
    }


}
