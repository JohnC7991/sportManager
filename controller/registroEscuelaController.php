<?php
session_start();

require_once "../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit_escuela"])) {
    // Sanitización básica
    $id_escuela = filter_var(trim($_POST["id_escuela"]), FILTER_VALIDATE_INT);
    $nombre = filter_var(trim($_POST["nombre"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $disciplina = filter_var(trim($_POST["disciplina"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dia_pago = filter_var(trim($_POST["dia_pago"]), FILTER_VALIDATE_INT);
    $valor_inscripcion = filter_var(trim($_POST["valor_inscripcion"]), FILTER_VALIDATE_FLOAT);
    $valor_mensualidad = filter_var(trim($_POST["valor_mensualidad"]), FILTER_VALIDATE_FLOAT);
    $correo = filter_var(trim($_POST["correo"]), FILTER_SANITIZE_EMAIL);
    $pass_app = trim($_POST["pass_app"]); // No sanitizar para no alterar la contraseña
    $telefono = filter_var(trim($_POST["telefono"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $direccion = filter_var(trim($_POST["direccion"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validaciones
    if (empty($id_escuela) || empty($nombre) || empty($disciplina) || empty($dia_pago) || empty($valor_inscripcion) || empty($valor_mensualidad) || empty($correo) || empty($pass_app) || empty($telefono) || empty($direccion)) {
        header("Location: ../registroEscuela.php?error=empty");
        exit();
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../registroEscuela.php?error=invalidemail");
        exit();
    }

    if ($dia_pago < 1 || $dia_pago > 31) {
        header("Location: ../registroEscuela.php?error=diainvalido");
        exit();
    }

    if ($valor_inscripcion < 0 || $valor_mensualidad < 0) {
        header("Location: ../registroEscuela.php?error=valorinvalido");
        exit();
    }

    // Procesar archivos
    $uploadDir = realpath(__DIR__ . "/..") . "/uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    function saveUploadedFile($fileKey, $uploadDir, &$errorMessage) {
        if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $file = $_FILES[$fileKey];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errorMessage = "Upload error ($fileKey): " . $file['error'];
            return false;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes, true)) {
            $errorMessage = "Tipo de archivo no permitido para $fileKey.";
            return false;
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = uniqid($fileKey . "_", true) . "." . $ext;
        $destination = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            $errorMessage = "No se pudo mover el archivo subido para $fileKey";
            return false;
        }

        return $fileName;
    }

    $escudo_path = null;
    $firma_path = null;
    $uploadError = "";

    $tmp = saveUploadedFile('escudo_path', $uploadDir, $uploadError);
    if ($tmp === false) {
        header("Location: ../registroEscuela.php?error=" . urlencode($uploadError));
        exit();
    }
    $escudo_path = $tmp;

    $tmp = saveUploadedFile('firma_path', $uploadDir, $uploadError);
    if ($tmp === false) {
        header("Location: ../registroEscuela.php?error=" . urlencode($uploadError));
        exit();
    }
    $firma_path = $tmp;

    // Hash de la contraseña de la app (recomendado)
    $pass_app_hashed = password_hash($pass_app, PASSWORD_DEFAULT);

    try {
        $stmt = $conexion->prepare("INSERT INTO escuelas (id_escuela, nombre, disciplina, dia_pago, valor_inscripcion, valor_mensualidad, correo, pass_app, telefono, direccion, escudo_path, firma_path) VALUES (:id_escuela, :nombre, :disciplina, :dia_pago, :valor_inscripcion, :valor_mensualidad, :correo, :pass_app, :telefono, :direccion, :escudo_path, :firma_path)");

        $stmt->bindParam(':id_escuela', $id_escuela, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':disciplina', $disciplina);
        $stmt->bindParam(':dia_pago', $dia_pago, PDO::PARAM_INT);
        $stmt->bindParam(':valor_inscripcion', $valor_inscripcion);
        $stmt->bindParam(':valor_mensualidad', $valor_mensualidad);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':pass_app', $pass_app_hashed);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':escudo_path', $escudo_path);
        $stmt->bindParam(':firma_path', $firma_path);

        $inserted = $stmt->execute();

        if ($inserted) {
            header("Location: ../registroEscuela.php?success=1");
            exit();
        } else {
            header("Location: ../registroEscuela.php?error=db");
            exit();
        }

    } catch (PDOException $e) {
        header("Location: ../registroEscuela.php?error=" . urlencode('db:' . $e->getMessage()));
        exit();
    }

} else {
    header("Location: ../registroEscuela.php");
    exit();
}
