<?php
    require_once("./include/db.class.php");
    require_once("./include/functions.php");
    $db = new db();
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta description="Quizze und Dominiere deine Freunde auf Mindfakt, der Online-Quiz Plattform">
        <link rel="shortcut icon" type="image/x-icon" href="./include/pictures/favicon.ico">
        <link rel="stylesheet" href="./include/css/main.css">
        <script src="./include/js/main.js"></script>
        <title>Mindfakt</title>
    </head>

    <body>
        <header>
            <a href="./index.php"><img id="logo" src="./include/pictures/logo.png" alt="Mindfakt Logo"></a>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="./quiz.php">Quiz</a></li>
                    <li><a href="./contact.php">Kontakt</a></li>
                </ul>
                <a href="./profile.php"><img id="profile-img" src="./include/pictures/user-profile-image.png" alt="Mindfakt Benutzer"></a>
            </nav>
        </header>

        <main>
            <article id="slider">
                <h1>Lege Jetzt dein Mindfakt Profil an und Dominiere deine Freunde</h1>
                <h2>Werde jetzt kostenlos Mitglied.</h2>
                <p>Werde Teil unserer Quiz-Community und messe dich mit Spielern aus ganz Deutschland.</p>
                <section id="btn-home"><a id="btn-register" class="button" href="./quiz.php">Jetzt Registrieren</a></section>
            </article>
        </main>

        <footer>

        </footer>
    </body>
</html>