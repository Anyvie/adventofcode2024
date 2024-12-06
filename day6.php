<?php

$THE_MAP = [];
$vector = [-1,0]; // going top first
$current = [0,0];

const X = 0;
const Y = 1;

$x = 0;
$fd = fopen('input6.txt', 'r');
while ($row = fgets($fd, 10240)) {
    $THE_MAP[$x] = str_split($row);

    if (strpos($row, '^') !== false) {
        foreach ($THE_MAP[$x] as $y => $c) {
            if ($c == '^') {
                $current = [$x, $y];
                break;
            }
        }
    }

    $x++;
}

$THE_MAP[$current[X]][$current[Y]] = 'X';

$map = guardWalk($THE_MAP, $current, $vector);
$sum = 0;
foreach ($map as $x => $row) $sum += substr_count(implode(' ', $row), 'X');
echo "Part1: ".$sum.PHP_EOL;

// BRUTEFORCE - the least efficient, but it works
$sum = 0;
foreach ($THE_MAP as $x => $row) {
    foreach ($row as $y => $c) {
        if ($c == 'X') continue;

        $map = $THE_MAP;
        $map[$x][$y] = '#';
        $test = guardWalk($map, $current, $vector);
        if (is_null($test)) $sum++;
    }
}
echo "Part2: ".$sum.PHP_EOL;

function guardWalk($map, $current, $vector) {
    $nbSteps = pow(count($map), 2);

    while ($nbSteps > 0) {
        $nbSteps--;
        $next = $current;
        $next[X] += $vector[X];
        $next[Y] += $vector[Y];

        if (! isset($map[$next[X]]) || ! isset($map[$next[X]][$next[Y]])) break;

        if ($map[$next[X]][$next[Y]] != '#') {
            $map[$next[X]][$next[Y]] = 'X';
            $current = $next;
            continue;
        }

        if ($vector[X] == -1) {
            $vector[X] = 0; $vector[Y] = 1;
        } elseif ($vector[X] == 1) {
            $vector[X] = 0; $vector[Y] = -1;
        } elseif ($vector[Y] == 1) {
            $vector[X] = 1; $vector[Y] = 0;
        } elseif ($vector[Y] == -1) {
            $vector[X] = -1; $vector[Y] = 0;
        } 
    }

    return ($nbSteps) ? $map : null;
}