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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    function fetchData() {
        $.getJSON("./query/fetch.php", function(data) {
            if ((data.temperature !== undefined && data.humidity !== undefined) && (data.avg_temperature !== undefined && data.avg_humidity !== undefined)) {
                $("#temperature").text(data.temperature.toFixed(1) + " °C");
                $("#humidity").text(data.humidity.toFixed(1) + " %");
                $("#avg_temperature").text(data.avg_temperature.toFixed(1) + " °C");
                $("#avg_humidity").text(data.avg_humidity.toFixed(1) + " %");
            } else {
                console.error("Invalid response from server:", data);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown);
        });
    }

    setInterval(fetchData, 1000);
</script>
</head>
<body>
    <h2>Current DHT Readings</h2>
    <p>Temperature: <span id="temperature">Fetching...</span></p>
    <p>Humidity: <span id="humidity">Fetching...</span></p>

    <h2>Average DHT Readings</h2>
    <p>Average Temperature: <span id="avg_temperature">Fetching...</span></p>
    <p>Average Humidity: <span id="avg_humidity">Fetching...</span></p>
    
    <button onclick="location.href='readings.php'">View Full List</button>

    <!-- <h2>Last 5 Readings</h2>
    <br><br>
    <table>
        <tr>
            <th>Time</th>
            <th>Temperature</th>
            <th>Humidity</th>
        </tr>
        <?php // if (!empty($latestReadings)) { 
             //foreach ($latestReadings as $reading) { ?>
            <tr>
                <td><?php // echo $reading['time']; ?></td>
                <td><?php // echo $reading['temperature']; ?></td>
                <td><?php // echo $reading['humidity']; ?></td>
            </tr>
        <?php // } 
        // } else { ?>
            <tr>
                <td colspan="4">No DHT Reading Stored!</td>
            </tr>
        <?php // } ?>
    </table> -->
</body>
</html>
