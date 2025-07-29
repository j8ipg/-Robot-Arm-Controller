<?php
$conn = new mysqli("localhost", "root", "", "robot_db");
$stmt = $conn->prepare("INSERT INTO poses (motor1, motor2, motor3, motor4, motor5, motor6) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiiiii", $_POST['motor1'], $_POST['motor2'], $_POST['motor3'], $_POST['motor4'], $_POST['motor5'], $_POST['motor6']);
$stmt->execute();
$stmt->close();
$conn->close();
?>
