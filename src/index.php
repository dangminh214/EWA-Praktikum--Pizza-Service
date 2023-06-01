<?php
header("Content-type: text/html");

$Prak="";
if (is_dir("Praktikum")) {
    $Prak = "<p>My Project: <a href=\"./Praktikum\">Praktikum.</a></p>";
}

echo <<<EOT
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <title>Start</title>
</head>
<body>
<header>
    <h1>Project: Pizza Service Website</h1>
</header>
<main>
    Link to website: 
    $Prak
</main>
</body>
</html>
EOT;