<?php


$startingHour = 8;
$endingHour = 10;
$duration = 50;

$slotHour = $startingHour;
$slotMinute = 0;

$slots = [];

while ($slotHour < $endingHour) {
    $slots[] = [$slotHour, $slotMinute];
    $slotMinute += $duration;
    if ($slotMinute >= 60) {
        $slotMinute -= 60;
        $slotHour++;
    }
}


/*--------------------------------*/

$startingHour = 22;
$endingHour = 8;
$duration = 60;

$dayCicles = 1;

$slots = [];

$slotHour = $startingHour;
$slotMinute = 0;

while (true) {
    $slots[] = [
        'hour' => $slotHour,
        'minute' => $slotMinute
    ];

    $slotMinute += $duration;
    if ($slotMinute >= 60) {
        do {
            $slotMinute -= 60;
            $slotHour++;
        } while ($slotMinute >= 60);
    }

    if ($slotHour >= 24) {
        do {
            $slotHour -= 24;
            $dayCicles--;
        } while ($slotHour >= 24);
    }

    if ($slotHour >= $endingHour && $dayCicles == 0) {
        break;
    }
}

echo "<h3>Horarios disponibles</h3>";
echo "<ul>";
foreach ($slots as $time) {
    if (0 == $time['minute']) {
        $time['minute'] = '00';
    }
    $time['hour'] = str_pad($time['hour'], 2, "0", STR_PAD_LEFT);
    $time['minute'] = str_pad($time['minute'], 2, "0", STR_PAD_LEFT);

    echo "<li>{$time['hour']}:{$time['minute']}</li>";
}
echo "</ul>";