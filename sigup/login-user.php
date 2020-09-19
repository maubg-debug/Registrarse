<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Entrar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form login-form">
                <form action="login-user.php" method="POST" autocomplete="">
                    <h2 class="text-center">
                        Entrar</h2>
                    <p class="text-center">
                        Entra con tu email y contraseña.</p>
                    <?php
                        if (count($errors) > 0) {
                    ?>
                        <div class="alert alert-danger text-center">
                            <?php
                                foreach ($errors as $showerror) {
                                    echo $showerror;
                                }
                            ?>
                        </div>
                    <?php
                        }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email" required value="<?php echo $email ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Contraseña" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="login" value="Entrar">
                    </div>
                    <div class="link login-link text-center">
                        ¿No eres un miembo? <a href="signup-user.php">Registrate</a></div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>