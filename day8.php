<?php

$map = [];
$positions = [];

$x = 0;
$fd = fopen('input8.txt', 'r');
while ($row = fgets($fd, 10240)) {
    $map[$x] = str_split(trim($row));
    
    foreach ($map[$x] as $y => $c) {
        if ($c == '.') continue;
        if (! isset($positions[$c])) $positions[$c] = [];
        $positions[$c][] = [$x,$y];
    }

    $x++;
}


$antinodes = [];

foreach ($positions as $c => $rows) {
    foreach ($rows as $i => $pos1) {
        foreach ($rows as $j => $pos2) {
            if ($i == $j) continue;

            $dX = $pos1[0] - $pos2[0];
            $dY = $pos1[1] - $pos2[1];

            $node1 = [$pos1[0]+$dX, $pos1[1]+$dY];
            $node2 = [$pos2[0]-$dX, $pos2[1]-$dY];

            if (isset($map[$node1[0]]) && isset($map[$node1[0]][$node1[1]])) {
                $antinodes[] = implode(',', $node1);
            }

            if (isset($map[$node2[0]]) && isset($map[$node2[0]][$node2[1]])) {
                $antinodes[] = implode(',', $node2);
            }
        }
    }
}

$antinodes = array_unique($antinodes);

echo "Part1: ".count($antinodes).PHP_EOL;



$antinodes = [];

foreach ($positions as $c => $rows) {
    foreach ($rows as $i => $pos1) {
        foreach ($rows as $j => $pos2) {
            if ($i == $j) continue;

            $dX = $pos1[0] - $pos2[0];
            $dY = $pos1[1] - $pos2[1];

            for ($k=0; $k<count($map); $k++) {
                $node1 = [$pos1[0]+$k*$dX, $pos1[1]+$k*$dY];
                $node2 = [$pos2[0]-$k*$dX, $pos2[1]-$k*$dY];

                if (isset($map[$node1[0]]) && isset($map[$node1[0]][$node1[1]])) {
                    $antinodes[] = implode(',', $node1);
                }

                if (isset($map[$node2[0]]) && isset($map[$node2[0]][$node2[1]])) {
                    $antinodes[] = implode(',', $node2);
                }
            }
        }
    }
}

$antinodes = array_unique($antinodes);

echo "Part1: ".count($antinodes).PHP_EOL;
