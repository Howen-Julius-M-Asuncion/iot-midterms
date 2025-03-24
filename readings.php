<?php
require 'config/dbcon.php'; 

$query = "SELECT recorded_at, temperature, humidity FROM dht_readings ORDER BY recorded_at DESC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dateTime = new DateTime($row['recorded_at']);
        $readings[] = [
            'date' => $dateTime->format('Y-m-d'),
            'time' => $dateTime->format('H:i:s'),
            'temperature' => $row['temperature'],
            'humidity' => $row['humidity']
        ];
    }
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
    <h2>DHT Sensor Readings</h2>
    <button onclick="location.href='index.php'">Go Back to Dashboard</button>
    <br><br>
    <table>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Temperature</th>
            <th>Humidity</th>
        </tr>
        <?php if (!empty($readings)) { 
            foreach ($readings as $reading) { ?>
            <tr>
                <td><?php echo $reading['date']; ?></td>
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
</html>
