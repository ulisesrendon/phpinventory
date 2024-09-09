<?php

$pricePerDay = 300;

$multiplier = [
    'n' => 1,
    'w' => 1.2,
    'S' => 1.3,
    'm' => 1.5,
];

$daysSelected = [
    2 => 'n',
    3 => 'w',
    4 => 'w',
    5 => 'm',
];

$total = 0;
$day = 2;
$endingDay = 5;
do{
    $total += $multiplier[$daysSelected[$day]] * $pricePerDay;
    $day++;
}while($day<=$endingDay);