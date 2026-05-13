<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_parking";

// الاتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// استقبال البيانات من ESP32
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["lane_data"])) {
    $lane_data = $_POST["lane_data"]; // مثل: L1:C,L2:E,L3:C

    // فصل البيانات
    $lanes = explode(",", $lane_data);
    $lane_status = [];

    foreach ($lanes as $lane) {
        list($key, $value) = explode(":", $lane);
        $lane_status[$key] = ($value == "C") ? "car" : "empty";
    }

    $l1 = $lane_status["L1"] ?? "";
    $l2 = $lane_status["L2"] ?? "";
    $l3 = $lane_status["L3"] ?? "";

    // إدخال البيانات في الجدول
    $sql = "INSERT INTO parking_data (lane1, lane2, lane3) VALUES ('$l1', '$l2', '$l3')";
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No data received";
}

$conn->close();
?>
