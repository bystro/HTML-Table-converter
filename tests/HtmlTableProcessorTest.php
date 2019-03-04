<?php

use PHPUnit\Framework\TestCase;

final class HtmlTableProcessorTest extends TestCase
{

    const HTML = '<table summary="Documents" id="teams" title="Team list">'
        . '<thead>'
        . '<tr>'
        . '<th>Team name</th>'
        . '<th>Conference name</th>'
        . '</tr>'
        . '</thead>'
        . '<tbody>'
        . '<tr>'
        . '<td>Red Sox</td>'
        . '<td>AL East</td>'
        . '</tr>'
        . '<tr>'
        . '<td>Cleveland Indians</td>'
        . '<td>AL Central</td>'
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
                'Conference name' => 'AL East',
            ],
            [
                'Team name' => 'Cleveland Indians',
                'Conference name' => 'AL Central',
            ],
        ];

        $this->assertAttributeSame($expected, 'columnValues', $table);
    }
}
