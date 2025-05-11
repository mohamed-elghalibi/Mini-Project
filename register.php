<?php
require("config.php");
if($_SERVER['REQUEST_METHOD']=="POST"){
    $identifiant=$_POST['identifiant'];
    $mot_de_pass=$_POST['mot_de_pass'];
    $sql="INSERT INTO users (identifiant,mot_de_pass) VALUES(?,?)";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("ss",$identifiant,$mot_de_pass);
    if($stmt->execute()){
        header("Location:login.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="style_register.css">
<style>

</style>
</head>
<body>

<form action="" method="POST">
<label for="identifiant">Identifiant</label> <input type="text" name="identifiant" >
<label for="mot_de_pass">Mot De Pass</label> <input type="password" name="mot_de_pass" >
<input type="submit" name="Creer" value="Créer" >
</form>

</body>
</html>