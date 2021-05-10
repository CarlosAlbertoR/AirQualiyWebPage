<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/icons/favicon.ico" />
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://use.fontawesome.com/releases/v5.8.1/css/all.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script>
    <title>Registro</title>
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="../index.html">Calidad del Aire</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="../index.html#about">Nosotros</a>
                    </li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="../index.html#projects">Proyectos</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="../index.html#contact">Contacto</a>
                    </li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger btn-primary" style="color: rgb(255, 255, 255); margin:19px;  padding: 10px; border-radius: 10px;" href="./employee_register.php">Soy Empleado</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Container login-->
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form class="box" action="register.php" method="POST">
                        <h1>Registro</h1>
                        <p class="text-muted"> Introduce todos los datos para completar tu registro</p>
                        <input type="text" name="name" placeholder="Nombre completo" required>
                        <input type="text" name="phone" placeholder="Celular" required>
                        <input type="email" name="username" placeholder="Correo electrónico" required>
                        <input type="password" name="password" placeholder="Contraseña" required>
                        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
                        <div style="margin: 20px;">
                            <input type="checkbox" name="allow" id="">
                            <p class="text-muted" style="display: inline-block;">Acepto los <a href="#">Terminos y condiciones.</a> </p>
                        </div>
                        <input type="submit" name="" value="Registrarme">
                        <p class="text-muted" style="color: rgb(218, 209, 209)">Registrarme con:</p>
                        <div class="col-md-12" style="margin-bottom: 20px;">
                            <ul class="social-network social-circle">
                                <li><a href="#" class="icoFacebook" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li><a href="#" class="icoTwitter" title="Twitter"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li><a href="#" class="icoGoogle" title="Google +"><i class="fab fa-google-plus"></i></a>
                                </li>
                            </ul>
                        </div>
                        <a class="forgot text-muted" href="./login.html">Ya tengo una cuenta.</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
#Go out if any data isn't present
if (!isset($_POST["name"]) || !isset($_POST["phone"]) || !isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["password_confirmation"])) {
    exit();
}

#Confirm passwords
if ($_POST['password'] != $_POST["password_confirmation"]) {
    echo "<script> swal({
   title: '¡ERROR!',
   text: 'Ambas contraseñas no coinciden.',
   type: 'error',
 });</script>";
    exit();
}

#If all go good, continue the execution
include_once("../config/conection_db.php");

// muestra el formato internacional para la configuración regional
date_default_timezone_set('UTC');

#Data
$name = $_POST["name"];
$phone = $_POST["phone"];
$username = $_POST["username"];
$password = $_POST["password"];

#Sentences
$sentence = $conection->prepare("INSERT INTO public.tbl_client(name,phone,email) VALUES ('$name','$phone','$username')");
$result = $sentence->execute();

$idClient = $conection->prepare("SELECT pk_client FROM public.tbl_client LIMIT 1");
$idResult = $idClient->execute();

$sentence2 = $conection->prepare("INSERT INTO public.tbl_user(fk_type_user,user_email,password,fk_client) VALUES (2,'$username', '$password', '$idResult');");
$result2 = $sentence2->execute();

if ($result === true && $result2) {
    header("Location: ../main/main.html");
} else {
    echo "<script> swal({
   title: '¡ERROR!',
   text: 'Algo salio mal con la conexión.',
   type: 'error',
 });</script>";
}

?>