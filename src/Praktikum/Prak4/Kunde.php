<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€
require_once './Page.php';
class Kunde extends Page
{
    protected function __construct()
    {
        parent::__construct();
    }
    public function __destruct()
    {
        parent::__destruct();
    }
    protected function getViewData():array
    {
        $bestellungArray = array();
        session_start();
        if($_SESSION) {
            $last_ordering_id  = $_SESSION['last_ordering_id'];
            $sqlAbfrage =
                "SELECT ordered_article_id, name, status 
                FROM ordered_article 
                NATURAL JOIN article 
                WHERE ordering_id = $last_ordering_id
                ORDER BY ordered_article_id"
            ;
            $recordSet = $this->database->query($sqlAbfrage);

            if(!$recordSet)
            {
                throw new Exception("keine Bestellung vorhanden");
            }


            $count = 0;

            $record = $recordSet->fetch_assoc();
            while ($record)
            {
                $bestellungArray[$count]["orderedArticleID"] = $record["ordered_article_id"];
                $bestellungArray[$count]["name"] = $record["name"];
                $bestellungArray[$count]["status"] = $record["status"];
                $record = $recordSet->fetch_assoc();
                $count++;
            }
            $recordSet->free();
        }


        return $bestellungArray;
    }

    private function fillStatusInfo(string $orderedArticleID = "", string $article_name = "", string $status = ""):void
    {
        $idBestellt="bestellt" . "$orderedArticleID";
        $idImOfen="imOfen" . "$orderedArticleID";
        $idFertig="fertig" . "$orderedArticleID";
        $idUnterwegs="unterwegs" . "$orderedArticleID";
        $idGeliefert="geliefert" . "$orderedArticleID";

        $checkstatusarray = array(0 => "", 1 => "", 2 => "", 3 => "", 4 => "");

        if ($status == "0") {
            $checkstatusarray[0] = "bestellt";
        }
        elseif ($status == "1") {
            $checkstatusarray[1] = "im Ofen";
        }
        elseif ($status == "2") {
            $checkstatusarray[2] = "fertig";
        }
        elseif ($status == "3") {
            $checkstatusarray[3] = "unterwegs";
        }
        else {
            $checkstatusarray[4] = "geliefert";
        }

        echo <<<EOT
            <div id="article_info">
                <h3 id="article_info_name">$article_name: </h3>
                <p id="article_info_status">$checkstatusarray[$status]</p>
            </div>
            <br>
        EOT;

    }
    protected function generateView():void
    {
        $data = $this->getViewData();
        $sec = "10";
        $page = $_SERVER['PHP_SELF'];
        header("Refresh: $sec; url = $page");
        $this->generatePageHeader('Kunde');
        echo <<< EOT
            <script src="StatusUpdate.js"></script>
            <h1>Lieferstatus</h1>
            <form action="https://echo.fbi.h-da.de/" id="KundenInfos" method="post" accept-charset="UTF-8">
        EOT;
        if (!$_SESSION) {
            echo "Keine letzte Bestellung";
        }
        else {
            foreach ($data as $bestellung)
            {
                $orderedArticleID = htmlspecialchars($bestellung["orderedArticleID"]);
                $name = htmlspecialchars($bestellung["name"]);
                $status = htmlspecialchars($bestellung["status"]);

                $this->fillStatusInfo($orderedArticleID, $name, $status);
            }

            echo <<< EOT
                <input type="submit" id="submit" value="Neue Bestellung">
            </form>
        </body>
        EOT;
        }


        $this->generatePageFooter();
    }
    protected function processReceivedData():void
    {
        parent::processReceivedData();
    }
    public static function main():void
    {
        try {
            $page = new Kunde();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Kunde::main();
