<?php

$rulesInf = [];
$rulesSup = [];
$pages = [];

$fd = fopen('input5.txt', 'r');
while ($row = fgets($fd, 10240)) {
    if (! strlen(trim($row))) continue;

    if (strpos($row, '|') !== false) {
        list($x, $y) = explode('|', trim($row));

        if (! isset($rulesInf[$x])) $rulesInf[$x] = [];
        $rulesInf[$x][] = $y;

        if (! isset($rulesSup[$y])) $rulesSup[$y] = [];
        $rulesSup[$y][] = $x;

        continue;
    }

    $pages[] = explode(',', trim($row));
}

$sum1 = 0;
$sum2 = 0;

foreach ($pages as $k => $page) {
    $isValid = isValid($page, $rulesInf, $rulesSup);

    if ($isValid) {
        $sum1 += $page[floor(count($page)/2)];
        continue;
    }

    usort($page, function($a, $b) use ($rulesInf) {
        if (! isset($rulesInf[$a])) return true;
        return !in_array($b, $rulesInf[$a]);
    });

    $sum2 += $page[floor(count($page)/2)];
}

echo "Part1: ".$sum1.PHP_EOL;
echo "Part2: ".$sum2.PHP_EOL;


function isValid($page, $rulesInf, $rulesSup) {
    $isValid = true;
    $buffer = [];
    
    do {
        $p = array_shift($page);

        if (isset($rulesSup[$p])) {
            foreach ($rulesSup[$p] as $t) {
                if (in_array($t, $page)) {
                    $isValid = false;
                    break 2;
                }
            }
        }

        if (isset($rulesInf[$p])) {
            foreach ($rulesInf[$p] as $t) {
                if (in_array($t, $buffer)) {
                    $isValid = false;
                    break 2;
                }
            }
        }

        $buffer[] = $p;
    } while (count($page));

    return $isValid;
}
