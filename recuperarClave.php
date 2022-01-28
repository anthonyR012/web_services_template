

<?php
include_once('Conexion.php');
include_once('class/SecurityPassClass.php');

header('Access-Control-Allow-Origin: *');
$case = $_POST["case"];
$json = array();
$item = array();

$objConectar = new Conectar();
$conDb = $objConectar->getConnection();

// $entityBody = json_decode(file_get_contents('php://input'), true);

switch ($case) {
    
    case 'claveTemporal':
        // Please specify your Mail Server - Example: mail.example.com.
    ini_set("SMTP","mail.gmail.com");

    // Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
    ini_set("smtp_port","25");

    // Please specify the return address to use
    ini_set('sendmail_from', 'rubionn27@gmail.com');

        //Generando clave aleatoria
        $logitudPass = 5;
        $miPassword  = substr( md5(microtime()), 1, $logitudPass);
        $clave       = $miPassword;

        $correo             = trim($_REQUEST['email']); //Quitamos algun espacion en blanco
       
        $consulta    = ("SELECT * FROM usuarios WHERE Email_Usuario ='".$correo."'");
        
        $result = $conDb->prepare($consulta);

    
        if(!$result->execute()){     
            $item = array("response"=>"no found user");
        }else{
      
        $dataConsulta = $result ->fetch(PDO::FETCH_ASSOC);
        $hash = new SecurityPassClass($clave);
		$getHash = $hash->hash();

        $updateClave    = ("UPDATE usuarios SET Password_Usuario='$getHash' WHERE Email_Usuario='".$correo."' ");
        $queryResult    = mysqli_query($con,$updateClave); 
      
        $destinatario = $correo; 
        $asunto       = "Recuperando Clave - Tienda Online";
        $cuerpo = '
            <!DOCTYPE html>
            <html lang="es">
            <head>
            <title>Recuperar Clave de Usuario</title>';
            
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
            .btnlink{
                padding:15px 30px;
                text-align:center;
                background-color:#cecece;
                color: crimson !important;
                font-weight: 600;
                text-decoration: blue;
            }
            .btnlink:hover{
                color: #fff !important;
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
                margin: 4% 10% 2%;
                text-align: center;
                font-family: sans-serif;
            }
            .mt-5{
                margin-top:50px;
            }
            .mb-5{
                margin-bottom:50px;
            }
            </style>
        ';

        $cuerpo .= '
        </head>
        <body>
            <div class="contenedor">
            <h1>Recuperación de cuenta Tienda Online</h1>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            <table style="max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;">
        
            
            <tr>
                <td style="background-color: #ffffff;">
                    <div class="misection">
                        <h2 style="color: red; margin: 0 0 7px">Hola, '.$dataConsulta['Nombre_Usuario'].' '.$dataConsulta['Apellidos_Usuario'] .'</h2>
                        <p style="margin: 2px; font-size: 18px">Te hemos creado una nueva clave temporal para que puedas iniciar sesión, la clave temporal es: <strong>'.$clave.'</strong> </p>
                        <p>&nbsp;</p>
                        <p>Ingresa y modificala para que sigas disfrutando de nuestros servicios</p>
                        <p>&nbsp;</p>                
                        <p>&nbsp;</p>               
                    </div>
                </td>
            </tr>

        
        </table>'; 

        $cuerpo .= '
            </div>
            </body>
        </html>';
            
            $headers  = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
            $headers .= "From: WebDeveloper\r\n"; 
            $headers .= "Reply-To: "; 
            $headers .= "Return-path:"; 
            $headers .= "Cc:"; 
            $headers .= "Bcc:"; 
            (mail($destinatario,$asunto,$cuerpo,$headers));

            

            $item = array("response"=>"change complete");
           
        }

        $json[]=$item;
            break;
}


if (!empty($json)) {
	echo json_encode($json);
} else {
	echo json_encode(array("response" => "Error","Code 001"=>"No found param"));
}


?>


