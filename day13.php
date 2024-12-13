<?php

define('X', 0);
define('Y', 1);

$A = $B = [X=>0, Y=>0];
$sum = 0;

$fd = fopen('input13.txt', 'r');
while ($row = fgets($fd, 10240)) {
    if (! strlen(trim($row))) continue;

    if (strpos($row, "Prize") !== false) {
        preg_match('#Prize: X\=([0-9]*), Y\=([0-9]*)#', trim($row), $matches);
        list($dontcare, $X, $Y) = $matches;

        $possibles = [];

        for ($a=1; $a<=100; $a++) {
            $x = $a*$A[X]; $y = $a*$A[Y];
            if ($x > $X || $y > $Y) break;

            for ($b=1; $b<=100; $b++) {
                $xx = $x+$b*$B[X]; $yy = $y+$b*$B[Y];

                if ($xx > $X || $yy > $Y) break;

                if ($xx == $X && $yy == $Y) {
                    $possibles[] = 3*$a + $b;
                }
            }
        }

        if (! count($possibles)) continue;
        $sum += min($possibles);
        continue;
    }

    preg_match('#Button ([AB]): X\+([0-9]*), Y\+([0-9]*)#', trim($row), $matches);
    list($dontcare, $button, $X, $Y) = $matches;

    ${$button} = [X=>$X, Y=>$Y];
}

echo "Part1: ".$sum.PHP_EOL;




$sum = gmp_init(0);

$fd = fopen('input13.txt', 'r');
while ($row = fgets($fd, 10240)) {
    if (! strlen(trim($row))) continue;

    if (strpos($row, "Prize") !== false) {
        preg_match('#Prize: X\=([0-9]*), Y\=([0-9]*)#', trim($row), $matches);
        list($dontcare, $X, $Y) = $matches;

        $X += 10000000000000;
        $Y += 10000000000000;

        /*
            (1) X = A * ax + B * bx
            (2) Y = A * ay + B * by

            (1) A = X/ax - B * bx/ax
            (2) A = Y/ay - B * by/ay

            (1) = (2) :
                X/ax - B * bx/ax = Y/ay - B * by/ay
                B * by/ay - B * bx/ax = Y/ay - X/ax
                B * by*ax/ay - B * bx = Y*ax/ay - X
                B * by*ax/ay/bx - B = Y*ax/ay/bx - X/bx
                B = (Y*ax/ay/bx - X/bx) / (by*ax/ay/bx - 1)
        */

        $div = ($B[Y] * $A[X] / $A[Y] / $B[X] - 1);
        if ($div == 0) continue;
        $b = ($Y * $A[X] / $A[Y] / $B[X] - $X / $B[X]) / $div;

        if (strpos((string) $b, '.') !== false) continue;
        $b = round($b, 0); // hack PHP pour bien avoir un entier..

        $x = $b * $B[X];
        $y = $b * $B[Y];

        $a1 = ($X - $x) / $A[X];
        $a2 = ($Y - $y) / $A[Y];

        if (strpos((string) $a1, '.') !== false) continue;
        if (strpos((string) $a2, '.') !== false) continue;

        $a1 = round($a1, 0); // hack PHP pour bien avoir un entier..
        $a2 = round($a2, 0); // hack PHP pour bien avoir un entier..

        if (gmp_cmp(gmp_init($a1), gmp_init($a2)) !== 0) continue;
        $a = $a1;

        $sum = gmp_add($sum, round($b,0));
        $sum = gmp_add($sum, gmp_mul(3, round($a,0)));

        continue;
    }

    preg_match('#Button ([AB]): X\+([0-9]*), Y\+([0-9]*)#', trim($row), $matches);
    list($dontcare, $button, $X, $Y) = $matches;

    ${$button} = [X=>$X, Y=>$Y];
}

echo "Part2: ".gmp_strval($sum).PHP_EOL;
