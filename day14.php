<?php

$W = 101;
$H = 103;

$robots = [];

$rows = file("input14.txt");
foreach ($rows as $row) {
    preg_match("/p\=([0-9\-]*),([0-9\-]*) v\=([0-9\-]*),([0-9\-]*)/", $row, $matches);
    $robots[] = $matches;
}

$sum = moveRobots($robots, 100);
echo "Part 1: ".$sum.PHP_EOL;

// FOR PART 2, IT'S MANUAL.
// Good luck.
// uncomment and don't blink. Prepare your CTRL + C
for ($i=1; $i<20000; $i++) {
    moveRobots($robots, $i);
}
echo "Part 2: -- (see abose the first christmas tree)".PHP_EOL;

function moveRobots($robots, $n=0) {
    global $H, $W;

    $map = [];
    for ($x=0; $x<$W; $x++) {
        $map[] = array_fill(0, $H, '.');
    }

    foreach ($robots as $robot) {
        list($_, $x, $y, $vx, $vy) = $robot;

        $x = truemod($x + $n * $vx, $W);
        $y = truemod($y + $n * $vy, $H);

        if (!isset($map[$x][$y])) continue;
        if ($map[$x][$y] == '.') $map[$x][$y] = 0;
        $map[$x][$y]++;
    }

    $screen = "";

    for ($y=0; $y<$H; $y++) {
        for ($x=0; $x<$W; $x++) {
            $screen .= $map[$x][$y];
        }
        $screen .= PHP_EOL;
    }
    $screen .= PHP_EOL;

    if (strpos($screen, "11111111111") !== false) {
        echo "-> ".$n.PHP_EOL;
        echo $screen;
    }

    $sum = 1;

    $nb = 0;
    for ($y=0; $y<floor($H/2); $y++) {
        for ($x=0; $x<floor($W/2); $x++) $nb += intval($map[$x][$y]);
    }
    $sum *= $nb;

    $nb = 0;
    for ($y=0; $y<floor($H/2); $y++) {
        for ($x=ceil($W/2); $x<$W; $x++) $nb += intval($map[$x][$y]);
    }
    $sum *= $nb;

    $nb = 0;
    for ($y=ceil($H/2); $y<$H; $y++) {
        for ($x=0; $x<floor($W/2); $x++) $nb += intval($map[$x][$y]);
    }
    $sum *= $nb;

    $nb = 0;
    for ($y=ceil($H/2); $y<$H; $y++) {
        for ($x=ceil($W/2); $x<$W; $x++) $nb += intval($map[$x][$y]);
    }
    $sum *= $nb;

    return $sum;
}

// from: https://mindspill.net/computing/web-development-notes/php/php-modulo-operator-returns-negative-numbers/
function truemod($num, $mod) {
    return ($mod + ($num % $mod)) % $mod;
}
