<?php

    $mysqli = new mysqli('localhost','root','', 'practicaphp');

    $q_inici = "SELECT * from principal where clau = ?;";

    $r_inici = $mysqli->execute_query($q_inici,array($_GET['clau']));

    $prova_inici = $r_inici->fetch_assoc();
    if($prova_inici['acceptada'] != null){
        header('Location: error.php?missatge=' . urlencode('CLAU JA AGAFADA'));
        exit;
    }



    if(isset($_POST['send'])){
        if(isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['mail'])){
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            $mail = $_POST['mail'];

            if($user != '' && $pass != '' && $mail != ''){
                $config = include 'config.php';

                if(mysqli_connect_errno()) {
                    echo $mysqli->connect_error;
                    exit;
                }

                $q_id = 'SELECT count(*) as total FROM `principal` WHERE usuari=? AND password=?;';

                $r1 = $mysqli->execute_query($q_id,array($user,$pass));

                $busqueda = $r1->fetch_assoc();
                
                if($busqueda['total'] >= 1){
                    echo "L'usuari {$user} ja existeix";
                }else{
                    $clau = $_GET['clau'];
                    //$result = explode('.', $clau);
                    $q_agafar = 'UPDATE principal set usuari = ?, password = ?, estat = "trial", acceptada = true, correu = ? WHERE clau = "' . $clau . '"';

                    $mysqli->execute_query($q_agafar,array($user,$pass,$mail));

                    $q_comprovar = "SELECT count(*) as 'quants' FROM principal WHERE id_pare = ?";
                    $r2 = $mysqli->execute_query($q_comprovar,array($_GET['clau']));

                    $actualitzar = $r2->fetch_assoc();
                }

                header('Location: error.php?missatge=' . urlencode("CLAU ACCEPTADA CORRECTAMENT"));
               // echo "<p> {$user} asd {$pass} and {$mail} </p>";

            }else{
                echo "Si us plau, emplena les dades";
            }
        }
    }
?>


<html>
    <head>

    </head>

    <body>
        <form method="POST" action="">
            <p>Usuario:</p>
            <input type="text" name="user" placeholder="...">
            <p>Contraseña:</p>
            <input type="password" name="pass" placeholder="..."><br>
            <p>Correu:</p>
            <input type="text" name="mail" placeholder="..."><br>
            <input type="submit" name="send">
        </form>
    </body>
</html>