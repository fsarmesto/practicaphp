<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['sb'])){

    require './PHPMailer-master/src/Exception.php';
    require './PHPMailer-master/src/PHPMailer.php';
    require './PHPMailer-master/src/SMTP.php';

    

    $correu = $_POST['correu'];

    $missatge_final = hash('md5', $correu . "16");

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
    $mail->FromName = 'Practiques PHP - RMP';
    $mail->AddAddress("$correu"); //correu del client
    
    $mail->IsHTML(true);
    $mail->Subject = "Recuperacio de contrasenyes";
    $mail->AltBody = "Test Text Plain";
    $mail->Body = "Clica en aquest link per a poder recuperar la teva contrasenya: http://127.0.0.1/m7/Practica/recov.php?inte=" . $missatge_final;
    
    if(!$mail->Send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }else{
        echo '<h1 style="color:green;">Correu enviat ✔</h1>';
    }
}
?>

<html>
    <body>
        <form method="POST" action="">
            <input type="text" name="correu" placeholder="Indica el teu correu">
            <input type="submit" name="sb" value="Enviar correu">
        </form>
    </body>
</html>