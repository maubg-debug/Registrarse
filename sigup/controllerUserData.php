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
            $errors['password'] = "Confirm password not matched!";
        }
        $email_check = "SELECT * FROM usertable WHERE email = '$email'";
        $res = mysqli_query($con, $email_check);
        if(mysqli_num_rows($res) > 0){
            $errors['email'] = "Email that you have entered is already exist!";
        }
        if(count($errors) === 0){
            $encpass = password_hash($password, PASSWORD_BCRYPT);
            $code = rand(999999, 111111);
            $status = "notverified";
            $insert_data = "INSERT INTO usertable (name, email, password, code, status)
                            values('$name', '$email', '$encpass', '$code', '$status')";
            $data_check = mysqli_query($con, $insert_data);
            if($data_check){
                $subject = "Email Verification Code";
                $message = "Your verification code is $code";
                $sender = "From: shahiprem7890@gmail.com";
                if(mail($email, $subject, $message, $sender)){
                    $info = "We've sent a verification code to your email - $email";
                    $_SESSION['info'] = $info;
                    header('location: user-otp.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code!";
                }
            }else{
                $errors['db-error'] = "Failed while inserting data into database!";
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
                        $errors['otp-error'] = "Failed while updating code!";
                    }
                }else{
                    $errors['otp-error'] = "You've entered incorrect code!";
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
                        $info = "It's look like you haven't still verify your email - $email";
                        $_SESSION['info'] = $info;
                        header('location: user-otp.php');
                    }
                }else{
                    $errors['email'] = "Incorrect email or password!";
                }
            }else{
                $errors['email'] = "It's look like you're not a yet member! Click on the bottom link to signup.";
            }
        }
