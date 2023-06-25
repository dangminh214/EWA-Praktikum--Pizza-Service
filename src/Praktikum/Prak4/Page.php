<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€
abstract class Page
{
    // --- ATTRIBUTES ---

    /**
     * Reference to the MySQLi-Database that can be used
     * by all operations of the class or inherited classes.
     */
    protected MySQLi $database;

    // --- OPERATIONS ---

    /**
     * Connects to DB and stores
     * the connection in member $_database.
     * Needs name of DB, user, password.
     */
    protected function __construct()
    {
        error_reporting(E_ALL);
        $host = "localhost";
        /********************************************/
        // This code switches from the the local installation (XAMPP) to the docker installation
        if (gethostbyname('mariadb') != "mariadb") { // mariadb is known?
            $host = "mariadb";
        }
        /********************************************/
        $this->database = new MySQLi($host, "public", "public", "pizzaservice");

        if (mysqli_connect_errno()) {
            throw new Exception("Connect failed: " . mysqli_connect_error());
        }

        // set charset to UTF8!!
        if (!$this->database->set_charset("utf8")) {
            throw new Exception($this->database->error);
        }
    }
    public function __destruct()
    {
        // to do: close database
    }
    protected function generatePageHeader(string $title = "", string $jsFile = "", bool $autoreload = false):void
    {
        $title = htmlspecialchars($title);
        header("Content-type: text/html; charset=UTF-8");
        echo <<<EOT
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" type="text/css" href="Bestellung.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>$title</title>
</head>
<body>
EOT;
    }
    protected function generatePageFooter():void
    {
        echo <<<EOT
    </body>
    <footer>
    <p style="margin-left: 20px; font-size: 30px">Pizza Shop</p>
    <p>Contact: dangminh214@gmail.com</p>
    <p> All rights reserved.</p>
    <div>
        <p>Hochschule Darmstadt</p> 
        <p>Fachbereich Informatik</p>
    </div>
    <p style="margin-right: 20px" >&copy; 2023 PizzaService</p> 
  </footer>
</html>
EOT;
    }
    protected function processReceivedData():void
    {

    }
} // end of class
