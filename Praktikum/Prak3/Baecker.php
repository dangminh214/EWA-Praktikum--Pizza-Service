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

/**
 * This is a template for top level classes, which represent
 * a complete web page and which are called directly by the user.
 * Usually there will only be a single instance of such a class.
 * The name of the template is supposed
 * to be replaced by the name of the specific HTML page e.g. baker.
 * The order of methods might correspond to the order of thinking
 * during implementation.
 * @author   Bernhard Kreling, <bernhard.kreling@h-da.de>
 * @author   Ralf Hahn, <ralf.hahn@h-da.de>
 */
class Baecker extends Page
{
    // to do: declare reference variables for members
    // representing substructures/blocks

    /**
     * Instantiates members (to be defined above).
     * Calls the constructor of the parent i.e. page class.
     * So, the database connection is established.
     * @throws Exception
     */
    protected function __construct()
    {
        parent::__construct();
        // to do: instantiate members representing substructures/blocks
    }

    /**
     * Cleans up whatever is needed.
     * Calls the destructor of the parent i.e. page class.
     * So, the database connection is closed.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Fetch all data that is necessary for later output.
     * Data is returned in an array e.g. as associative array.
     * @return array An array containing the requested data.
     * This may be a normal array, an empty array or an associative array.
     */
    protected function getViewData():array
    {
        $sqlRequestCommand = "SELECT* FROM ordered_article";
        $recordSet = $this->database->query($sqlRequestCommand);
        if (!$recordSet) {
            throw new Exception("kein ordered_article table in der Datenbank");
        }
        $bestellung = array();

        // Benoetigte Eintraege für HTML-Ausgabe auslesen
        while ($record= $recordSet->fetch_assoc()) {
            $my_ordered_article_id = $record["ordered_article_id"];
            $my_ordering_id = $record["ordering_id"];
            $my_article_id = $record["article_id"];
            $my_status = $record["status"];

            //assign each row to an element of $bestellung array
            $bestellung[] = array(
                "ordered_article_id" => $my_ordered_article_id,
                "ordering_id" => $my_ordering_id,
                "article_id" => $my_article_id,
                "status" =>$my_status
            );
        }

        $recordSet->free();

        return $bestellung;
    }
    /**
     * First the required data is fetched and then the HTML is
     * assembled for output. i.e. the header is generated, the content
     * of the page ("view") is inserted and -if available- the content of
     * all views contained is generated.
     * Finally, the footer is added.
     * @return void
     */
    protected function generateView():void
    {
        $bestellung = $this->getViewData();
        $this->generatePageHeader('Bäcker'); //to do: set optional parameters
        // to do: output view of this page
        echo <<<HERE
        <h1>Bestellte Pizzen</h1>
        <form action="https://echo.fbi.h-da.de/" id="BackerInfos" method="post" accept-charset="UTF-8" target="_blank">
        <table>
            <tr>
                <th></th>
                <th>bestellt</th>
                <th>im Ofen</th>
                <th>fertig</th>
                <th>unterwegs</th>
            </tr>
HERE;
        foreach ($bestellung as $row_bestellung) {
            $idBestellt="bestellt" . "$row_bestellung[ordered_article_id]";
            $idOfen="ofen" . "$row_bestellung[ordered_article_id]";
            $idFertig="fertig" . "$row_bestellung[ordered_article_id]";
            $idUnterwegs = "unterwegs" . "$row_bestellung[ordered_article_id]";

            $checkstatusarray = array(0 => "", 1 => "", 2 => "", 3=>"");

            if($row_bestellung['status'] == "0"){
                $checkstatusarray[0] = "checked";
            }
            elseif ($row_bestellung['status'] == "1"){
                $checkstatusarray[1] = "checked";
            }
            elseif ($row_bestellung['status'] == "2") {
                $checkstatusarray[2] = "checked";
            }
            else{
                $checkstatusarray[3] = "checked";
            }

            $article_array = array(1=>"Salami", 2=>"Vegeteria", 3=>"Spinat-Hünchen");

            echo <<<EOT
        <tr>
            <td>{$article_array[$row_bestellung['article_id']]} : Ordering ID: {$row_bestellung['ordering_id']} </td>
            <td><label> <input type="radio" id="$idBestellt" name="$row_bestellung[ordered_article_id]" value="bestellt" $checkstatusarray[0]></label></td>
            <td><label> <input type="radio" id="$idOfen" name="$row_bestellung[ordered_article_id]" value="im Ofen" $checkstatusarray[1]></label></td>
            <td><label> <input type="radio" id="$idFertig" name="$row_bestellung[ordered_article_id]" value="fertig" $checkstatusarray[2]></label></td>
            <td><label> <input type="radio" id="$idUnterwegs" name="$row_bestellung[ordered_article_id]" value="unterwegs" $checkstatusarray[3]></label></td>
        </tr>       
    EOT;
        };
        echo <<<EOT
            </table>
            <input type="submit" id="submit" value="Bestätigen">
            </form>
EOT;
            $this->generatePageFooter();
    }
    /**
     * Processes the data that comes via GET or POST.
     * If this page is supposed to do something with submitted
     * data do it here.
     * @return void
     */
    protected function processReceivedData():void
    {
        parent::processReceivedData();
        // to do: call processReceivedData() for all members
    }

    /**
     * This main-function has the only purpose to create an instance
     * of the class and to get all the things going.
     * I.e. the operations of the class are called to produce
     * the output of the HTML-file.
     * The name "main" is no keyword for php. It is just used to
     * indicate that function as the central starting point.
     * To make it simpler this is a static function. That is you can simply
     * call it without first creating an instance of the class.
     * @return void
     */
    public static function main():void
    {
        try {
            $pageBaecker = new Baecker();
            $pageBaecker->processReceivedData();
            $pageBaecker->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

// This call is starting the creation of the page.
// That is input is processed and output is created.
Baecker::main();

// Zend standard does not like closing php-tag!
// PHP doesn't require the closing tag (it is assumed when the file ends).
// Not specifying the closing ? >  helps to prevent accidents
// like additional whitespace which will cause session
// initialization to fail ("headers already sent").
//? >