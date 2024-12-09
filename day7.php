<?php

$sum1 = $sum2 = 0;

$fd = fopen('input7.txt', 'r');
while ($row = fgets($fd, 10240)) {
    list($result, $numbers) = explode(':', $row);
    $numbers = str_getcsv(trim($numbers), ' ');

    $r = array_filter(f(0, $numbers));
    if (in_array($result, $r)) $sum1 += $result;

    $r = array_filter(f2(0, $numbers));
    if (in_array($result, $r)) $sum2 += $result;
}

echo "Part1: ".$sum1.PHP_EOL;
echo "Part2: ".$sum2.PHP_EOL;

function f($current, $remaining) {
    if (! count($remaining)) return [$current];

    $next = array_shift($remaining);

    $r1 = f($current+$next, $remaining);
    $r2 = f($current*$next, $remaining);

    return array_merge($r1, $r2);
}


function f2($current, $remaining) {
    if (! count($remaining)) return [$current];

    $next = array_shift($remaining);

    $r1 = f2($current+$next, $remaining);
    $r2 = f2($current*$next, $remaining);
    $r3 = f2($current.$next, $remaining);

    return array_merge($r1, $r2, $r3);
}
