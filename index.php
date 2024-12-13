<?php
session_start();
session_destroy();
session_start();
$message = '';

if (isset($_POST['boto'])) {

    $mysqli = new mysqli('localhost','root','', 'practicaphp');

    if(mysqli_connect_errno()) {
        echo $mysqli->connect_error;
        exit;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $q_id = 'SELECT usuari, password FROM principal where usuari=? AND password=?';

    $r1 = $mysqli->execute_query($q_id,array($username,$password));

    if($r1){

        $row = $r1->fetch_assoc();

        if($row){

            if($row['usuari'] == $_POST['username'] && $row['password'] == ($_POST['password'])){
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['user'] = $_POST['username'];
                header("Location: login.php");
                exit;
            }else{
                $message = "Usuari erroni";
            }

        }else{
            $message = "Usuari erroni";
        }

    }else{
        $message = "Error en la consulta";
    }
$r1->close();
$mysqli->close();
    
}else if(isset($_POST['fmp'])){
    header('Location: rmp.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            margin-bottom: 15px;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #218838;
        }
        .error-message {
            color: red;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <?php if ($message): ?>
        <div class="error-message"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required> <br>
        <button type="submit" name="boto">Login</button><br><br>
    </form>

    <form method="POST" action="">
        <button type="submit" name="fmp" style="background-color:red; color:white;">Forgot my password</button>
    </form>
</div>

</body>
</html>