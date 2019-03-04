HTML-Table-Converter
==================

Author: Krzysztof Kubacki

Date:   04-03-2019

## About
Converts HTML table to other format

This project is in ALPHA, meaning it is not fully functional!

Inspired by project https://github.com/tremblay/HTML-Table-to-JSON 

## Example
Given we have table bellow
<table summary="Documents" id="points" title="Player point list">
  <thead>
  <tr>
    <th>First name</th>
    <th>Last name</th>
    <th>Points</th>
  </tr>
  </thead>
  <tbody>
    <tr>
      <td>Jill</td>
      <td>Smith</td>
      <td>50</td>
    </tr>
    <tr>
      <td>Eve</td>
      <td>Jackson</td>
      <td>94</td>
    </tr>
  </tbody>
</table>

When we run the code bellow 
```php
<?php

$converter = HtmlTableConverter\HtmlTableConverterFactory::fromHtml($tableHtml);
var_dump($converter->convert()); 

```

Then will get the following result
```
array(3) {
  [0] =>
  array(3) {
    [0] =>
    string(10) "First name"
    [1] =>
    string(9) "Last name"
    [2] =>
    string(6) "Points"
  }
  [1] =>
  array(3) {
    'First name' =>
    string(4) "Jill"
    'Last name' =>
    string(5) "Smith"
    'Points' =>
    string(2) "50"
  }
  [2] =>
  array(3) {
    'First name' =>
    string(3) "Eve"
    'Last name' =>
    string(7) "Jackson"
    'Points' =>
    string(2) "94"
  }
}
```

Output format supported:
* array
* json