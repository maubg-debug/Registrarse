<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registrarse</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="signup-user.php" method="POST" autocomplete="">
                    <h2 class="text-center">
                        Registrate</h2>
                    <p class="text-center">
                        Es facil y rapido.</p>
                    <?php
                        if (count($errors) == 1) {
                    ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach ($errors as $showerror) {
                                echo $showerror;
                            }
                            ?>
                        </div>
                    <?php
                        } elseif (count($errors) > 1) {
                    ?>
                        <div class="alert alert-danger">
                            <?php
                                foreach ($errors as $showerror) {
                            ?>
                                <li><?php echo $showerror; ?></li>
                            <?php
                                }
                            ?>
                        </div>
                    <?php
                        }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" placeholder="Nombre" required value="<?php echo $name ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Emailo" required value="<?php echo $email ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Contraseña" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="cpassword" placeholder="Confirmar contraseña" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="signup" value="Registrarse">
                    </div>
                    <div class="link login-link text-center">
                        ¿Ya eres un miembro? <a href="login-user.php">Entra</a></div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>