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
    protected function getViewData():array
    {
        $sqlAbfrage = "SELECT * FROM ordering";
        $recordSet = $this->database->query($sqlAbfrage);
        if(!$recordSet)
        {
            throw new Exception("Keine Bestellung in Datenbank");
        }
        $lieferArray = array();
        $count = 0;

        $record = $recordSet->fetch_assoc();
        while($record)
        {
            $lieferArray[$count]["orderingID"] = $record["ordering_id"];
            $lieferArray[$count]["address"] = $record["address"];
            $lieferArray[$count]["orderingTime"] = $record["ordering_time"];

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

            $lieferArray[$count]["totalPrice"] = (string)$totalPrice. "€";
            $lieferArray[$count]["pizzaList"] = $pizzaList;
            $lieferArray[$count]["pizzaStatus"] = (string) min($pizzaStatus);
            $record = $recordSet->fetch_assoc();
            $count++;
        }
        $recordSet->free();
        return $lieferArray;
    }
    private function fillStatusInfo(string $orderingID = "", string $address = "", string $orderingTime = "", string $totalPrice = "", string $pizzaList = "", string  $status = ""): void
    {
        $idFertig="fertig" . "$orderingID";
        $idUnterwegs="unterwegs" . "$orderingID";
        $idGeliefert="geliefert" . "$orderingID";

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

        echo <<< EOT
        <div>
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
                    <table>
                        <tr>
                        <form id="$orderingID" action="Fahrer.php" method="post" accept-charset="UTF-8">
                            <td><input form="$orderingID" type="radio" id="$idFertig" name="pizzaStatus" value="2" $checkstatusarray[0] onclick="this.form.submit();"><label for="$idFertig"></label>Fertig</label><br></td>
                            <td><input form="$orderingID" type="radio" id="$idUnterwegs" name="pizzaStatus" value="3" $checkstatusarray[1] onclick="this.form.submit();"><label for="$idUnterwegs"><label>Unterwegs</label><br></td>
                            <td><input form="$orderingID" type="radio" id="$idGeliefert" name="pizzaStatus" value="4" $checkstatusarray[2] onclick="this.form.submit();"><label for="$idGeliefert"><label>Geliefert</label><br></td>
                        </tr>                                                     
                    </table>
                    
                </tr>
                <tr>
                    <input form="$orderingID" type="hidden" name="orderingID" value=$orderingID>
                </tr>
            </table>
            </form>
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
        $this->generatePageHeader('Fahrer');

        echo <<< EOT
            <h2>Auslieferbare Bestellungen</h2>      
        EOT;

        foreach ($data as $liefer) {
            $status = $liefer["pizzaStatus"];
            if($status == "2" || $status == "3")
            {
                $orderingID = htmlspecialchars($liefer["orderingID"], ENT_QUOTES, 'UTF-8');
                $address = htmlspecialchars($liefer["address"], ENT_QUOTES, 'UTF-8');
                $orderingTime = htmlspecialchars($liefer["orderingTime"], ENT_QUOTES, 'UTF-8');
                $totalPrice = htmlspecialchars($liefer["totalPrice"], ENT_QUOTES, 'UTF-8');
                $pizzaList = htmlspecialchars($liefer["pizzaList"], ENT_QUOTES, 'UTF-8');
                $this->fillStatusInfo($orderingID, $address, $orderingTime, $totalPrice, $pizzaList, $status);
            }
        }

        echo <<<EOT
        </body>
        EOT;

        $this->generatePageFooter();
    }
    protected function processReceivedData():void
    {
        parent::processReceivedData();

        if(count($_POST))
        {
            if(isset($_POST["pizzaStatus"]) && isset($_POST["orderingID"]))
            {
                $orderingID = $this->database->real_escape_string($_POST["orderingID"]);
                $status = $this->database->real_escape_string($_POST["pizzaStatus"]);

                $sqlAbfrage = "SELECT * FROM ordering WHERE ordering_id = \"$orderingID\";";
                $recordSet = $this->database->query($sqlAbfrage);

                if($recordSet->num_rows == 0)
                {
                    $recordSet->free();
                    throw new Exception("Keine Bestellung vorhanden");
                }

                else{
                    $sqlAbfrage = "UPDATE ordered_article SET status = \"$status\" WHERE ordering_id = \"$orderingID\";";
                    $this->database->query($sqlAbfrage);
                }
            }
        }
    }

    public static function main():void
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
