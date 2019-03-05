<?php

use PHPUnit\Framework\TestCase;

final class HtmlTableConverterTest extends TestCase
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
        . '<table summary="Documents" id="teams" title="Team list without header">'
        . '<tbody>'
        . '<tr>'
        . '<td>Red Sox</td>'
        . '<td>'
        . '<b>AL East</b>'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td>Cleveland Indians</td>'
        . '<td>'
        . '<b>AL Central</b>'
        . '</td>'
        . '</tr>'
        . '</tbody>'
        . '</table>';

    public function testConvertingTableToArray()
    {
        $html = self::HTML;
        $converter = HtmlTableConverter\HtmlTableConverterFactory::fromHtml($html);
        $actual = $converter->convert();

        $expected = [
            [
                'First name',
                'Last name',
                'Points',
            ],
            [
                'First name' => 'Jill',
                'Last name' => 'Smith',
                'Points' => '50',
            ],
            [
                'First name' => 'Eve',
                'Last name' => 'Jackson',
                'Points' => '94',
            ],
        ];

        $this->assertEquals(
            $actual,
            $expected
        );
    }

    public function testConvertingTableToArrayByTableIdAndThatDoesNotHaveHeader()
    {
        $html = self::HTML;
        $tableId = 'teams';
        $converter = HtmlTableConverter\HtmlTableConverterFactory::fromHtml($html, $tableId);
        $actual = $converter->convert();

        $expected = [
            [
            ],
            [
                'col0' => 'Red Sox',
                'col1' => '<b>AL East</b>',
            ],
            [
                'col0' => 'Cleveland Indians',
                'col1' => '<b>AL Central</b>',
            ],
        ];

        $this->assertEquals(
            $actual,
            $expected
        );
    }

    public function testConvertingTableToArrayWithoutHeaderRowInResult()
    {
        $html = self::HTML;
        $tableId = 'teams';
        $converter = HtmlTableConverter\HtmlTableConverterFactory::fromHtml($html, $tableId);
        $converter->doNotIncludeHeaderRowInResult();
        $actual = $converter->convert();

        $expected = [
            [
                'col0' => 'Red Sox',
                'col1' => '<b>AL East</b>',
            ],
            [
                'col0' => 'Cleveland Indians',
                'col1' => '<b>AL Central</b>',
            ],
        ];

        $this->assertEquals(
            $actual,
            $expected
        );
    }
    
    public function testConvertingTableToArrayStrippingColumnValues()
    {
        $html = self::HTML;
        $tableId = 'teams';
        $converter = HtmlTableConverter\HtmlTableConverterFactory::fromHtml($html, $tableId);
        $converter->doNotIncludeHeaderRowInResult();
        $converter->stripTagsFromColumnValues();
        $actual = $converter->convert();

        $expected = [
            [
                'col0' => 'Red Sox',
                'col1' => 'AL East',
            ],
            [
                'col0' => 'Cleveland Indians',
                'col1' => 'AL Central',
            ],
        ];

        $this->assertEquals(
            $actual,
            $expected
        );
    }

    public function testConvertingTableToArrayFromUrl()
    {
        $url = 'https://github.com/bystro/HTML-Table-converter/tree/master';
        $tableId = 'user-content-points';
        $converter = HtmlTableConverter\HtmlTableConverterFactory::fromUrl($url, $tableId);
        $actual = $converter->convert();

        $expected = [
            [
                'First name',
                'Last name',
                'Points',
            ],
            [
                'First name' => 'Jill',
                'Last name' => 'Smith',
                'Points' => '50',
            ],
            [
                'First name' => 'Eve',
                'Last name' => 'Jackson',
                'Points' => '94',
            ],
        ];

        $this->assertEquals(
            $actual,
            $expected
        );
    }

    public function testConvertingTableToJson()
    {
        $html = self::HTML;
        $converter = HtmlTableConverter\HtmlTableConverterFactory::fromHtml($html);
        $converter->setResultType(\HtmlTableConverter\Converter\Type::JSON);
        $actual = $converter->convert();

        $expected = json_encode([
            [
                'First name',
                'Last name',
                'Points',
            ],
            [
                'First name' => 'Jill',
                'Last name' => 'Smith',
                'Points' => '50',
            ],
            [
                'First name' => 'Eve',
                'Last name' => 'Jackson',
                'Points' => '94',
            ],
        ]);

        $this->assertEquals(
            $actual,
            $expected
        );
    }

    public function testConvertingTableToJsonWithoutHeaderRowInResult()
    {
        $html = self::HTML;
        $tableId = 'teams';
        $converter = HtmlTableConverter\HtmlTableConverterFactory::fromHtml($html, $tableId);
        $converter->setResultType(\HtmlTableConverter\Converter\Type::JSON);
        $converter->doNotIncludeHeaderRowInResult();
        $actual = $converter->convert();

        $expected = json_encode([
            [
                'col0' => 'Red Sox',
                'col1' => '<b>AL East</b>',
            ],
            [
                'col0' => 'Cleveland Indians',
                'col1' => '<b>AL Central</b>',
            ],
        ]);

        $this->assertEquals(
            $actual,
            $expected
        );
    }
    
    

    public function testGettingJsonFromTableWithItsIdFromHtmlCodeFailure()
    {
        $this->expectException(TypeError::class);

        $html = self::HTML;
        $tableId = 'id_that_does_not_exits';
        HtmlTableConverter\HtmlTableConverterFactory::fromHtml($html, $tableId);
    }
    
        
}
