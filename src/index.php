<?php
header("Content-type: text/html");

$Prak="";
if (is_dir("Praktikum")) {
    $Prak = "<p>Your lab exercises are located in the folder <a href=\"./Praktikum\">Praktikum.</a></p>";
}

$Exam="";
if (is_dir("Exam")) {
    $Exam = "    <p><strong>Use the folder <a href=\"./Exam\">Exam</a> (located in src/Exam) for your solution of the examination. Do not use any other folder!</strong></p>";
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
    <h1>EWA using Docker-Containers</h1>
</header>
<main>
    <p>This is the content of the file 'index.php' in the folder 'src'!</p>
    <p>Put your own code into that folder or its subfolders!</p>
    $Exam
    <p>For working examples you may have a look at <a href="./Klausuren">recent EWA-examinations!</a></p>
    <p>The examples from the lecture are located in the folder <a href="./Demos">Demos.</a></p>
    $Prak
</main>
</body>
</html>
EOT;