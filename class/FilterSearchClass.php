<?php
include_once('SecurityPassClass.php');
class FilterSearchClass{

    public function verifiedParamProduct($searchName,$searchPriceMenor,
    $searchPriceMayor,$searchCategory,$searchBrand){
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

    public function verifiedParamLogin($seachEmail,$searchPass){
        
        if(!empty($seachEmail)
        && !empty($searchPass)){

                $sql="SELECT u.*, d.Nombre_Departamento , l.Nombre_Municipio FROM usuarios u
                JOIN localidad l ON u.Id_localidad = l.Id_Municipio
                JOIN departamentos d ON l.Id_Departamento = d.Id_Departamento
                WHERE u.Email_Usuario = '$seachEmail'";
                $this->stateLogin = true;
                
        }else{
            $sql=null;
        }
        return $sql;
    }
    public function getState(){
        return $this->stateLogin;
    }  


}

?>
