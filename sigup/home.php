<?php require_once "controllerUserData.php"; ?>
<?php
    $email = $_SESSION['email'];
    if ($email == false) {
        header('Location: login-user.php');
    }
    $fetch_data = "SELECT * FROM usertable WHERE email = '$email'";
    $run_query = mysqli_query($con, $fetch_data);
    $fetch_info = mysqli_fetch_assoc($run_query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $fetch_info['name'] ?> | Casa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

        nav {
            padding-left: 100px !important;
            padding-right: 100px !important;
            background: #6665ee;
            font-family: 'Poppins', sans-serif;
        }

        nav a.navbar-brand {
            color: #fff;
            font-size: 30px !important;
            font-weight: 500;
        }

        button a {
            color: #6665ee;
            font-weight: 500;
        }

        button a:hover {
            text-decoration: none;
        }

        h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            text-align: center;
            transform: translate(-50%, -50%);
            font-size: 50px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a class="navbar-brand" href="#">MauLogin</a>
        <button type="button" class="btn btn-light"><a href="logout-user.php">Salirse</a></button>
    </nav>
    <h1>
        Bienvenido <?php echo $fetch_info['name'] ?></h1>
</body>

</html>