<?php

$language = "de";

echo <<< EOT
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Kunde</title>
</head>
<body>
    <h2>Lieferstatus</h2>
    <form action="https://echo.fbi.h-da.de/" id="KundenInfos" method="post" accept-charset="UTF-8"> 
</body>
EOT;

$kunden = array(
    array(
        "id" => 1,
        "type" => "Margherita",
        "status" => "bestellt"
    ),

    array(
        "id" => 2,
        "type" => "Salami",
        "status" => "im Ofen"
    ),

    array(
        "id" => 3,
        "type" => "Tonno",
        "status" => "fertig"
    ),

    array(
        "id" => 4,
        "type" => "Hawaii",
        "status" => "bestellt"
    )
);

foreach ($kunden as $kunde){
    echo <<< EOT
        <p>$kunde[type]: $kunde[status]</p>
    EOT;
};
echo <<< EOT
        <input type="submit" id="submit" value="Neue Bestellung">
    </form>
</body>
</html>
EOT;

