<?php

use PHPUnit\Framework\TestCase;

final class HtmlTableProcessorTest extends TestCase
{

    const HTML = '<table summary="Documents" id="teams" title="Team list">'
        . '<thead>'
        . '<tr>'
        . '<th>'
        . PHP_EOL . '<a href="sorting=asc">Team name</a>' . PHP_EOL
        . '</th>'
        . '<th>'
        . PHP_EOL . 'Conference name' . PHP_EOL
        . '</th>'
        . '</tr>'
        . '</thead>'
        . '<tbody>'
        . '<tr>'
        . '<td>Red Sox</td>'
        . '<td>'
        . PHP_EOL . '<b>AL East</b>' . PHP_EOL
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>Cleveland Indians</td>'
        . '<td>'
        . PHP_EOL . '<b>AL Central</b>' . PHP_EOL
        . '</td>'
        . '</tr>'
        . '</tbody>'
        . '</table>';

    public function testProcessingTableHeaderValues()
    {
        $html = self::HTML;
        $table = new HtmlTableConverter\HtmlTableProcessor($html);

        $expected = [
            [
                'Team name',
                'Conference name',
            ],
        ];

        $this->assertAttributeSame($expected, 'headerValues', $table);
    }

    public function testProcessingTableColumnValues()
    {
        $html = self::HTML;
        $table = new HtmlTableConverter\HtmlTableProcessor($html);

        $expected = [
            [
                'Team name' => 'Red Sox',
                'Conference name' => '<b>AL East</b>',
            ],
            [
                'Team name' => 'Cleveland Indians',
                'Conference name' => '<b>AL Central</b>',
            ],
        ];

        $this->assertAttributeSame($expected, 'columnValues', $table);
    }
}
