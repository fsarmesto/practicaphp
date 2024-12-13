<?php

if(isset($_POST['acceptar'])){
    header('Location: index.php');
    exit;
}


?>

<form method="POST" action="">
    <div align="center">
    <?php 

    $missatge = isset($_GET['missatge']) ? $_GET['missatge'] : null;
    
    if($missatge == 'CLAU JA AGAFADA'){
        echo '<p align="center" style="color:red;font-size:40px;"> ERROR: ' . $missatge . ' </p>';
    }else if($missatge =='CLAU ACCEPTADA CORRECTAMENT'){
        echo '<p align="center" style="color:green;font-size:40px;">' . $missatge . ' </p>';
    }else{
        echo '<p align="center" style="color:blue;font-size:40px;">' . 'Error inesperat' . ' </p>';
    }
    ?>
    
    <input type="submit" value="ACCEPTAR" name="acceptar" style="height: 5em;width: 15em;font-size:2em;">
    </div>
</form>