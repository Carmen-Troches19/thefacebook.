<?php

ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
session_start();
require 'conexion.php';

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
            $login_error = "Usuario no encontrado. ¿Quizás desees registrarte?";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Thefacebook</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
    <div class="topbar">
        <img src="imagenes/navperfil.jpg" alt="banner" class="banner">
        <div class="topnav"> <div class="logo">[ thefacebook ]</div><a href="index.php">login</a> <a href="registrarse.php">register</a> <a href="contacto.php">about</a></div>
    </div>

    <div class="page">
        <aside class="leftcol">
            <div class="box">
                <form method="POST" action="index.php" onsubmit="return validarEmailUniversitario(this)">
                    <input type="hidden" name="form_type" value="login">
                    <label for="email">Email:</label>
                    <input id="email" type="email" name="email" required>
                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password" required>
                    <div style="margin-top:8px;">
                        <button class="btn" style="color:white; background-color: #7aa9ee; border-color: #7aa9ee;">login</button>
                        <a class="btn" href="registrarse.php" style="color:white; background-color: #7aa9ee; border-color: #7aa9ee;">register</a>
                    </div>
                    <div id="login-msg" class="message-error<?php if(!empty($login_error)) echo ' message-inline'; ?>"><?php echo htmlspecialchars($login_error); ?></div>
                </form>
            </div>
        </aside>

        <main class="mainbox">
            <div class="header">Welcome to Thefacebook!</div>
            <div class="content">
                <h2 class="welcome-title">[ Welcome to Thefacebook ]</h2>
                <div class="intro">
                    <p>Thefacebook is an online directory that connects people through social networks at colleges.</p>
                    <p>We have opened up Thefacebook for popular consumption at <strong>Harvard University</strong>.</p>
                    <p>You can use Thefacebook to:</p>
                    <ul>
                        <li>Search for people at your school</li>
                        <li>Find out who are in your classes</li>
                        <li>Look up your friends' friends</li>
                        <li>See a visualization of your social network</li>
                    </ul>
                    <p>To get started, click below to register. If you have already registered, you can log in.</p>
                    <div style="text-align:center;margin-top:12px;">
                        <a class="btn" href="registrarse.php" style="color:white; background-color: #7aa9ee; border-color: #7aa9ee;">Register</a>
                        <a class="btn" href="index.php" style="color:white; background-color: #7aa9ee; border-color: #7aa9ee;">Login</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer style="text-align:center;padding:18px;color:#6d7aa0;">
        <p style="margin:6px 0;"><a href="#">about</a> &nbsp; <a href="contacto.php">contact</a> &nbsp; <a href="#">faq</a> &nbsp; <a href="#">terms</a> &nbsp; <a href="#">privacy</a></p>
        <p style="margin:6px 0;">a Mark Zuckerberg production</p>
        <p style="margin:6px 0;">Thefacebook © 2004</p>
    </footer>
</body>
<script src="scripts.js"></script>
</html>