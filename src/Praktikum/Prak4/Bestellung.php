<?php
declare(strict_types=1);

require_once './Page.php';

class Bestellung extends Page
{
    protected function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    protected function getViewData(): array
    {
        $article_List = array();
        $sqlAbfrageCommand = "SELECT* FROM article";
        $recordSet = $this->database->query($sqlAbfrageCommand);
        if(!$recordSet) {
            throw new Exception("keine Article in der Datenbank");
        }
        while ($record = $recordSet->fetch_assoc()) {
            $get_article_id_from_datenbank = $record["article_id"];
            $get_name_from_datenbank = $record["name"];
            $get_picture_from_datenbank = $record["picture"];
            $get_price_from_datenbank = $record["price"];
            $article_List[] = array(
                "article_id" => $get_article_id_from_datenbank,
                "name" => $get_name_from_datenbank,
                "picture" => $get_picture_from_datenbank,
                "price" => $get_price_from_datenbank
            );
        }

        $recordSet->free();
        return $article_List;
    }

    protected function generateView(): void
    {
        $article_List = $this->getViewData();
        $this->generatePageHeader('Bestellung');

        echo <<<HTML
        <script src="Bestellung.js" type="text/javascript"></script>
         <h1>Bestellung</h1>
          <nav class="horizontal_nav">
            <ul>
                <li class="horizontal-li"> <a href="Uebersicht.php">Übersicht</a></li>
                <li class="horizontal-li" ><a href="Bestellung.php">Bestellung</a></li>
                <li class="horizontal-li"><a href="Kunde.php">Kunde</a></li>
                <li class="horizontal-li"><a href="Baecker.php">Bäcker</a></li>
                <li class="horizontal-li"><a href="Fahrer.php">Fahrer</a></li>
            </ul>
        </nav>
         <section class="article_detail_flex_container">

HTML;
        foreach ($article_List as $article){
            echo <<< EOT
        <div class = "$article[name] article_detail" 
        onclick = "clickFunction(event)" 
        data-name = "$article[name]"
        data-price = "$article[price]"
        data-value = "$article[article_id]">
            <img class="$article[name]" src=$article[picture] alt="" 
            title="$article[name]"
            data-name = "$article[name]"
            data-price = "$article[price]"
            data-value = "$article[article_id]"/>
        <p class = "$article[name] name" id="$article[name].name"
        data-name = "$article[name]"
        data-price = "$article[price]"
        data-value = "$article[article_id]">$article[name]</p>
        <p class = "$article[name] price"
        data-name = "$article[name]"
        data-price = "$article[price]"
        data-value = "$article[article_id]">
                <span class = "$article[name]" id="$article[name].price"
                data-name = "$article[name]"
        data-price = "$article[price]"
        data-value = "$article[article_id]">$article[price]</span> &euro;
            </p>
        </div>
EOT;
        };
        //Warenkorb
        $total_price = 0;
        echo <<<HTML
    </section>
    <p id="delimeterSection"> </p>
    
    <section class="warenkorb_section">
    <h2>WARENKORB</h2>
    <form action="Bestellung.php" id="BestellungsInfos" method="post"  accept-charset="UTF-8">
        <select id = "warenkorb" name="warenkorb[]" multiple="multiple" size="5">
HTML;

        echo <<<HTML
        </select>   
        <p id="gesamtpreis">Gesamtpreis: <span id="total_price">$total_price </span>&euro;</p>
        <input id = "address_input" type="text" name="address-input" maxlength="60" placeholder="Ihre Adresse" value=""  
        oninput = "showBestellenBtnWhenInputAdress();" required style="display: block"/>
        <button class="btn" id = "delete_all_btn" type="button" value="Alle Löschen" onclick="deleteAllOptions()">Alle Löschen</button>
        <button class="btn" id = "delete_btn" type="button" value="Auswahl Löschen" onclick="deleteSelectedOption()">Auswahl Löschen</button>
        <button class="btn" id = "submit_btn" type="button" value="Bestellen" name="bestellen-button" onclick="select_all_items()">Bestellen</button>
    </form>
    </section>

HTML;

        $this->generatePageFooter();
    }
    protected function processReceivedData(): void
    {
        parent::processReceivedData();
        if (isset($_POST["address-input"])&&isset($_POST["warenkorb"])) {

            //insert from address-input into ordering TABLE
            $customer_address = $_POST["address-input"];
            $ordered_article_list = $_POST["warenkorb"];

            if (strlen($customer_address) <= 0) {
                throw new Exception("Bitte geben Sie in beiden Feldern etwas an!");
            }
            else {
                session_start();
                $sql_customer_address = $this->database->real_escape_string($customer_address);
                $currentDateTime = date("Y-m-d H:i:s");
                $sqlInsertCustomerAddressCommand =
                    "INSERT INTO ordering 
                    SET address = '$sql_customer_address', ordering_time = '$currentDateTime'";
                $this->database->query($sqlInsertCustomerAddressCommand);
                $new_inserted_ordering_id = $this->database->insert_id;

                $_SESSION['last_ordering_id'] = $new_inserted_ordering_id;

                //insert from warenkorb into ordered_article TABLE
                    $index = 0;
                    foreach ($ordered_article_list as $ordered_article) {
                        $sqlInsertOrderedArticleCommand = "INSERT INTO ordered_article 
                            SET ".
                            "ordering_id = $new_inserted_ordering_id, ".
                            "article_id = $ordered_article_list[$index],".
                            "status = 0";
                        $this->database->query($sqlInsertOrderedArticleCommand);

                        $index = $index+1;
                    }
            }
        }
    }


    public static function main(): void
    {
        try {
            $page = new Bestellung();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Bestellung::main();
