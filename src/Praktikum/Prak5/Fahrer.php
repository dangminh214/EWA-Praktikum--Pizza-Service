<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€
/**
 * Class PageTemplate for the exercises of the EWA lecture
 * Demonstrates use of PHP including class and OO.
 * Implements Zend coding standards.
 * Generate documentation with Doxygen or phpdoc
 *
 * PHP Version 7.4
 *
 * @file     PageTemplate.php
 * @package  Page Templates
 * @author   Bernhard Kreling, <bernhard.kreling@h-da.de>
 * @author   Ralf Hahn, <ralf.hahn@h-da.de>
 * @version  3.1
 */

// to do: change name 'PageTemplate' throughout this file
require_once './Page.php';
class Fahrer extends Page
{
    protected function __construct()
    {
        parent::__construct();
        // to do: instantiate members representing substructures/blocks
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    private function preprocessData()
    {
        $sqlAbfrage = "SELECT * FROM ordering";
        $recordSet = $this->database->query($sqlAbfrage);
        if (!$recordSet) {
            throw new Exception("Keine Bestellung in Datenbank vorhanden");
        }

        $geliefertPizzas = array();
        $record = $recordSet->fetch_assoc();
        while ($record) {
            $orderingID = $record["ordering_id"];
            $oID = $this->database->real_escape_string($orderingID);
            $pizzaAbfrage = "SELECT ordering_id, name, status, price FROM ordered_article NATURAL JOIN article WHERE ordering_id = \"$oID\"  ORDER BY ordering_id";
            $pizzaRecord = $this->database->query($pizzaAbfrage);
            $recordOrder = $pizzaRecord->fetch_assoc();

            $allStatus = array();

            while ($recordOrder) {
                array_push($allStatus, $recordOrder["status"]);
                $recordOrder = $pizzaRecord->fetch_assoc();
            }
            $pizzaRecord->free();

            if (min($allStatus) === "4") {
                array_push($geliefertPizzas, $orderingID);
            }
            $record = $recordSet->fetch_assoc();
        }
        $recordSet->free();

        foreach ($geliefertPizzas as $geliefertPizzaID) {
            $SQLabfrage = "DELETE FROM ordering WHERE ordering_id = '$geliefertPizzaID'";
            $this->database->query($SQLabfrage);
        }
    }

    protected function getViewData(): array
    {
        $this->preprocessData();
        $sqlAbfrage = "SELECT * FROM ordering";
        $recordSet = $this->database->query($sqlAbfrage);
        if (!$recordSet) {
            throw new Exception("Keine Bestellung in Datenbank vorhanden");
        }

        $lieferArray = array();
        $count = 0;

        $record = $recordSet->fetch_assoc();
        while($record)
        {
            $orderingID = $record["ordering_id"];

            $oID = $this->database->real_escape_string($orderingID);
            $pizzaAbfrage = "SELECT ordering_id, name, status, price 
            FROM ordered_article 
            NATURAL JOIN article 
            WHERE ordering_id = \"$oID\" 
            ORDER BY ordering_id";
            $pizzaRecordSet = $this->database->query($pizzaAbfrage);
            $pizzaRecord = $pizzaRecordSet->fetch_assoc();

            $totalPrice = 0;
            $pizzaList = "";
            $pizzaStatus = array();

            while ($pizzaRecord)
            {
                if($pizzaRecord["ordering_id"] == $orderingID)
                {
                    $totalPrice += $pizzaRecord["price"];
                    array_push($pizzaStatus, $pizzaRecord["status"]);
                    if($pizzaList == "")
                    {
                        $pizzaList = $pizzaRecord["name"];
                    }
                    else
                    {
                        $pizzaList = $pizzaList.", ".$pizzaRecord["name"];
                    }
                }
                $pizzaRecord = $pizzaRecordSet->fetch_assoc();
            }
            $pizzaRecordSet->free();

            $number = intval(min($pizzaStatus)[0]);
            if ($number < 2) {
                $record = $recordSet->fetch_assoc();
                $count++;
                continue;
            }

            $lieferArray[$count]["orderingID"] = $record["ordering_id"];
            $lieferArray[$count]["address"] = $record["address"];
            $lieferArray[$count]["orderingTime"] = $record["ordering_time"];
            $lieferArray[$count]["totalPrice"] = (string)$totalPrice. "€";
            $lieferArray[$count]["pizzaList"] = $pizzaList;
            $lieferArray[$count]["pizzaStatus"] = (string) min($pizzaStatus);
            $record = $recordSet->fetch_assoc();
            $count++;
        }
        $recordSet->free();
        return $lieferArray;
    }

    private function fillStatusInfo(string $orderingID = "", string $address = "", string $orderingTime = "", string $totalPrice = "", string $pizzaList = "", string  $status = "")
    {
        $idFertig="fertig" . "$orderingID";
        $idUnterwegs="unterwegs" . "$orderingID";
        $idGeliefert="geliefert" . "$orderingID";
        $formID = "ID" . $orderingID;

        $checkstatusarray = array(0 => "", 1 => "", 2 => "");

        if ($status == "2") {
            $checkstatusarray[0] = "checked";
        }
        elseif ($status == "3") {
            $checkstatusarray[1] = "checked";
        }
        elseif ($status == "4") {
            $checkstatusarray[2] = "checked";
        }


            echo <<<EOT
        <form id="$formID" action="Fahrer.php" method="post" lang="de" accept-charset="UTF-8"></form>
        <div class="pizzaInfos">
            <table>
                <tr>
                    <td>$address</td>
                </tr>
                <tr>
                    <td>$orderingTime</td>
                </tr>
                <tr>
                    <td>$pizzaList: $totalPrice</td>
                </tr>
                <tr>
                    <td>
                        <table>
                        <tr>
                            <td>
                                <input form="$formID" type="radio" id="$idFertig" name="pizzaStatus" value="Fertig" onclick="document.forms['$formID'].submit();" $checkstatusarray[0]>
                                <label for="$idFertig">Fertig</label><br>
                            </td>
                            <td>
                                <input form="$formID" type="radio" id="$idUnterwegs" name="pizzaStatus" value="Unterwegs" onclick="document.forms['$formID'].submit();" $checkstatusarray[1]>
                                <label for="$idUnterwegs">Unterwegs</label><br>
                            </td>
                            <td>
                                <input form="$formID" type="radio" id="$idGeliefert" name="pizzaStatus" value="Geliefert" onclick="document.forms['$formID'].submit();" $checkstatusarray[2]>
                                <label for="$idGeliefert">Geliefert</label><br>
                            </td>
                        </tr>
                        </table>
                        <input form="$formID" type="hidden" name="orderID" value=$orderingID>
                    </td>
                </tr>
            </table>
        </div>
EOT;
}


    protected function generateView(): void
    {
        $data = $this->getViewData();

        $sec = "10";
        $page = $_SERVER['PHP_SELF'];
        header("Refresh: $sec; url=$page");

        $this->generatePageHeader('Fahrer');

        echo <<< HTML
            <h1>Auslieferbare Bestellungen</h1>   
             <nav class="horizontal_nav">
            <ul>
                <li class="horizontal-li"> <a href="Uebersicht.php">Übersicht</a></li>
                <li class="horizontal-li" ><a href="Bestellung.php">Bestellung</a></li>
                <li class="horizontal-li"><a href="Kunde.php">Kunde</a></li>
                <li class="horizontal-li"><a href="Baecker.php">Bäcker</a></li>
                <li class="horizontal-li"><a href="Fahrer.php">Fahrer</a></li>
            </ul>
        </nav>   
 HTML;
        if (sizeof($data) != 0) {
            foreach ($data as $liefer) {
                $orderingID = htmlspecialchars($liefer["orderingID"], ENT_QUOTES, 'UTF-8');
                $address = htmlspecialchars($liefer["address"], ENT_QUOTES, 'UTF-8');
                $orderingTime = htmlspecialchars($liefer["orderingTime"], ENT_QUOTES, 'UTF-8');
                $totalPrice = htmlspecialchars($liefer["totalPrice"], ENT_QUOTES, 'UTF-8');
                $pizzaList = htmlspecialchars($liefer["pizzaList"], ENT_QUOTES, 'UTF-8');
                $status = htmlspecialchars($liefer["pizzaStatus"], ENT_QUOTES, 'UTF-8');
                $this->fillStatusInfo($orderingID, $address, $orderingTime, $totalPrice, $pizzaList, $status);
            }
        }

        $this->generatePageFooter();
    }

    protected function processReceivedData(): void
    {
        parent::processReceivedData();

        if (count($_POST)) {
            if (isset($_POST["orderID"]) && isset($_POST["pizzaStatus"])) {
                $orderingID = $this->database->real_escape_string($_POST["orderID"]);
                $status = $this->database->real_escape_string($_POST["pizzaStatus"]);

                $sqlAbfrage = "SELECT * FROM ordering WHERE ordering_id = '$orderingID'";
                $RecordSet = $this->database->query($sqlAbfrage);

                if ($RecordSet->num_rows == 0) {
                    $RecordSet->free();
                    throw new Exception("Keine Bestellung gefunden!");
                } else {
                    if ($status == "Fertig") {
                        $status = "2";
                    } elseif ($status == "Unterwegs") {
                        $status = "3";
                    } else {
                        $status = "4";
                    }

                    $sqlAbfrage = "UPDATE ordered_article SET status = $status WHERE ordering_id = '$orderingID';";
                    $this->database->query($sqlAbfrage);
                }
            }
        }
    }

    public static function main(): void
    {
        try {
            $page = new Fahrer();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}
Fahrer::main();

