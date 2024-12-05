<?php

$map = [];

$i= 0;
$fd = fopen('input4.txt', 'r');
while ($row = fgets($fd, 10240)) {
    $map[$i] = str_split(trim($row));
    $i++;
}

$letters = ['M','A','S'];

$sum = 0;
foreach ($map as $x => $row) {
    foreach ($row as $y => $c) {
        if ($c != 'X') continue;

        $i = 1;
        foreach ($letters as $l) {
            if (($row[$y-$i] ?? '') != $l) break;
            $i++;
            if ($i == 4) $sum++;
        }

        $i = 1;
        foreach ($letters as $l) {
            if (($row[$y+$i] ?? '') != $l) break;
            $i++;
            if ($i == 4) $sum++;
        }

        $i = 1;
        foreach ($letters as $l) {
            if (($map[$x-$i][$y] ?? '') != $l) break;
            $i++;
            if ($i == 4) $sum++;
        }

        $i = 1;
        foreach ($letters as $l) {
            if (($map[$x+$i][$y] ?? '') != $l) break;
            $i++;
            if ($i == 4) $sum++;
        }


        $i = 1;
        foreach ($letters as $l) {
            if (($map[$x-$i][$y-$i] ?? '') != $l) break;
            $i++;
            if ($i == 4) $sum++;
        }

        $i = 1;
        foreach ($letters as $l) {
            if (($map[$x+$i][$y-$i] ?? '') != $l) break;
            $i++;
            if ($i == 4) $sum++;
        }

        $i = 1;
        foreach ($letters as $l) {
            if (($map[$x-$i][$y+$i] ?? '') != $l) break;
            $i++;
            if ($i == 4) $sum++;
        }

        $i = 1;
        foreach ($letters as $l) {
            if (($map[$x+$i][$y+$i] ?? '') != $l) break;
            $i++;
            if ($i == 4) $sum++;
        }

    }
}

echo "Part1: ".$sum.PHP_EOL;



$sum = 0;
foreach ($map as $x => $row) {
    foreach ($row as $y => $c) {
        if ($c != 'A') continue;
        $local = 0;

        $tl = $map[$x-1][$y-1] ?? '';
        $tr = $map[$x-1][$y+1] ?? '';
        $bl = $map[$x+1][$y-1] ?? '';
        $br = $map[$x+1][$y+1] ?? '';

        if ($tl == 'M' && $br == 'S') $local++;
        if ($tl == 'S' && $br == 'M') $local++;
        if ($tr == 'M' && $bl == 'S') $local++;
        if ($tr == 'S' && $bl == 'M') $local++;

        if ($local >= 2) $sum++;
    }
}

echo "Part2: ".$sum.PHP_EOL;
