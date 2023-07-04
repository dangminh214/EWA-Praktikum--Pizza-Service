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

    //Generate JSON File
    protected function generateView():void
    {
        $list = $this->getViewData();
        $jsonString = json_encode($list);
        echo $jsonString;
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
