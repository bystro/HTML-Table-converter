<?php
namespace HtmlTableConverter;

class HtmlTableConverterFactory
{

    public static function fromHtml($html, $tableId = null)
    {
        $table = new HtmlTable($html, $tableId);
        $tableHtml = $table->getHtml();

        $processor = new HtmlTableProcessor($tableHtml);

        return new HtmlTableConverter($processor);
    }

    public static function fromUrl($url, $tableId = null)
    {
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($c);
        if (curl_error($c)) {
            die(curl_error($c));
        }
        
        $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
        if ($status != 200) {
            die('Failed to get html from ' . $url . '<br />');
        }
        curl_close($c);

        $table = new HtmlTable($html, $tableId);
        $tableHtml = $table->getHtml();

        $processor = new HtmlTableProcessor($tableHtml);

        return new HtmlTableConverter($processor);
    }
}
