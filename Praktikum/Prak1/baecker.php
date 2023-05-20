<?php

$language = "de";

echo <<< EOT
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bäcker*in</title>
</head>
<body>
    <h2>Bestellte Pizzen</h2>
    <form action="https://echo.fbi.h-da.de/" id="BackerInfos" method="post" accept-charset="UTF-8">
        <table>
            <tr>
                <th></th>
                <th>bestellt</th>
                <th>im Ofen</th>
                <th>fertig</th>
            </tr>
EOT;

$bestellungs = array(
    array(
        "id" => 1,
        "status" => "bestellt",
        "type" => "Margherita"
    ),

    array(
        "id" => 2,
        "status" => "im Ofen",
        "type" => "Tonno"
    ),

    array(
        "id" => 3,
        "status" => "im Ofen",
        "type" => "Prosciutto"
    ),

    array(
        "id" => 4,
        "status" => "fertig",
        "type" => "Salami"
    ),

    array(
        "id" => 5,
        "status" => "fertig",
        "type" => "Prosciutto"
    )
);

foreach ($bestellungs as $bestellung) {
    $idBestellt="bestellt" . "$bestellung[id]";
    $idOfen="ofen" . "$bestellung[id]";
    $idFertig="fertig" . "$bestellung[id]";

    $checkstatusarray = array(0 => "", 1 => "", 2 => "");

    if($bestellung['status'] == "fertig"){
        $checkstatusarray[2] = "checked";
    }
    elseif ($bestellung['status'] == "im Ofen"){
        $checkstatusarray[1] = "checked";
    }
    else{
        $checkstatusarray[0] = "checked";
    }

    echo <<<EOT
        <tr>
            <td>$bestellung[type]</td>
            <td><label> <input type="radio" id="$idBestellt" name="$bestellung[type]" value="bestellt" $checkstatusarray[0]></label></td>
            <td><label> <input type="radio" id="$idOfen" name="$bestellung[type]" value="im Ofen" $checkstatusarray[1]></label></td>
            <td><label> <input type="radio" id="$idFertig" name="$bestellung[type]" value="fertig" $checkstatusarray[2]></label></td>
        </tr>
    EOT;
};

echo <<<EOT
    </table>
    <input type="submit" id="submit" value="Bestätigen">
</form>
</body>
</html>
EOT;

