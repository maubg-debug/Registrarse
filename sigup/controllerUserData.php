<?php 
    session_start();
    require "connection.php";
    $email = "";
    $name = "";
    $errors = array();

    if(isset($_POST['signup'])){
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
        if($password !== $cpassword){
            $errors['password'] = "Contraseñas no coinciden!";
        }
        $email_check = "SELECT * FROM usertable WHERE email = '$email'";
        $res = mysqli_query($con, $email_check);
        if(mysqli_num_rows($res) > 0){
            $errors['email'] = "Ese email ya existe!";
        }
        if(count($errors) === 0){
            $encpass = password_hash($password, PASSWORD_BCRYPT);
            $code = rand(999999, 111111);
            $status = "notverified";
            $insert_data = "INSERT INTO usertable (name, email, password, code, status)
                            values('$name', '$email', '$encpass', '$code', '$status')";
            $data_check = mysqli_query($con, $insert_data);
            if($data_check){
                $subject = "Codigo de verificacion";
                $message = "Tu codigo de verificacion es $code";
                $sender = "From: "; // Email
                if(mail($email, $subject, $message, $sender)){
                    $info = "Te hemos enviado un codigo de verificacion - $email";
                    $_SESSION['info'] = $info;
                    header('location: user-otp.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Un error intentando enviar email!";
                }
            }else{
                $errors['db-error'] = "Error intentando entrar en la base de datos!";
            }
        }

    }

        if(isset($_POST['check'])){
            $_SESSION['info'] = "";
            $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
                $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
                $code_res = mysqli_query($con, $check_code);
                if(mysqli_num_rows($code_res) > 0){
                    $fetch_data = mysqli_fetch_assoc($code_res);
                    $fetch_code = $fetch_data['code'];
                    $email = $fetch_data['email'];
                    $code = 0;
                    $status = 'verified';
                    $update_otp = "UPDATE usertable SET code = $code, status = '$status' WHERE code = $fetch_code";
                    $update_res = mysqli_query($con, $update_otp);
                    if($update_res){
                        $_SESSION['name'] = $name;
                        $_SESSION['email'] = $email;
                        header('location: home.php');
                        exit();
                    }else{
                        $errors['otp-error'] = "Fallado intentando actualizar tu codigo!";
                    }
                }else{
                    $errors['otp-error'] = "Codigo incorecto!";
                }
        }

        if(isset($_POST['login'])){
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $password = mysqli_real_escape_string($con, $_POST['password']);
            $check_email = "SELECT * FROM usertable WHERE email = '$email'";
            $res = mysqli_query($con, $check_email);
            if(mysqli_num_rows($res) > 0){
                $fetch = mysqli_fetch_assoc($res);
                $fetch_pass = $fetch['password'];
                if(password_verify($password, $fetch_pass)){
                    $_SESSION['email'] = $email;
                    $status = $fetch['status'];
                    if($status == 'verified'){
                    $_SESSION['email'] = $email;
                        header('location: home.php');
                    }else{
                        $info = "Aun no as verificado tu email - $email";
                        $_SESSION['info'] = $info;
                        header('location: user-otp.php');
                    }
                }else{
                    $errors['email'] = "Incorrect email or password!";
                }
            }else{
                $errors['email'] = "Aun no eres un miembro! Haz click en el boton para crearte una cuenta.";
            }
        }
