<?php
namespace HtmlTableConverter;

class HtmlTable
{

    private $tableId = null;
    private $html = '';

    public function __construct($html, $tableId)
    {
        $this->tableId = $tableId;

        $this->extractTable($html);
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    private function extractTable($html)
    {
        $htmlDomDocument = new \DOMDocument();
        $htmlDomDocument->loadHTML($html);

        if ($this->tableId) {
            $tableDomElement = $htmlDomDocument->getElementById($this->tableId);
        } else {
            $tablesNodeList = $htmlDomDocument->getElementsByTagName('table');
            $tableDomElement = $tablesNodeList[0];
        }

        $tableDomDocument = new \DOMDocument();
        $tableDomDocument->appendChild($tableDomDocument->importNode($tableDomElement, true));

        $this->html = trim($tableDomDocument->saveHTML());
    }
}
