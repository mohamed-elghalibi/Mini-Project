<?php
session_start();
require("config.php");

$m="";
if($_SERVER['REQUEST_METHOD']=="POST"){
    $identifiant=$_POST['identifiant'];
    $mot_de_pass=$_POST['mot_de_pass'];
    $sql="SELECT id,identifiant,mot_de_pass FROM users WHERE identifiant=? AND mot_de_pass=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("ss",$identifiant,$mot_de_pass);
    $stmt->execute();
    $res = $stmt->get_result();
    if($res->num_rows>0){
        $row = $res->fetch_assoc();
        $id   = $row['id'];
        $_SESSION['identifiant_id']    = $id;
        $_SESSION['identifiant']=$identifiant;
        header("Location:index.php");
        exit();
    } else {
        $m = "identifiant ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>LOGIN</title>
<link rel="stylesheet" href="style_login.css">
<style>

</style>
</head>
<body>

<form action="" method="POST">
<label for="identifiant">Identifiant</label> <input type="text" name="identifiant" >
<label for="mot_de_pass">Mot De Pass</label> <input type="password" name="mot_de_pass" >
<input type="submit" name="login" value="Login" >
<p>
Pas de compte ? <a href="register.php">Créer un compte</a>
</p>
<?php if($m!=""): ?>
<p class="error-message"><?php echo $m; ?></p>
<?php endif; ?>
</form>

</body>
</html>