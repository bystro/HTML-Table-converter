<?php
namespace HtmlTableConverter;

class HtmlTableConverter
{

    private $converter = null;
    private $processor = null;
    private $resultType = \HtmlTableConverter\Converter\Type::ARRAY;

    public function __construct(HtmlTableProcessor $processor)
    {
        $this->processor = $processor;

        $this->setConverter();
    }

    public function convert()
    {
        $this->converter->setProcessor($this->processor);

        return $this->converter->convert();
    }

    public function doNotIncludeHeaderRowInResult()
    {
        $this->converter->doNotIncludeHeaderRowInResult();
    }

    public function setResultType($resultType)
    {
        $this->resultType = $resultType;
        $this->setConverter();
    }

    private function setConverter()
    {
        switch ($this->resultType) {
            case 'json':
                $this->converter = new Converter\JsonConverter();
                break;
            case 'array':
            default:
                $this->converter = new Converter\ArrayConverter();
                break;
        }
    }
}
