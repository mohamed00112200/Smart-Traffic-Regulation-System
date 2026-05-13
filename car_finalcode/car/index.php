<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_parking";

// الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// قراءة البيانات
$sql = "SELECT * FROM parking_data ORDER BY timestamp DESC LIMIT 10";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parking Status</title>
    <style>
        body { font-family: Arial; text-align: center; background-color: #f9f9f9; }
        table { margin: auto; border-collapse: collapse; width: 60%; background: #fff; box-shadow: 0 0 10px #ccc; }
        th, td { padding: 12px; border: 1px solid #ccc; }
        th { background-color: #007BFF; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        h1 { margin-top: 30px; }
    </style>
</head>
<body>
    <h1>Latest Parking Status</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Lane 1</th>
            <th>Lane 2</th>
            <th>Lane 3</th>
            <th>Timestamp</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['lane1']}</td>
                        <td>{$row['lane2']}</td>
                        <td>{$row['lane3']}</td>
                        <td>{$row['timestamp']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No data</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
