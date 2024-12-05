<?php

function isSafe($row) {
    $count = count($row);

    $n = array_shift($row);
    $balance = 0;
    $safe = 1;
    while (count($row)) {
        $next = array_shift($row);
        $delta = ($next - $n);
        $balance += ($delta > 0) ? 1 : -1;

        if (abs($delta) < 1 || abs($delta) > 3) {
            $safe = 0;
            break;
        }

        $n = $next;
    }

    if (abs($balance) != ($count - 1)) $safe = 0;

    return $safe;
}

$safes = 0;

$fd = fopen('input2.txt', 'r');
while ($row = fgets($fd, 1024)) {
    $row = explode(' ', $row);
    $safes += isSafe($row);
}

echo "Part1: ".$safes.PHP_EOL;


$safes = 0;

$fd = fopen('input2.txt', 'r');
while ($row = fgets($fd, 1024)) {
    $row = explode(' ', $row);
    $safe = isSafe($row);
    if ($safe) {
        $safes++;
        continue;
    }
    
    $count = count($row);
    for ($i=0; $i<$count; $i++) {
        $row2 = $row;
        unset($row2[$i]);
        $safe = isSafe($row2);
        if ($safe) {
            $safes++;
            continue 2;
        }
    }
}

echo "Part2: ".$safes.PHP_EOL;
