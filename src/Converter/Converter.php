<?php
namespace HtmlTableConverter\Converter;

abstract class Converter
{

    protected $processor = null;
    protected $includeHeaderRowInResult = true;
    protected $stripTagsFromColumnValues = false;
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

    public function setIncludeHeaderRowInResult(bool $includeHeaderRowInResult)
    {
        $this->includeHeaderRowInResult = $includeHeaderRowInResult;
    }

    public function setStripTagsFromColumnValues(bool $stripTagsFromColumnValues)
    {
        $this->stripTagsFromColumnValues = $stripTagsFromColumnValues;
    }

    protected function processResult()
    {
        $headerValues = $this->processor->getHeaderValues();
        $columnValues = $this->processor->getColumnValues();

        $columnValues = $this->stripTagsFromColumnValues($columnValues);

        if (!$this->includeHeaderRowInResult) {
            $this->result = $columnValues;
        } else {
            $this->result = array_merge($headerValues, $columnValues);
        }
    }

    private function stripTagsFromColumnValues(array $columnValues): array
    {
        if ($this->stripTagsFromColumnValues) {
            return $this->stripTagsRecursivelyFromColumnValues($columnValues);
        }

        return $columnValues;
    }

    private function stripTagsRecursivelyFromColumnValues(array $columnValues): array
    {
        $callback = 'strip_tags';

        $func = function ($item) use (&$func, &$callback) {
            return is_array($item) ? array_map($func, $item) : call_user_func($callback, $item);
        };

        return array_map($func, $columnValues);
    }
}
