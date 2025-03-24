<?php
require '../config/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $t = isset($_POST['temperature']) ? $_POST['temperature'] : null;
    $h = isset($_POST['humidity']) ? $_POST['humidity'] : null;

    date_default_timezone_set('Asia/Manila');
    $recorded_at = date('Y-m-d H:i:s');

    if ($t !== null && $h !== null) {
        $sql = "INSERT INTO dht_readings (temperature, humidity, recorded_at) VALUES ('$t', '$h', '$recorded_at')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Data inserted successfully";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Invalid input data";
    }
} else {
    echo "Invalid request method";
}

$conn->close();
?>
