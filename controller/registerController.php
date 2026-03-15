<?php

session_start();

require_once "../config/conexion.php";
require_once "../model/Usuario.php";

if (isset($_POST["register"])) {

    // Sanitización de datos de entrada para prevenir XSS
    $id = filter_var(trim($_POST["id"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tipo_documento = filter_var(trim($_POST["tipo_documento"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id_escuela = filter_var(trim($_POST["id_escuela"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombres = filter_var(trim($_POST["nombres"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $apellidos = filter_var(trim($_POST["apellidos"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"]; // La contraseña no se sanitiza para no alterar caracteres especiales
    $telefono = filter_var(trim($_POST["telefono"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($id) || empty($tipo_documento) || empty($id_escuela) || empty($nombres) || empty($apellidos) || empty($email) || empty($password) || empty($telefono)) {
        header("Location: ../register.php?error=empty");
        exit();
    }

    // Validación de formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../register.php?error=invalidemail");
        exit();
    }

    $usuarioModel = new Usuario($conexion);

    if ($usuarioModel->registrar($id, $tipo_documento, $id_escuela, $nombres, $apellidos, $email, $password, $telefono)) {
        header("Location: ../register.php?success=1");
        exit();
    } else {
        header("Location: ../register.php?error=db");
        exit();
    }
} else {
    header("Location: ../register.php");
    exit();
}
