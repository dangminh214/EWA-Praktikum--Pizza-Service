<?php

$language = "de";

echo <<< EOT
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Fahrer</title>
</head>
<body>
    <h2>Auslieferbare Bestellungen</h2>
    <form action="https://echo.fbi.h-da.de/" id="LieferInfos" method="post" accept-charset="UTF-8">       
EOT;

$liefers = array(
    array(
        "id" => 1,
        "name" => "Schulz",
        "address" => "Kasinostr. 5",
        "price" => 13.50,
        "orders" => "Margherita, Salami, Tonno",
        "status" => "unterwegs"
    ),

    array(
        "id" => 2,
        "name" => "Müller",
        "address" => "Rheinstr. 11",
        "price" => 10.00,
        "orders" => "Salami, Prosciutto",
        "status" => "fertig"
    ),
);

foreach ($liefers as $liefer){
    $idFertig = "fertig" . "$liefer[id]";
    $idUnterwegs = "unterwegs" . "$liefer[id]";
    $idGeliefert = "geliefert" . "$liefer[id]";

    $checkstatusarray = array(0 => "", 1 => "", 2 => "");

    if($liefer['status'] == "geliefert"){
        $checkstatusarray[2] = "checked";
    }
    elseif ($liefer['status'] == "unterwegs"){
        $checkstatusarray[1] = "checked";
    }
    else{
        $checkstatusarray[0] = "checked";
    }

    echo <<< EOT
        <table>
            <tr>
                <td>$liefer[name], $liefer[address]</td>
                <td>$liefer[price] &euro;</td>
            </tr>
            <tr>
                <td>$liefer[orders]</td>
            </tr>
        </table>
        <table>
            <tr>
                <td>fertig</td>
                <td>unterwegs</td>
                <td>geliefert</td>
            </tr>
            <tr>
                <td><label> <input type="radio" id="$idFertig" name="$liefer[name]" value="fertig" $checkstatusarray[0]></label></td>
                <td><label> <input type="radio" id="$idUnterwegs" name="$liefer[name]" value="unterwegs" $checkstatusarray[1]></label></td>
                <td><label> <input type="radio" id="$idGeliefert" name="$liefer[name]" value="geliefert" $checkstatusarray[2]></label></td>
            </tr>
        </table>
        <br>
EOT;
};

echo <<<EOT
    <input type="submit" id="submit" value="Bestätigen">
</form>
</body>
</html>
EOT;

