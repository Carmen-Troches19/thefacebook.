<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Profile</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="topbar">
    <img src="imagenes/navperfil.jpg" class="banner" alt="banner">
    <div class="topnav">
        <div class="logo">[ thefacebook ]</div>
        <a href="#">home</a>
        <a href="#">search</a>
        <a href="#">global</a>
        <a href="#">social net</a>
        <a href="#">invite</a>
        <a href="#">faq</a>
        <a href="cerrar sesion.php">logout</a>
    </div>
</div>

<div class="page">

    <aside class="leftcol">

        <div class="searchbox">
            <form>
                <input class="search-input" type="text">
                <span>quick search</span>&nbsp;&nbsp;
                <button class="btn" type="button" 
                    style="color:white; background-color:#7aa9ee; border-color:#7aa9ee;">go</button>
            </form>
        </div>

        <div class="box">
            <strong>My Account</strong>
            <p><a href="#">My Profile [ edit ]</a></p>
            <p><a href="#">My Friends</a></p>
            <p><a href="#">My Groups</a></p>
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
                <div>Carmen Victoria Troches Lopez's Profile</div>
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
                        <div class="action-item">
                            <button class="btn full-width-btn">
                                Send a Message
                            </button>
                        </div>

                        <div class="action-item">
                            <button class="btn secondary full-width-btn">
                                Poke Her!
                            </button>
                        </div>
                    </div>

                    <div class="smallbox">
                        <div class="title">Connection</div>
                        <div class="muted">
                            You are in a relationship with Isaias Troches Lopez.
                        </div>
                    </div>

                    <div class="smallbox">
                        <div class="title">Mutual Friends</div>
                        <div class="muted">
                            You have 19 friends in common with Isaias Troches Lopez.
                        </div>
                    </div>

                    <div class="smallbox">
                        <div class="title">Access</div>
                        <div class="muted">
                            Currently logged in from a non-residential location.
                        </div>
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
                                <div><strong>Name:</strong> Carmen Victoria Troches Lopez</div>
                                <div><strong>Member Since:</strong> August 09, 2006</div>
                                <div><strong>Last Update:</strong> September 19, 2006</div>
                            </div>

                            <div class="label">Basic Info:</div>
                            <div class="value">
                                <div><strong>School:</strong> Universidad del Valle de Guatemala</div>
                                <div><strong>Status:</strong> Student</div>
                                <div><strong>Sex:</strong> Female</div>
                                <div><strong>Residence:</strong> Quetzaltenango</div>
                                <div><strong>Birthday:</strong> 07/29/2006</div>
                                <div><strong>Home Town:</strong> Las 7 Esquinas</div>
                                <div><strong>High School:</strong> UVG</div>
                            </div>

                            <div class="label">Contact Info:</div>
                            <div class="value">
                                <div><strong>Email:</strong> tro241985@uvg.edu.gt</div>
                                <div><strong>Screenname:</strong> CarmenVTLopez</div>
                                <div><strong>Mobile:</strong> 36024130</div>
                            </div>

                            <div class="label">Personal Info:</div>
                            <div class="value">
                                <div><strong>Looking For:</strong> Friendship</div>
                                <div><strong>Interested In:</strong> Women</div>
                                <div><strong>Relationship Status:</strong> In a Relationship</div>
                            </div>

                            <div class="label">Bio:</div>
                            <div class="value">
                                <div>
                                    I am a computer scientist with the dream of living off my dreams.
                                </div>
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
