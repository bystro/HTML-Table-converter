<?php
namespace HtmlTableConverter;

class HtmlTableProcessor
{

    const HEADER_KEY_NAME_PREFIX = 'col';

    private $html = '';
    private $headerValues = [];
    private $columnValues = [];

    public function __construct($html)
    {
        $this->html = $html;

        $this->process();
    }

    public function getHeaderValues()
    {
        return $this->headerValues;
    }

    public function getColumnValues()
    {
        return $this->columnValues;
    }

    private function process()
    {
        $this->getHeaderValuesFromTable();

        $this->getColumnValuesFromTable();
    }

    private function getHeaderValuesFromTable()
    {
        $htmlDomDocument = new \DOMDocument();
        $htmlDomDocument->loadHTML($this->html);

        $headerNodeList = $htmlDomDocument->getElementsByTagName('th');

        $headerValues = [];
        foreach ($headerNodeList as $headerNodeElement) {
            $headerValues[] = trim($headerNodeElement->textContent);
        }
        $this->headerValues[] = $headerValues;
    }

    private function getColumnValuesFromTable()
    {
        $htmlDomDocument = new \DOMDocument();
        $htmlDomDocument->loadHTML($this->html);

        $rowNodeList = $htmlDomDocument->getElementsByTagName('tr');
        foreach ($rowNodeList as $rowNodeElement) {

            $columnNodeList = $rowNodeElement->getElementsByTagName('td');

            if (!$columnNodeList->length) {
                continue;
            }
            $columnValues = [];
            $columnNumber = 0;
            foreach ($columnNodeList as $columnNodeElement) {
                $headerKey = $this->headerValues[0][$columnNumber] ?? self::HEADER_KEY_NAME_PREFIX . $columnNumber;
                $columnValues[$headerKey] = trim($columnNodeElement->textContent);

                $columnNumber++;
            }
            $this->columnValues[] = $columnValues;
        }
    }
}
