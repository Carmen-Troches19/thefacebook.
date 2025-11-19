<?php
session_start();
require 'conexion.php';

$error_registro = '';
$login_error = '';

function es_correo_universitario($email) {
    $parts = explode('@', $email);
    if (count($parts) != 2) return false;
    $domain = strtolower($parts[1]);
    
    $personal = ['gmail.com','hotmail.com','outlook.com','yahoo.com','icloud.com','live.com'];
    if (in_array($domain, $personal)) return false;
    
    if (strpos($domain, 'uvg.edu.gt') !== false) return true;
    if (preg_match('/\.edu(\.|$)/i', $domain)) return true;
    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['form_type']) && $_POST['form_type'] == 'registro') {
        $nombre = trim($_POST['nombre'] ?? '');
        $correo = trim($_POST['email'] ?? '');
        $contrasena = $_POST['password'] ?? '';
        $estatus = $_POST['status'] ?? '';
        $acepta_terminos = isset($_POST['terms']);

        if (empty($nombre)) {
            $error_registro = 'El nombre es obligatorio.';
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $error_registro = 'Formato de correo inválido. Por favor ingresa un correo válido.';
        } elseif (!es_correo_universitario($correo)) {
            $parts = explode('@', $correo);
            $domain = strtolower($parts[1] ?? '');
            $personal = ['gmail.com','hotmail.com','outlook.com','yahoo.com','icloud.com','live.com'];
            if (in_array($domain, $personal)) {
                $error_registro = 'No se aceptan correos personales. Usa tu correo universitario (@uvg.edu.gt)';
            } else {
                $error_registro = 'El dominio "' . htmlspecialchars($domain) . '" no es reconocido como universitario. Usa un correo con dominio @uvg.edu.gt';
            }
        } elseif (empty($contrasena)) {
            $error_registro = 'La contraseña es obligatoria.';
        } elseif (empty($estatus)) {
            $error_registro = 'Debes seleccionar un estatus.';
        } elseif (!$acepta_terminos) {
            $error_registro = 'Debes aceptar los términos de uso.';
        } else {

            $stmt_check = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
            $stmt_check->bind_param("s", $correo);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                $error_registro = 'Este correo ya está registrado.';
            } else {
                $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, estatus) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nombre, $correo, $contrasena, $estatus);
                if ($stmt->execute()) {
                    $_SESSION['flash_success'] = 'Registro exitoso. Ahora puedes iniciar sesión.';
                    header('Location: index.php');
                    exit();
                } else {
                    $error_registro = 'Error al registrar: ' . $stmt->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registrarse</title>
    <link rel="stylesheet" href="style.css">

    </head>
    <body>
    <div class="topbar">
        <img src="imagenes/navperfil.jpg" class="banner" alt="banner" >
            <div class="topnav">
            <div class="logo">[ thefacebook ]</div>
            <a href="index.php">Login</a>
            <a href="registrarse.php">Registrarse</a>
            <a href="contacto.php">Contacto</a>
            </div>
    </div>

    <div class="page">
        <aside class="leftcol">
            <div class="box">
                <form method="POST" action="index.php">
                    <input type="hidden" name="form_type" value="login">
                    <label for="email">Email:</label>
                    <input id="email" type="email" name="email" required>
                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password" required>
                    <div style="margin-top:8px;">
                        <button class="btn" style="color:white; background-color: #7aa9ee; border-color: #7aa9ee;">Iniciar</button>
                        <a class="btn" href="registrarse.php" style="color:white; background-color: #7aa9ee; border-color: #7aa9ee;">Registrarse</a>
                    </div>
                    <div id="login-msg" class="message-error<?php if(!empty($login_error)) echo ' message-inline'; ?>"><?php echo htmlspecialchars($login_error); ?></div>
                </form>
            </div>
        </aside>

        <main class="mainbox">
            <div class="header">Registro</div>
            <div class="content">
                <h2 class="welcome-title">Registro</h2>
                <div class="reg-content">
                    <div class="reg-instructions">
                        <p>Para registrarte en thefacebook, completa los campos a continuación. Podrás agregar más información y una foto después de registrarte.</p>
                    </div>
                    <form  id="registroForm" class="reg-form" method="POST" action="">
                        <input type="hidden" name="form_type" value="registro">
                        <div class="row">
                            <label for="nombre">Nombre:</label>
                            <div class="input"><input id="nombre" type="text" name="nombre" required></div>
                        </div>
                        <div class="row">
                            <label for="status">Estatus:</label>
                            <div class="input">
                                <select id="status" name="status">
                                    <option></option>
                                    <option>Estudiante</option>
                                    <option>Alumnus/Alumna</option>
                                    <option>Facultad</option>
                                    <option>Colaboradores</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="email">Correo Institucional (UVG):</label>
                            <div class="input"><input id="email_reg" type="email" name="email" required></div>
                        </div>
                        <div class="row">
                            <label for="password">Contraseña*: </label>
                            <div class="input"><input id="password_reg" type="password" name="password" required></div>
                        </div>
                        <div class="row">
                            <div class="terms"><label><input type="checkbox" name="terms"> He leído y acepto los <a href="#">Términos de uso</a>.</label></div>
                        </div>
                        <div class="row">
                            <div class="terms">* Puedes elegir cualquier contraseña. No debe ser tu contraseña institucional.</div>
                        </div>
                        <div class="row" style="justify-content:center;">
                            <button class="btn large register-now" type="submit" style="color:white; background-color: #7aa9ee; border-color: #7aa9ee;">¡Registrar ahora!</button>
                        </div>
                        <div id="mensaje-error" class="message-error<?php if(!empty($error_registro)) echo ' message-inline'; ?>"><?php echo htmlspecialchars($error_registro); ?></div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <br>
    <script src="scripts.js"></script>
    </body>
    </html>