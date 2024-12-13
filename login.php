<?php

    session_start();
    $config = include 'config.php';

    $mysqli = new mysqli('localhost','root','', 'practicaphp');

    if(mysqli_connect_errno()) {
        echo $mysqli->connect_error;
        exit;
    }

    if(!($_SESSION['login'] == 1)){
        echo "ERROR. SESSIO NO INICIADA.";
        exit;
    }

    $q_id = 'SELECT * FROM principal where usuari=?';

    $r1 = $mysqli->execute_query($q_id,array($_SESSION['user']));

    if($r1){
        $row = $r1->fetch_assoc();
        if($row){
            if($row['clau'] != null){
                echo 'La teva clau es ' . $row['clau'] . ' i es de caracter ';
                echo ($row['estat'] != null) ? $row['estat'] : ' SENSE ESTAT ';

                if($row['estat'] == 'trial'){
                    echo '<form method="POST" action=""> <p> Vols splitar la teva clau? </p> <input type="submit" value="Splitar!"';
                    echo ' name="splitar">';
                    echo ' (' . $config['split_price'] . ' €)';
                }
                $q_comparar = 'SELECT * FROM principal where id_pare = ?';
                $r2 = $mysqli->execute_query($q_comparar,array($row['id']));
                if ($r2) {
                    $rows = [];
                    while ($row2 = $r2->fetch_assoc()) {
                        $rows[] = $row2; // Afegim al array
                    }
                    if (!empty($rows) && !($row['estat'] == 'trial')) {
                        echo '<h3> Les claus filles de la teva clau son: </h3>';
                        $claus_filles = [];
                        $qt = 0;
                        foreach ($rows as $row2) { 
                            $acceptada = "";
                            if($row2['id_pare'] == $row['id']) {
                                $SESSION['correu'] = $row['correu'];
                                if($row2['acceptada'] == 1){
                                    $acceptada = ' <u style="background-color: green;border: 3px solid black;">Acceptada</u> <br> ';
                                }else{
                                    $acceptada = ' <a href="enviarcorreu.php?clau=' . $row2['clau'] . '" style="border: 1px solid black; background-color:silver;">Enviar correu</a>' .'<br>';
                                }
                                echo '</i>';
                                echo '<div style="margin-bottom:5px;"> ' . '<span style="font-size:1.2em";>'. $row2['clau'] . '</span>'. $acceptada . '</div>';
                                
                            }
                        }
                    }else{
                        //No te claus filles
                    }
                }else{
                    echo "Error 1";
                }
            }else{
                //No te clau
            }
        }else{
            echo "Error 2";
        }
    }

    // Si no te clau, s'executa aixo i es crea una clau. En cas de que l'usuari premi Acceptar, s'inserira a la base de dades
    if(isset($_POST['crearClau'])){
        $clau = hash('md5', microtime() . $_SESSION['user']);

        echo "La clau generada automaticament es: " . $clau . "<br>";

        echo '<form method="POST" action=""><input type="submit" value="Acceptar" name="botoacceptar"> </input> </form>';

        $q_actualitzar = "UPDATE principal set clau = ? WHERE usuari = ?";
        $mysqli->execute_query($q_actualitzar,array($clau,$_SESSION['user']));

        if(isset($_POST['botoacceptar'])){
            header('Location: login.php');
            exit;
        }
    }




    // En cas de que sigui trial, permetem splitar-la. S'executa aquest codi un cop intenti splitar-la.
    if(isset($_POST['splitar'])){
        for($i = 0; $i<$config['qt_split'];$i++){
            $q_actualitzar = "INSERT INTO principal (id_pare,estat,clau) values (?,?,?)";
            $clau = hash('md5',(time()*$i/5).$_SESSION['user']);
            $mysqli->execute_query($q_actualitzar,array($row['id'],'trial',$clau));
            //sleep(1);
        }
        $q_canviar = "UPDATE principal set estat = 'split' WHERE usuari = ?";
        $mysqli->execute_query($q_canviar,array($_SESSION["user"]));
        header('Location: login.php');
        exit;
    }

    

?>

<html>
    <head>

    </head>

    <body>
        <h1 style="position:fixed;top:0px;right:10px;"> Benvingut, usuari: <u> <?php echo $_SESSION['user']; ?> </u></h1>

        <?php 
        if ($row['clau'] == null){
            echo 'No tens clau, en voldries obtenir una? <form method="POST" action=""><input type="submit" value="Obtenir una clau" name="crearClau"></form>';
        }
        ?>

        <footer>
            <form method="POST" action="">
                <input type="submit" value="Log out" name="logout" style="position:fixed;bottom:10px;right:10px;">
            </form>
        </footer>

        <?php
            if(isset($_POST['logout'])){
                session_abort();
                header('Location: index.php');
                exit;
            }

        ?>

    </body>
</html>
