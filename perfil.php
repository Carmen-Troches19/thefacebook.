<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$profile = [
    'nombre' => 'Danilo Isaac',
    'member_since' => 'August 10, 2005',
    'last_update' => 'July 19, 2005',
    'school' => "Puget Sound '09",
    'status' => 'Student',
    'sex' => 'Male',
    'residence' => 'Solola',
    'birthday' => '08/10/2001',
    'hometown' => 'Caserío Xolbé ',
    'highschool' => 'UVG',
    'email' => 'dele241921@uvg.edu.gt',
    'screenname' => 'DoctaBu',
    'mobile' => '4598-5144',
    'bio' => "I'm a computer scientist with dreams of living a peaceful life."
];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo htmlspecialchars($profile['nombre']); ?>'s Profile</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="topbar">
    <img src="imagenes/navperfil.jpg" class="banner" alt="banner" >
    <div class="topnav">  <div class="logo">[ thefacebook ]</div><a href="#">home</a> <a href="#">search</a> <a href="#">global</a> <a href="#">social net</a> <a href="#">invite</a> <a href="#">faq</a> <a href="cerrar sesion.php">logout</a></div>
</div>

<div class="page">
    <aside class="leftcol">
        <div class="searchbox">
            <form><input class="search-input" type="text">  <span>quick search </span>&nbsp;&nbsp;<button class="btn" type="button" style="color:white; background-color: #31599a; border-color: #31599a;">go</button></form>
        </div>
        <div class="box">
            <strong>My Account</strong>
            <p><a href="#">My Profile [ edit ]</a></p>
            <p><a href="#">My Friends</a></p>
            <p><a href="#">My Groups</a></p>
            <p><a href="#">My Parties</a></p>
            <p><a href="#">My Parties</a></p>
            <p><a href="#">My Messages</a></p>
            <p><a href="#">My Account</a></p>
            <p><a href="#">My Privacy</a></p>
        </div>
    <div class="centered">
            <img src="imagenes/promo.png" alt="ad" class="sidebar-ad">
        </div>
    </aside>

    <main class="mainbox">
        <div class="header">
            <div class="header-inner">
                <div><?php echo htmlspecialchars($profile['nombre']); ?>'s Profile</div>
                <div class="title-right">Puget Sound</div>
            </div>
        </div>

        <div class="content">
            <div class="profile">
                <div class="picture-column">
                    <div class="picture-box">
                        <div class="pic-title">Picture</div>
                        <div class="pic-frame">
                            <img src="imagenes/foto.jpg" alt="profile">
                        </div>
                    </div>
                            <br>
                    <div class="actions-col">
                        <div class="action-item"><button class="btn full-width-btn">Send <?php echo htmlspecialchars($profile['nombre']); ?> a Message</button></div>
                        <div class="action-item" ><button class="btn secondary full-width-btn">Poke Him!</button></div>
                    </div>

                    <div class="smallbox">
                        <div class="title">Connection</div>
                        <div class="muted">You are in a relationship with <?php echo htmlspecialchars($profile['nombre']); ?>.</div>
                    </div>

                    <div class="smallbox">
                        <div class="title">Mutual Friends</div>
                        <div class="muted">You have 19 friends in common with <?php echo htmlspecialchars($profile['nombre']); ?>.</div>
                    </div>

                    <div class="smallbox">
                        <div class="title">Access</div>
                        <div class="muted"><?php echo htmlspecialchars($profile['nombre']); ?> is currently logged in from a non-residential location.</div>
                    </div>

                    <div class="smallbox mt12">
                        <div class="title">Friends at Puget Sound</div>
                        <div class="friends-wrap">
                            <img src="imagenes/sobrino3.jpeg" class="mutual-thumb">
                            <img src="imagenes/sobrino1.jpeg" class="mutual-thumb">
                            <img src="imagenes/sobrino.jpeg" class="mutual-thumb">
                        </div>
                    </div>

                </div>

                <div class="info-column">
                    <div class="info">
                        <div class="section-title">Information</div>
                        <div class="info-grid">
                            <div class="label">Account Info:</div>
                            <div class="value">
                                <div><strong>Name:</strong> <?php echo htmlspecialchars($profile['nombre']); ?></div>
                                <div><strong>Member Since:</strong> <?php echo htmlspecialchars($profile['member_since']); ?></div>
                                <div><strong>Last Update:</strong> <?php echo htmlspecialchars($profile['last_update']); ?></div>
                            </div>

                            <div class="label">Basic Info:</div>
                            <div class="value">
                                <div><strong>School:</strong> <?php echo htmlspecialchars($profile['school']); ?></div>
                                <div><strong>Status:</strong> <?php echo htmlspecialchars($profile['status']); ?></div>
                                <div><strong>Sex:</strong> <?php echo htmlspecialchars($profile['sex']); ?></div>
                                <div><strong>Residence:</strong> <?php echo htmlspecialchars($profile['residence']); ?></div>
                                <div><strong>Birthday:</strong> <?php echo htmlspecialchars($profile['birthday']); ?></div>
                                <div><strong>Home Town:</strong> <?php echo htmlspecialchars($profile['hometown']); ?></div>
                                <div><strong>High School:</strong> <?php echo htmlspecialchars($profile['highschool']); ?></div>
                            </div>

                            <div class="label">Contact Info:</div>
                            <div class="value">
                                <div><strong>Email:</strong> <?php echo htmlspecialchars($profile['email']); ?></div>
                                <div><strong>Screenname:</strong> <?php echo htmlspecialchars($profile['screenname']); ?></div>
                                <div><strong>Mobile:</strong> <?php echo htmlspecialchars($profile['mobile']); ?></div>
                            </div>

                            <div class="label">Personal Info:</div>
                            <div class="value">
                                <div><strong>Looking For:</strong> Friendship</div>
                                <div><strong>Interested In:</strong> Women</div>
                                <div><strong>Relationship Status:</strong> In a Relationship with my life</div>
                            </div>

                            <div class="label">Bio:</div>
                            <div class="value">
                                <div><?php echo nl2br(htmlspecialchars($profile['bio'])); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>

</body>
</html>