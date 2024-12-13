<?php
// Exemple: http://localhost/m7/Practica/enviarcorreu.php?clau=6a98a2da2fc54165c5396fababfe61cc.php

// Si rebem una clau per GET, aleshores...
    if(isset($_GET['clau'])){
        
        echo 'A qui li vols enviar el correu';
        echo '<form method="POST" action=""><input type="text" name="correu" placeholder="Introdueix un correu"><br><input type="submit" name="enviar" value="Enviar"></form>';
    }else{
        echo 'Donete';
    }
?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['enviar'])){

    require './PHPMailer-master/src/Exception.php';
    require './PHPMailer-master/src/PHPMailer.php';
    require './PHPMailer-master/src/SMTP.php';


    $correu = $_POST['correu'];

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->CharSet="UTF-8";
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = 'fsanchis@milaifontanals.org';
    $mail->Password = 'wabm cypk xebe bxtd';
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 0;
    
    $mail->SetFrom = 'fsanchis@milaifontanals.org';
    $mail->FromName = 'Practiques PHP';
    $mail->AddAddress("$correu"); //correu del client
    
    $mail->IsHTML(true);
    $mail->Subject = "Et convido a provar una de les meves claus!";
    $mail->AltBody = "Test Text Plain";
    $mail->Body = "Clica en aquest link per a poder registrar-te! http://127.0.0.1/m7/Practica/register.php?clau=" . $_GET['clau'];
    
    if(!$mail->Send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }else{
        echo '<h1 style="color:green;">Correu enviat ✔</h1>';
    }
}
?>