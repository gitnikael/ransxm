<?php
header('Content-Type: application/json');

$counter_file = 'counter.txt';

if (!file_exists($counter_file)) {
    file_put_contents($counter_file, '0');
    chmod($counter_file, 0666); 
}

$count = (int)file_get_contents($counter_file);
$count++;

if (is_writable($counter_file)) {
    file_put_contents($counter_file, $count);
}

echo json_encode(['views' => number_format($count)]);
?>
