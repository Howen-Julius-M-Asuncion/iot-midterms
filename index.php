<?php
require 'config/dbcon.php'; 

// Query for the latest readings
$query = "SELECT recorded_at, temperature, humidity FROM dht_readings ORDER BY recorded_at DESC LIMIT 5";
$result = $conn->query($query);

$latestReadings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dateTime = new DateTime($row['recorded_at']);
        $latestReadings[] = [
            'time' => $dateTime->format('H:i:s'),
            'temperature' => $row['temperature'],
            'humidity' => $row['humidity']
        ];
    }
}

// Query for the average reading per hour
$avgQuery = "SELECT AVG(temperature) AS avg_temp, AVG(humidity) AS avg_humidity 
FROM dht_readings 
WHERE recorded_at >= (SELECT MAX(recorded_at) FROM dht_readings) - INTERVAL 1 MINUTE;
";
$avgResult = $conn->query($avgQuery);
$avgResult = $conn->query($avgQuery);
$averageTemperature = 'N/A';
$averageHumidity = 'N/A';

if ($avgResult->num_rows > 0) {
    $avgRow = $avgResult->fetch_assoc();
    $averageTemperature = number_format($avgRow['avg_temp'], 2) . '°C';
    $averageHumidity = number_format($avgRow['avg_humidity'], 2) . '%';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DHT Sensor Data Table</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Current DHT Readings</h2>
    <p>Temperature: <?php echo $averageTemperature; ?></p>
    <p>Humidity: <?php echo $averageTemperature; ?></p>

    <h2>Average DHT Readings</h2>
    <p>Average Temperature: <?php echo $averageTemperature; ?></p>
    <p>Average Humidity: <?php echo $averageHumidity; ?></p>
    
    <h2>Last 5 Readings</h2>
    <button onclick="location.href='readings.php'">View Full List</button>
    <br><br>
    <table>
        <tr>
            <th>Time</th>
            <th>Temperature</th>
            <th>Humidity</th>
        </tr>
        <?php if (!empty($latestReadings)) { 
            foreach ($latestReadings as $reading) { ?>
            <tr>
                <td><?php echo $reading['time']; ?></td>
                <td><?php echo $reading['temperature']; ?></td>
                <td><?php echo $reading['humidity']; ?></td>
            </tr>
        <?php } 
        } else { ?>
            <tr>
                <td colspan="4">No DHT Reading Stored!</td>
            </tr>
        <?php } ?>
    </table>
</body>
<script type="text/javascript">
    setInterval(function () { 
        location.reload();
    }, 4 * 1000);
</script>
</html>
