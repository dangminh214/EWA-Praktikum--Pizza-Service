<?php declare(strict_types=1);

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
        $sqlAbfrage = "SELECT ordered_article_id, name, status FROM ordered_article NATURAL JOIN article ORDER BY ordered_article_id";
        $recordSet = $this->database->query($sqlAbfrage);

        if(!$recordSet)
        {
            throw new Exception("keine Bestellung vorhanden");
        }

        $bestellungArray = array();
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

        return $bestellungArray;
    }

    private function fillStatusInfo(string $orderedArticleID = "", string $name = "", string $status = ""):void
    {
        $idBestellt="bestellt" . "$orderedArticleID";
        $idImOfen="imOfen" . "$orderedArticleID";
        $idFertig="fertig" . "$orderedArticleID";
        $idUnterwegs="unterwegs" . "$orderedArticleID";
        $idGeliefert="geliefert" . "$orderedArticleID";

        $checkstatusarray = array(0 => "", 1 => "", 2 => "", 3 => "", 4 => "");

        if ($status == "0") {
            $checkstatusarray[0] = "checked";
        }
        elseif ($status == "1") {
            $checkstatusarray[1] = "checked";
        }
        elseif ($status == "2") {
            $checkstatusarray[2] = "checked";
        }
        elseif ($status == "3") {
            $checkstatusarray[3] = "checked";
        }
        else {
            $checkstatusarray[4] = "checked";
        }

        echo <<<EOT
            <div>
                <h3>$name</h3>
                <div>
                    <input type="radio" id="$idBestellt" name="$orderedArticleID" value="Bestellt" $checkstatusarray[0]><label for="$idBestellt">Bestellt</label><br>
                    <input type="radio" id="$idImOfen" name="$orderedArticleID" value="Im Ofen" $checkstatusarray[1]><label for="$idImOfen">Im Ofen</label><br>
                    <input type="radio" id="$idFertig" name="$orderedArticleID" value="Fertig" $checkstatusarray[2]><label for="$idFertig">Fertig</label><br>
                    <input type="radio" id="$idUnterwegs" name="$orderedArticleID" value="Unterwegs" $checkstatusarray[3]><label for="$idUnterwegs">Unterwegs</label><br>
                    <input type="radio" id="$idGeliefert" name="$orderedArticleID" value="Geliefert" $checkstatusarray[4]><label for="$idGeliefert">Geliefert</label><br>
                </div>
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
            <h2>Lieferstatus</h2>
            <form action="https://echo.fbi.h-da.de/" id="KundenInfos" method="post" accept-charset="UTF-8"> 
        EOT;

        if (!$data) {
            echo "Keine Bestellungen anzuzeigen";
        }
        else {
            foreach ($data as $bestellung)
            {
                $orderedArticleID = $bestellung["orderedArticleID"];
                $name = $bestellung["name"];
                $status = $bestellung["status"];
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

        if(count($_POST))
        {
            if(isset($_POST))
            {
                foreach ($_POST as $orderedArticleID => $status)
                {
                    $sqlAbfrage = "SELECT * FROM ordered_article WHERE ordered_article_id = $orderedArticleID";
                    $recordSet = $this->database->query($sqlAbfrage);

                    if($recordSet->num_rows == 0)
                    {
                        $recordSet->free();
                        throw new Exception("Keinen Artikel vorhanden");
                    }
                    else
                    {
                        $sqlAbfrage = "UPDATE ordered_article SET status = $status WHERE ordered_article_id = $orderedArticleID";
                        $recordSet = $this->database->query($sqlAbfrage);
                    }
                }
            }
        }
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
