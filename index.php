<?php
    require_once("./include/db.class.php");
    require_once("./include/functions.php");
    $db = new db();
?>

<!doctype html>
<html>
    <head>
        <?php generateHead("Mindfakt - Home"); ?>
    </head>

    <body>
        <header>
            <?php generateNavigation("home"); ?>
        </header>

        <main>
            <article id="slider">
                <h1>Mindfakt - Quizze und Dominiere deine Freunde</h1>
                <h2>Dein spaßiges Online-Quiz.</h2>
                <p>Werde Teil unserer Quiz-Community und messe dich mit Spielern aus ganz Deutschland.</p>
                <section id="btn-home"><a id="btn-register" class="button" href="./register.php">Jetzt Registrieren</a>
                    <a id="btn-quiz" class="button" href="./quiz.php">Jetzt Quizzen</a></section>
            </article>
        </main>

        <footer>

        </footer>
    </body>
</html>