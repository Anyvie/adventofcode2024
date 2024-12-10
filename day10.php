<?php
define('X', 0);
define('Y', 1);

$STARTERS = [];
$map = [];

$x = 0;
$fd = fopen('input10.txt', 'r');
while ($row = fgets($fd, 10240)) {
    $map[$x] = str_split(trim($row));

    foreach ($map[$x] as $y => $c) {
        if ($c == '0') $STARTERS[] = [X=>$x, Y=>$y];
    }

    $x++;
}

$sum = 0;
foreach ($STARTERS as $start) {
    $results = hike($map, $start);
    $results = array_unique($results);
    $sum += count($results);
}
echo "Part1: ".$sum.PHP_EOL;


$sum = 0;
foreach ($STARTERS as $start) {
    $results = hike($map, $start);
    $sum += count($results);
}
echo "Part2: ".$sum.PHP_EOL;


function hike($map, $pos) {
    $current = intval($map[$pos[X]][$pos[Y]]);

    if ($current == 9) return [implode(',', $pos)];

    $vectors = [
        [X=>0, Y=>1],
        [X=>0, Y=>-1],
        [X=>1, Y=>0],
        [X=>-1, Y=>0],
    ];

    $possibles = [];

    foreach ($vectors as $v) {
        $p = $pos;
        $p[X] += $v[X];
        $p[Y] += $v[Y];

        if (!isset($map[$p[X]]) || !isset($map[$p[X]][$p[Y]])) continue;

        $next = intval($map[$p[X]][$p[Y]]);

        if ($next == ($current+1)) {
            $possibles = array_merge($possibles, hike($map, $p));
        }
    }

    return $possibles;
}
