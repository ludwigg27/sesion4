<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "sesion");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

if (empty($usuario) || empty($contrasena)) {
    echo '<script>alert("Por favor complete todos los campos"); window.location.href="/.vscode/sesion.html";</script>';
    exit();
}

$stmt = $conexion->prepare("SELECT contraseña FROM sesiones WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $fila = $resultado->fetch_assoc();
    if (password_verify($contrasena, $fila['contraseña'])) {
        $_SESSION['usuario'] = $usuario;
<form action="/pizzeria/sesion.php" method="POST">        exit();
    } else {
        echo '<script>alert("Usuario o contraseña incorrectos"); window.location.href="/.vscode/sesion.html";</script>';
        exit();
    }
} else {
    echo '<script>alert("Usuario o contraseña incorrectos"); window.location.href="/.vscode/sesion.html";</script>';
    exit();
}

$stmt->close();
$conexion->close();
?>