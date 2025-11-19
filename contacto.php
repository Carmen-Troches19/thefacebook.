<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];
    
    $destinatario = 'tucorreo@ejemplo.com'; 
    $asunto = "Nuevo mensaje de contacto";
    $cuerpo = "Nombre: $nombre\nCorreo: $email\nMensaje:\n$mensaje";

    $headers = "From: $email";

    if (mail($destinatario, $asunto, $cuerpo, $headers)) {
        $mensaje_exito = "Mensaje enviado correctamente.";
    } else {
        $mensaje_error = "Error al enviar el mensaje.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Contacto-TheFacebook</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
    <div class="topbar">
        <img src="imagenes/navperfil.jpg" class="banner" alt="banner" >
        <div class="topnav"><div class="logo">[ thefacebook ]</div><a href="index.php">home</a> <a href="contacto.php">contact</a></div>
    </div>

    <div class="page">
        <main class="mainbox" style="margin-left:125px;">
            <div class="header">Contact Us</div>
            <div class="content">
                <h2 class="about-title">[ Contact Us ]</h2>

                <div class="info-box">
                    <div class="title">The Project</div>
                    <div class="body">
                        <p style="padding-left: 10px;">Thefacebook is an directory that connects people through social networks at colleges and universities.</p>
                    </div>
                </div>

                <div class="info-box">
                    <div class="title">Contact</div>
                    <div class="body">
                        <p style="padding-left: 10px;"> Nombre: &nbsp;&nbsp;Carmen Victoria Troches López</p>
                        <p style="padding-left: 10px;"> Correo: &nbsp;&nbsp;<a href="#">tro241985@uvg.edu.gt</a></p>
                        <p style="padding-left: 10px;"> Telefono: &nbsp;&nbsp;&nbsp;+502&nbsp; 36024130</p>
                        <p style="padding-left: 10px;"> Universidad: &nbsp;&nbsp;Universidad del Valle</p>
                        <p style="padding-left: 10px;"> Rol: &nbsp;&nbsp;Desarrollador</p> 
                    </div>
                </div>

                <div class="info-box">
                    <div class="title">Creador</div>
                    <div class="creators-grid">
                        <div class="creator-card">
                            <div class="creator-photo">
                                <img src="imagenes/foto.jpg" alt="Creator 2">
                            </div>
                            <div class="creator-info">
                                <strong>Danilo de Leon</strong>
                                <p>Full Stack</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="text-align:center;margin-top:18px;">
                    <a class="btn" href="index.php " style="color:white; background-color: #31599a; border-color: #31599a;">Home</a>
                </div>

            </div>
        </main>
    </div>
</body>
</html>