<?php declare(strict_types=1);

require_once './Page.php';

class Uebersicht extends Page
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
        $data = array();
        return $data;
    }

    protected function generateView():void
    {
        $data = $this->getViewData();
        $this->generatePageHeader('Übersicht');
        echo <<<HERE
    <h1>Pizza Service</h1>
    <section>
        <nav class="horizontal_nav">
            <ul>
                <li class="horizontal-li"><a href="Uebersicht.php">Übersicht</a></li>
                <li class="horizontal-li" ><a href="Bestellung.php">Bestellung</a></li>
                <li class="horizontal-li"><a href="Kunde.php">Kunde</a></li>
                <li class="horizontal-li"><a href="Baecker.php">Bäcker</a></li>
                <li class="horizontal-li"><a href="Fahrer.php">Fahrer</a></li>
            </ul>
        </nav>
        <nav class="vertical_nav">
            <ul>
                <li class="vertical_li"><a href="Uebersicht.php">Übersicht</a></li>
                <li class="vertical_li"><a href="Bestellung.php">Bestellung</a></li>
                <li class="vertical_li"><a href="Kunde.php">Kunde</a></li>
                <li class="vertical_li"><a href="Baecker.php">Bäcker</a></li>
                <li class="vertical_li"><a href="Fahrer.php">Fahrer</a></li>
            </ul>
        </nav>
    </section>
</body>
</html>
HERE;
        $this->generatePageFooter();
    }

    protected function processReceivedData():void
    {
        parent::processReceivedData();
    }

    public static function main():void
    {
        try {
            $page = new Uebersicht();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Uebersicht::main();
