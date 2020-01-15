<?php
    session_start();
    $level='';
    include "../koneksi.php";
    require '../function/validate.php';
    $errors = array();     
    function cekPassword(){
        global $dbh;
        $query = $dbh->prepare("SELECT * FROM user  WHERE username=:username and passwd=SHA2(:password,0)");
        $query->bindValue(':username',$_POST['username']);
        $query->bindValue(':password',$_POST['password']);
        $query->execute();
        return $query-> rowCount() > 0; 
        foreach ($query as $data){
            $level=$data['id_level'];
        }
    }
    if (isset($_POST['login']))
    {   
        if (cekPassword($_POST['username'], $_POST['password']))
        {   
            $query = $dbh->prepare("SELECT * FROM user  WHERE username=:username and passwd=SHA2(:password,0)");
            $query->bindValue(':username',$_POST['username']);
            $query->bindValue(':password',$_POST['password']);
            $query->execute();
            foreach ($query as $data){
                $level=$data['ID_LEVEL'];
                $id_user=$data['ID_USER'];
            }
            $_SESSION['login'] = true;
            $_SESSION['level'] = $level;
            $_SESSION['id_user'] = $id_user;
            header("Location: ../index.php");   
        }else{
            validateUsername($errors, $_POST, 'username');     
            validatePass($errors, $_POST, 'password');  
        }
    }
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login el-Tru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../asset/icon.png">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    </head>
    <!-- body login -->
    <body>
        <img class="img-iconLogin" src="../asset/icon.png" alt="icon">
        <!-- form login -->
        <form action="./" method="POST">
            <h2 class="login-title">Login el-Tru</h2>
            <div class="formLogin">
                <!-- menampilkan error login -->
                <?php
                    if ($errors){
                        echo "<span style='color:red; text-align: center; font-size:12px;' >periksa kembali username dan password</span><br>";
                    }
                ?>
                <!-- opsi login -->
                <p class="opt-login">Login Dengan</p>
                <div style="float: left;">
                    <div class="loginWith" style="float: left;">
                        <img src="../asset/google.png" alt="google">
                        <p>Google</p>
                    </div>
                    <div class="loginWith">
                        <img src="../asset/facebook.png" alt="facebook">
                        <p>facebook</p>
                    </div>
                </div>
                <!-- kolom input username dan password -->
                <p class="opt-login">atau dengan</p>
                <input class="input" type="text" name="username" placeholder="Username" style="padding-left: 10px;"><br>
                <?php
                    foreach ($errors as $field => $error){
                        if ($field == 'username') {
                            echo "<span style='color:red;'>".$error."</span><br>";
                        }
                    }
                ?>
                <input class="input" type="password" name="password" placeholder="Password" style="padding-left: 10px;" ><br>
                <?php
                    foreach ($errors as $field => $error){
                        if ($field == 'password') {
                            echo "<span style='color:red;'>".$error."</span><br>";
                        }
                    }
                ?>
                <input class="login-btn" type="submit" name="login" value="Login">
            </div>
        </form> 
    </body>
</html>