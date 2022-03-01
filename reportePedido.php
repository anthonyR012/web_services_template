

<?php
include_once('Conexion.php');
include_once('class/SecurityPassClass.php');

header('Access-Control-Allow-Origin: *');
$case = $_GET["case"];
$json = array();
$item = array();

$objConectar = new Conectar();
$conDb = $objConectar->getConnection();

// $entityBody = json_decode(file_get_contents('php://input'), true);

switch ($case) {
    
    case "reportePedido":
        // Please specify your Mail Server - Example: mail.example.com.
    ini_set("SMTP","mail.gmail.com");

    // Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
    ini_set("smtp_port","25");

    // Please specify the return address to use
    ini_set('sendmail_from', 'rubionn27@gmail.com');

     
        if(!empty($_GET["arrayProductos"])
        && !empty($_GET["Valor_Total"])		
	    && !empty($_GET["Id_Usuario"])){

            $idUsiario = $_GET["Id_Usuario"];                
            $cons="SELECT Nombre_Usuario, Apellidos_Usuario, Email_Usuario FROM usuarios WHERE Id_Usuario= $idUsiario";    
            $resId_User = $conDb->prepare($cons);
            $resId_User->execute();            
            while($row = $resId_User ->fetch(PDO::FETCH_ASSOC)){
                $NombreUser = $row["Nombre_Usuario"];
                $ApellidoUser = $row["Apellidos_Usuario"];
                $EmailUser = $row["Email_Usuario"];    
                }

                $destinatario = $EmailUser; 

            $valorCompra = $_GET["Valor_Total"];           
			$datosProduct = $_GET["arrayProductos"];
            $datosProductDeco = json_decode($datosProduct, true);

            
        $asunto       = "Reporte de Compra";
        $cuerpo = '
            <!DOCTYPE html>
            <html lang="es">
            <head>
            <title>Reporte de Compra</title>';
            
        $cuerpo .= ' 
        <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body {
    font-family: "Roboto", sans-serif;
    font-size: 16px;
    font-weight: 300;
    color: #888;
    background-color:rgba(230, 225, 225, 0.5);
    line-height: 30px;
    text-align: center;
}
.contenedor{
    width: 80%;
    min-height:auto;
    text-align: center;
    margin: 0 auto;
    background: #ececec;
    border-top: 3px solid #E64A19;
}
.table{
    --bs-table-bg: transparent;
    --bs-table-accent-bg: transparent;
    --bs-table-striped-color: #212529;
    --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
    --bs-table-active-color: #212529;
    --bs-table-active-bg: rgba(0, 0, 0, 0.1);
    --bs-table-hover-color: #212529;
    --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
    vertical-align: top;
    border-color: #dee2e6;
}
.table-striped>tbody>tr:nth-of-type(odd)>* {
    --bs-table-accent-bg: var(--bs-table-striped-bg);
    color: var(--bs-table-striped-color);
}
.table>:not(caption)>*>* {
    padding: 0.5rem 0.5rem;
    background-color: var(--bs-table-bg);
    border-bottom-width: 1px;
    box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
}
.table-responsive{
    overflow: auto;
    padding-bottom: 10px;
}
.tbody, td, tfoot, th, thead, tr {
    border-color: inherit;
    border-style: solid;
    border-width: 0;
}
.thead{
    vertical-align: bottom;
}
.tr{
    display: table-row;
    position: relative;
}
.th{
    padding: 12px 7px;
    vertical-align: middle;
}


.btnlink{
    padding:15px 30px;
    text-align:center;
    background-color:#cecece;
    color: crimson !important;
    font-weight: 600;
    text-decoration: blue;
}

.imgBanner{
    width:100%;
    margin-left: auto;
    margin-right: auto;
    display: block;
    padding:0px;
}
.misection{
    color: #34495e;
    margin: 2.5%;
    text-align: center;
    font-family: sans-serif;
    width: 95%;
}
.mt-5{
    margin-top:50px;
}
.mb-5{
    margin-bottom:50px;
}
.headerCss{
    background-color: #E1A932;
}

.title{
    margin: 15px;
    font-family: fantasy;
    padding: 20px;

}
.lista{
    font-size: 18px;
    margin-top: 15px;
}
</style>
';

        $cuerpo .= '
        </head>
        <body>
            <div class="contenedor">
            <div class="headerCss">
            <h1 class="title">Buyme Ecommerce</h1>
            
            </div style = "background:#F0D9A8">

        <table style="width: 100%; padding: 10px; margin:0 auto; border-collapse: collapse;">
                          
            <tr>
                <td style="background-color: #ffffff;">
                    <div class="misection">
                        <h2 style="margin: 0 0 7px">Hola, '.$NombreUser.' '.$ApellidoUser.'</h2>
                        <p style="margin: 2px; font-size: 18px"> A continuación el reporte de tu compra.</p>
                        
                        <p>Ingresa y modificala para que sigas disfrutando de nuestros servicios</p>                    
                                     
                    </div>
                </td>
            </tr>        
        </table>
        
        <br>

        <div class="table-responsive">
        <table class="table table-striped">
                <thead>
                <tr>
                    <th></th> 
                    <th scope="col">Producto</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Cant</th>
                    <th scope="col">Total</th>
                    <th scope="col"></th>
                </tr>
                </thead>

                <tbody id="tablet">';
        
        foreach ($datosProductDeco as $row) {
            $titulo = $row['titulo'];				
            $cantidadProducto = $row['cantidad'];				
            $precioProducto = $row['precio'];                
            $TotalProducto = $row['precio']*$row['cantidad'];
            $ImaProducto = $row['imagen'];
                                                                 
        $cuerpo .= '        
                <th scope="row" style="min-width: 50px"><img src="'.$ImaProducto.'" width="50px" height="50px" alt=""></th>
                              <th scope="row"><small>'.$titulo.'</small></th>
                              <th scope="row"><small>$'.number_format($precioProducto, 2).'</small></th>
                              <th scope="row"><small>'.$cantidadProducto.'</small></th>
                              <th scope="row"><small>$'.number_format($TotalProducto, 2).'</small></th>                                  
                </tr>';
            }/*Final foreach*/

        $cuerpo .= '        </tbody>
            
        </table>                                                                
        </div>  
        
        <p>Gracias por confiar en nosotros.</p>                    
        <p>&nbsp;</p>     
        
        '; 
        $cuerpo .= '
            </div>
            </body>
        </html>';

        
                
            
            $headers  = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
            $headers .= "From: BUUME!\r\n"; 
            $headers .= "Reply-To: "; 
            $headers .= "Return-path:"; 
            $headers .= "Cc:"; 
            $headers .= "Bcc:"; 
            (mail($destinatario,$asunto,$cuerpo,$headers));


     

            $item = array("response"=>"Reporte enviado");
           
        }
/*echo $cuerpo;*/

        $json[]=$item;
            break;
}


if (!empty($json)) {
	echo json_encode($json);
} else {
	echo json_encode(array("response" => "Error","Code 001"=>"No found param"));
}


?>


