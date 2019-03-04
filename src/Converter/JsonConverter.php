<?php
namespace HtmlTableConverter\Converter;

class JsonConverter extends Converter
{

    protected function formatResult()
    {
        $this->result = json_encode($this->result);
    }
}
