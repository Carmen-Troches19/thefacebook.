<?php
session_start();
require 'conexion.php';

$registro_error = '';
$registro_success = '';
$login_error = '';

function is_university_email($email) {
    $parts = explode('@', $email);
    if (count($parts) != 2) return false;
    $domain = strtolower($parts[1]);
    
    $personal = ['gmail.com','hotmail.com','outlook.com','yahoo.com','icloud.com','live.com'];
    if (in_array($domain, $personal)) return false;
    
    if (strpos($domain, 'uvg.edu.gt') !== false) return true;
    if (preg_match('/\.edu(\.|$)/i', $domain)) return true;
    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_type']) && $_POST['form_type'] == 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $login_error = "Email y contraseña son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $login_error = " Email inválido.";
    } elseif (!is_university_email($email)) {

        $parts = explode('@', $email);
        $domain = strtolower($parts[1] ?? '');
        $personal = ['gmail.com','hotmail.com','outlook.com','yahoo.com','icloud.com','live.com'];
        
        if (in_array($domain, $personal)) {
            $login_error = " No se aceptan correos personales. Usa tu correo universitario (@uvg.edu.gt)";
        } else {
            $login_error = ' El dominio "' . htmlspecialchars($domain) . '" no es reconocido. Usa @uvg.edu.gt';
        }
    } else {
       
        $stmt = $conn->prepare("SELECT id_usuario, nombre, email, password, estatus FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($user['password'] == $password) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id_usuario'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_estatus'] = $user['estatus'];
                header("Location: perfil.php");
                exit();
            } else {
                $login_error = "Contraseña incorrecta.";
            }
        } else {
            $login_error = "Usuario no encontrado. ¿Quizás desees <a href='registro.php'>registrarte</a>?";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['form_type']) && $_POST['form_type'] == 'registro') {
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $estatus = $_POST['status'] ?? '';
        $terms = isset($_POST['terms']) ? true : false;

        if (empty($nombre)) {
            $registro_error = 'El nombre es obligatorio.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $registro_error = 'Formato de correo inválido. Por favor ingresa un correo válido.';
        } elseif (!is_university_email($email)) {
            
            $parts = explode('@', $email);
            $domain = strtolower($parts[1] ?? '');
            $personal = ['gmail.com','hotmail.com','outlook.com','yahoo.com','icloud.com','live.com'];
            
            if (in_array($domain, $personal)) {
                $registro_error = 'No se aceptan correos personales. Usa tu correo universitario (@uvg.edu.gt)';
            } else {
                $registro_error = ' El dominio "' . htmlspecialchars($domain) . '" no es reconocido como universitario. Usa un correo con este dominio @uvg.edu.gt ';
            }
        } elseif (empty($password)) {
            $registro_error = 'La contraseña es obligatoria.';
        } elseif (empty($estatus)) {
            $registro_error = 'Debes seleccionar un estatus.';
        } elseif (!$terms) {
            $registro_error = 'Debes aceptar los términos de uso.';
        } else {
            
            $stmt_check = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            
            if ($result_check->num_rows > 0) {
                $registro_error = ' Este correo ya está registrado';
            } else {
                
                $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, estatus) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nombre, $email, $password, $estatus);
                        if ($stmt->execute()) {
                            $_SESSION['flash_success'] = ' Registro exitoso. Ahora puedes iniciar sesión.';
                            header('Location: index.php');
                            exit();
                        } else {
                            $registro_error = ' Error al registrar: ' . $stmt->error;
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
    <title>Registro-TheFacebook</title>
    <link rel="stylesheet" href="style.css">

    </head>
    <body>
    <div class="topbar">
        <img src="imagenes/navperfil.jpg" class="banner" alt="banner" >
        <div class="topnav">
            <div class="logo">[ thefacebook ]</div>
            <a href="index.php">login</a> 
            <a href="registro.php">register</a> 
            <a href="contacto.php">about</a></div>
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
                        <button class="btn" style="color:white; background-color: #31599a; border-color: #31599a;">login</button>
                        <a class="btn" href="registro.php" style="color:white; background-color: #31599a; border-color: #31599a;">register</a>
                    </div>
                    <div id="login-msg" class="message-error<?php if(!empty($login_error)) echo ' message-inline'; ?>"><?php echo htmlspecialchars($login_error); ?></div>
                </form>
            </div>
        </aside>

        <main class="mainbox">
            <div class="header">Register</div>
            <div class="content">
                <h2 class="welcome-title">Registration</h2>
                <div class="reg-content">
                    <div class="reg-instructions">
                        <p>To register for thefacebook.com, just fill in the four fields below. You will have a chance to enter additional information and submit a picture once you have registered.</p>
                    </div>
                    <form  id="registroForm" class="reg-form" method="POST" action="">
                        <input type="hidden" name="form_type" value="registro">
                        <div class="row">
                            <label for="nombre">Name:</label>
                            <div class="input"><input id="nombre" type="text" name="nombre" required></div>
                        </div>
                        <div class="row">
                            <label for="status">Status:</label>
                            <div class="input">
                                <select id="status" name="status">
                                    <option></option>
                                    <option>Student</option>
                                    <option>Alumnus/Alumna</option>
                                    <option>Faculty</option>
                                    <option>Staff</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="email">Email: (UVG)</label>
                            <div class="input"><input id="email" type="email" name="email" required></div>
                        </div>
                        <div class="row">
                            <label for="password">Password*: </label>
                            <div class="input"><input id="password" type="text" name="password" required></div>
                        </div>
                        <div class="row">
                            <div class="terms"><label><input type="checkbox" name="terms"> I have read and understood the <a href="#">Terms of Use</a>, and I agree to them.</label></div>
                        </div>
                        <div class="row">
                            <div class="terms">* You can choose any password. It does not have to be, and should not be, your FAS password.</div>
                        </div>
                        <div class="row" style="justify-content:center;">
                            <button class="btn large register-now" type="submit" style="color:white; background-color: #31599a; border-color: #31599a;">Register Now!</button>
                        </div>
                        <div id="mensaje-error" class="message-error<?php if(!empty($registro_error)) echo ' message-inline'; ?>"><?php echo htmlspecialchars($registro_error); ?></div>
                        <div id="mensaje-success" class="message-success<?php if(!empty($registro_success)) echo ' message-inline'; ?>"><?php echo htmlspecialchars($registro_success); ?></div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <br>
    <script src="scripts.js"></script>
    </body>
    </html>