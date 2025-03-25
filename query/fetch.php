<?php
require '../config/dbcon.php';

// latest reading
$latestQuery = "SELECT temperature, humidity FROM dht_readings ORDER BY recorded_at DESC LIMIT 1";
$result = $conn->query($latestQuery);
$latestData = $result->fetch_assoc();

// average reading per hour
$avgQuery = "SELECT AVG(temperature) AS avg_temp, AVG(humidity) AS avg_humidity 
             FROM dht_readings 
             WHERE recorded_at >= NOW() - INTERVAL 1 HOUR";
$avgResult = $conn->query($avgQuery);
$avgData = $avgResult->fetch_assoc();

// send response as JSON
$response = [
    "temperature" => isset($latestData['temperature']) ? round($latestData['temperature'], 2) : 0,
    "humidity" => isset($latestData['humidity']) ? round($latestData['humidity'], 2) : 0,
    "avg_temperature" => isset($avgData['avg_temp']) ? round($avgData['avg_temp'], 2) : 0,
    "avg_humidity" => isset($avgData['avg_humidity']) ? round($avgData['avg_humidity'], 2) : 0
];

header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>
