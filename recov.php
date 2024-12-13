<?php
if(isset($_GET['inte'])){
    $mysqli = new mysqli('localhost','root','', 'practicaphp');

    if(mysqli_connect_errno()) {
        echo $mysqli->connect_error;
        exit;
    }

    $q_check = "SELECT * from principal WHERE 1";

    $r1 = $mysqli->execute_query($q_check);
    $si_es = "";
        while ($row2 = $r1->fetch_assoc()) {
            if(hash('md5',$row2["correu"] . "7") == $_GET['inte']){
                $si_es = $row2["correu"];
            }
        }

        if($si_es != ""){
            echo '<form method="POST" action=""> 
            <p> Indica la teva nova contrasenya </p>
            <input type="text" name="novaC" placeholder="Nova contrasenya...."><br>
            <input type="text" name="repeC" placeholder="Repeteix la contrasenya...">
            <br>
            <input type="submit" value="Enviar" name="enviar">

            
            </form>';
        }else{
            echo "<br>El teu correu no esta registrat a la nostra base de dades";
            echo '<form method="POST" action=""> <input type="submit" name="ok" value="OK"></form>';
        }

        if(isset($_POST['ok'])){
            header('Location: index.php');
            exit;
        }
        if(isset($_POST['enviar'])){
            if(isset($_POST['novaC']) && isset($_POST['repeC'])){
                if($_POST['novaC'] != "" && $_POST['repeC'] != ""){
                    $mysqli = new mysqli('localhost','root','', 'practicaphp');

                    $q_contra = 'UPDATE principal SET password = ? WHERE correu = ?';

                    $mysqli->execute_query($q_contra,array($_POST['novaC'],$si_es));

                    echo '<h1 align="center" style="color:white;background-color:darkgreen;width:50%;position:relative;left:25%;">Actualitzacio realitzada amb exit</h1>';
                }else{
                    echo 'La contrasenya no pot estar buida';
                }
            }else{
                echo 'La contrasenya no pot estar buida (2)';
            }
        }
    

}


?>
