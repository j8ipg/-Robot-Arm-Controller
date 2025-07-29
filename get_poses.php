<?php
$conn = new mysqli("localhost", "root", "", "robot_db");
$result = $conn->query("SELECT * FROM poses");

echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>
        <th>#</th>
        <th>Motor 1</th>
        <th>Motor 2</th>
        <th>Motor 3</th>
        <th>Motor 4</th>
        <th>Motor 5</th>
        <th>Motor 6</th>
        <th>Action</th>
      </tr>";

$counter = 1;
while ($row = $result->fetch_assoc()) {
  echo "<tr>
          <td>{$counter}</td>
          <td>{$row['motor1']}</td>
          <td>{$row['motor2']}</td>
          <td>{$row['motor3']}</td>
          <td>{$row['motor4']}</td>
          <td>{$row['motor5']}</td>
          <td>{$row['motor6']}</td>
          <td>
            <button onclick='loadPose({$row['id']})'>Load</button>
            <button onclick='removePose({$row['id']})'>Remove</button>
          </td>
        </tr>";
  $counter++;
}

echo "</table>";

$conn->close();
?>
