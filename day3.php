<?php

$text = "";
$fd = fopen('input3.txt', 'r');
while ($row = fgets($fd, 10240)) $text .= trim($row);
echo "Part1: ".sumMult($text).PHP_EOL;

$text2 = preg_replace("/(don\'t\(\)(.*?)do\(\))/", "", $text);
echo "Part2: ".sumMult($text2).PHP_EOL;

function sumMult($row) {
    $sum = 0;

    preg_match_all("/(mul\([0-9]{1,3}\,[0-9]{1,3}\))/", $row, $matches);
    if (! is_array($matches[1]) || ! count($matches[1])) return 0;

    foreach ($matches[1] as $m) {
        $m = str_replace(['mul(',')'], '', $m);
        list($a, $b) = explode(',', $m);
        $sum += $a * $b;
    }

    return $sum;
}
