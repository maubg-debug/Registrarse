<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Codigo de verificacion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="user-otp.php" method="POST" autocomplete="off">
                    <h2 class="text-center">
                        Codigo de verificacion</h2>
                    <?php
                    if (isset($_SESSION['info'])) {
                    ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                    <?php
                    }
                    ?>
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
                        <input class="form-control" type="number" name="otp" placeholder="Pon el codigo de verificacion" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="check" value="Enviar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
