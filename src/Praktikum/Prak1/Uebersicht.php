<?php
echo <<<HERE
    <!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Übersicht</title>
    <style>
        .horizontal_nav {
            display: flex;
            justify-content: center;
        }
        .horizontal_nav .horizontal-li{
            display: inline-block;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }

        .vertical_nav {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .vertical_li {
            list-style-type: none;
            padding-top: 20px;
            text-align: center;
        }

    </style>
</head>
<body>
    <h1>Pizza Service</h1>
    <section>
        <nav class="horizontal_nav">
            <ul>
                <li class="horizontal-li">Übersicht</li>
                <li class="horizontal-li">Bestellung</li>
                <li class="horizontal-li">Kunde</li>
                <li class="horizontal-li">Bäcker</li>
                <li class="horizontal-li">Fahrer</li>
            </ul>
        </nav>
        <nav class="vertical_nav">
            <ul>
                <li class="vertical_li">Übersicht</li>
                <li class="vertical_li">Bestellung</li>
                <li class="vertical_li">Kunde</li>
                <li class="vertical_li">Bäcker</li>
                <li class="vertical_li">Fahrer</li>
            </ul>
        </nav>
    </section>
</body>
</html>
HERE;
