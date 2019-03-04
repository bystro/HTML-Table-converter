<?php
namespace HtmlTableConverter\Converter;

abstract class Converter
{

    protected $processor = null;
    protected $includeHeaderRowInResult = true;
    protected $result = [];

    abstract protected function formatResult();

    public function convert()
    {
        $this->processResult();

        $this->formatResult();

        return $this->result;
    }

    public function setProcessor(\HtmlTableConverter\HtmlTableProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function doNotIncludeHeaderRowInResult()
    {        
        $this->includeHeaderRowInResult = false;        
    }

    protected function processResult()
    {
        if (!$this->includeHeaderRowInResult) {
            $this->result = $this->processor->getColumnValues();            
        } else {
            $this->result = array_merge($this->processor->getHeaderValues(), $this->processor->getColumnValues());
        }
    }
}
