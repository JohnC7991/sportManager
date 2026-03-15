<?php

session_start();

require_once "../config/conexion.php";
require_once "../model/Usuario.php";

if(isset($_POST["login"])){

    if (empty($_POST["email"]) || empty($_POST["password"])) {
        header("Location: ../login.php?error=1"); // Error genérico para no dar pistas
        exit();
    }

    // Sanitizar email y obtener contraseña
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"]; // La contraseña no se sanitiza para poder compararla con el hash

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../login.php?error=1"); // Error genérico para no dar pistas
        exit();
    }

    $usuarioModel = new Usuario($conexion);

    $usuario = $usuarioModel->login($email,$password);

    if($usuario){

        $_SESSION["usuario"] = $usuario["nombres"];
        $_SESSION["rol"] = $usuario["id_rol"];
        $_SESSION["id"] = $usuario["id"];

        header("Location: ../dashboard.php");
        exit();

    }else{

        header("Location: ../login.php?error=1");
        exit();
        
    }

}

?>