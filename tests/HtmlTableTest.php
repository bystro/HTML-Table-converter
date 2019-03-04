<?php

use PHPUnit\Framework\TestCase;

final class HtmlTableTest extends TestCase
{

    const HTML = '<p>blabla</p>'
        . '<table summary="Documents" id="points" title="Player point list">'
        . '<thead>'
        . '<tr>'
        . '<th>First name</th>'
        . '<th>Last name</th>'
        . '<th>Points</th>'
        . '</tr>'
        . '</thead>'
        . '<tbody>'
        . '<tr>'
        . '<td>Jill</td>'
        . '<td>Smith</td>'
        . '<td>50</td>'
        . '</tr>'
        . '<tr>'
        . '<td>Eve</td>'
        . '<td>Jackson</td>'
        . '<td>94</td>'
        . '</tr>'
        . '</tbody>'
        . '</table>'
        . '<table summary="Documents" id="teams" title="Team list">'
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

    public function testGettingByDefaultFirstTableFromHtmlCode()
    {
        $html = self::HTML;
        $tableId = null;
        $table = new HtmlTableConverter\HtmlTable($html, $tableId);
        $actual = $table->getHtml();

        $expected = '<table summary="Documents" id="points" title="Player point list">'
            . '<thead>'
            . '<tr>'
            . '<th>First name</th>'
            . '<th>Last name</th>'
            . '<th>Points</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>Jill</td>'
            . '<td>Smith</td>'
            . '<td>50</td>'
            . '</tr>'
            . '<tr>'
            . '<td>Eve</td>'
            . '<td>Jackson</td>'
            . '<td>94</td>'
            . '</tr>'
            . '</tbody>'
            . '</table>';

        $this->assertEquals($expected, $actual);
    }

    public function testGettingTableByIdFromHtmlCode()
    {
        $html = self::HTML;
        $tableId = 'teams';
        $table = new HtmlTableConverter\HtmlTable($html, $tableId);
        $actual = $table->getHtml();

        $expected = '<table summary="Documents" id="teams" title="Team list">'
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

        $this->assertEquals($expected, $actual);
    }
}
