<?php

$input = "";

$fd = fopen('input9.txt', 'r');
while ($row = fgets($fd, 10240)) $input .= trim($row);

$THE_MEMORY = [];
$BLOCKS = [];

$input = str_split($input);
$i = $v = $position = 0;
foreach ($input as $length) {
    $i++;
    $value = $v;

    if ($i%2 == 0) $value = '.';
    else {
        $BLOCKS[] = ['length' => $length, 'position' => $position]; // for part 2
        $v++;
    }

    $THE_MEMORY = array_merge($THE_MEMORY, array_fill(0, $length, $value));
    $position += $length;
}

// PART 1

$memory = $THE_MEMORY;

$free = [];
foreach ($memory as $k => $c) {
    if ($c == '.') $free[] = $k;
}

for ($k=(count($memory)-1), $f=0; $k>0; $k--) {
    if ($memory[$k] == '.') continue;

    $f = array_shift($free);
    if ($f >= $k) break;

    $memory[$f] = $memory[$k];
    $memory[$k] = '.';
}

$sum = 0;

foreach ($memory as $k => $c) {
    if ($c == '.') continue;
    $sum += $k * $c;
}

echo "Part1: ".$sum.PHP_EOL;


// PART 2

$memory = $THE_MEMORY;

do {
    $free = getFreeSlots($memory);

    $value = count($BLOCKS)-1;
    $block = array_pop($BLOCKS);

    foreach ($free as $length => $position) {
        if ($length >= $block['length'] && $position <= $block['position']) {
            $memory = array_replace($memory, array_fill($position, $block['length'], $value));
            $memory = array_replace($memory, array_fill($block['position'], $block['length'], '.'));
            continue 2;
        }
    }
} while (count($free) && count($BLOCKS));

$sum = 0;

foreach ($memory as $k => $c) {
    if ($c == '.') continue;
    $sum += $k * $c;
}

echo "Part2: ".$sum.PHP_EOL;




function getFreeSlots($memory) {
    $free = [];
    
    $position = 0;
    foreach ($memory as $k => $c) {
        if ($c != '.') {
            if ($position) {
                $length = $k - $position;
                $position = 0;
                if (isset($free[$length])) continue;
                $free[$length] = $k - $length;
            }
            continue;
        }
    
        if (! $position) $position = $k;
    }

    return $free;
}
