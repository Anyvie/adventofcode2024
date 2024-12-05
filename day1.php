<?php

$left = $right = [];

$fd = fopen('input1.txt', 'r');
while ($row = fgets($fd, 1024)) {
    list($l, $r) = explode('   ', $row);
    $left[] = $l;
    $right[] = $r;
}

sort($left);
sort($right);

$diff = 0;

foreach ($left as $k => $l) {
    $r = $right[$k];
    $diff += abs($l - $r);
}

echo "Part1: ".$diff.PHP_EOL;

$diff = 0;

$calcs = [];

foreach ($left as $k => $l) {
    $n = count(array_filter($right, fn($v) => $v == $l));
    $diff += $l * $n;
}

echo "Part2: ".$diff.PHP_EOL;
