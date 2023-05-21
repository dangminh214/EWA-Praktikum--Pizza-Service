<?php

$language = "de";

echo <<< EOT
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bestellung</title>
</head>
<body>
    <h1>Bestellung</h1>
</body>
EOT;

$speisen = array(
    array(
        "id" => 1,
        "name" => "Margherita",
        "price" => 4.00
    ),

    array(
        "id" => 2,
        "name" => "Salami",
        "price" => 4.50
    ),

    array(
        "id" => 3,
        "name" => "Hawaii",
        "price" => 5.50
    )
);

foreach ($speisen as $speise){
    echo <<< EOT
        <div>
            <img src="img/pizza/$speise[name].jpg" width="250" height="250" alt="" title="$speise[name]"/>
            <p>$speise[name]</p>
            <p>$speise[price] &euro;</p>
        </div>
    EOT;
};

echo <<< EOT
    <h2>Warenkorb</h2>
    <form action="https://echo.fbi.h-da.de/" id="BestellungsInfos" method="post" accept-charset="UTF-8">
        <select name="warenkorb[]" multiple="multiple" size="5">
EOT;

foreach ($speisen as $speise) {
    echo <<< EOT
            <option value="$speise[id]">$speise[name]</option>
EOT;
};

echo <<< EOT
        </select>
        <p>Gesamtpreis: 14 &euro;</p>
        <input type="text" name="address" size="30" maxlength="60" placeholder="Ihre Adresse" required>
        <br>
        <input type="reset" value="Alle Löschen">
        <input type="reset" value="Auswahl Löschen">
        <input type="submit" value="Bestellen">
    </form>
</body>
</html>
EOT;
