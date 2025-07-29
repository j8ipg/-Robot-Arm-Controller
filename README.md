# 🤖 Robot Arm Controller

A simple web-based interface to control a robotic arm using sliders and save poses using PHP and JSON.  
Runs locally using XAMPP (Apache + PHP).

![اللوكال هوست](https://github.com/user-attachments/assets/f7e38ed0-d1e7-4adc-ba34-3fc4c029b25d)

## 🔧 Requirements
- XAMPP (with Apache and PHP)
- VS Code or any code editor
- Web browser (e.g., Chrome)

## 📁 Project Structure

| File / Folder        | Description                                                  |
|----------------------|--------------------------------------------------------------|
| `robot-arm/`         | Main project folder (place inside `htdocs` in XAMPP)         |
| `index.html`         | Web interface to control the robot arm                       |
| `save_pose.php`      | Saves motor positions to `poses.json`                        |
| `get_poses.php`      | Displays all saved poses in a table                          |
| `get_run_pose.php`   | Returns a specific pose based on index                       |
| `remove_pose.php`    | Deletes a pose from the list                                 |
| `poses.json`         | JSON file that stores all saved poses (starts empty: `[]`)   |



## ▶️ How to Use
1. Install and run XAMPP.
2. Copy the project into `htdocs` inside the XAMPP directory.
3. Start Apache from XAMPP control panel.
4. Open in browser: `http://localhost/robot-arm/index.html`
5. Use sliders to save, load, and delete motor poses.

## 🧾 PART 2 – index.html
```
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Robot Arm Controller</title>
  <style>
    body { font-family: sans-serif; margin: 40px; }
    .slider { margin: 10px 0; }
    table, th, td { border: 1px solid #ccc; border-collapse: collapse; padding: 8px; }
    button { margin: 0 4px; }
  </style>
</head>
<body>

<h2>🤖 Robot Arm Controller</h2>

<div id="sliders">
  <div class="slider">Motor 1: <input type="range" min="0" max="180" id="m1"></div>
  <div class="slider">Motor 2: <input type="range" min="0" max="180" id="m2"></div>
  <div class="slider">Motor 3: <input type="range" min="0" max="180" id="m3"></div>
  <div class="slider">Motor 4: <input type="range" min="0" max="180" id="m4"></div>
  <div class="slider">Motor 5: <input type="range" min="0" max="180" id="m5"></div>
  <div class="slider">Motor 6: <input type="range" min="0" max="180" id="m6"></div>
</div>

<button onclick="savePose()">Save Pose</button>

<h3>Saved Poses</h3>
<div id="tableContainer"></div>

<script>
function savePose() {
  const data = new FormData();
  for (let i = 1; i <= 6; i++) {
    data.append("motor" + i, document.getElementById("m" + i).value);
  }

  fetch("save_pose.php", { method: "POST", body: data })
    .then(() => loadTable());
}

function loadTable() {
  fetch("get_poses.php")
    .then(res => res.text())
    .then(html => document.getElementById("tableContainer").innerHTML = html);
}

function loadPose(id) {
  fetch("get_run_pose.php?id=" + id)
    .then(res => res.json())
    .then(pose => {
      for (let i = 1; i <= 6; i++) {
        document.getElementById("m" + i).value = pose["motor" + i];
      }
    });
}

function removePose(id) {
  fetch("remove_pose.php?id=" + id)
    .then(() => loadTable());
}

window.onload = loadTable;
</script>

</body>
</html>
```

## 🧾 PART 3 – save_pose.php
```
 <?php
$data = json_decode(file_get_contents("poses.json"), true) ?? [];

$pose = [
  "motor1" => $_POST["motor1"],
  "motor2" => $_POST["motor2"],
  "motor3" => $_POST["motor3"],
  "motor4" => $_POST["motor4"],
  "motor5" => $_POST["motor5"],
  "motor6" => $_POST["motor6"]
];

$data[] = $pose;
file_put_contents("poses.json", json_encode($data, JSON_PRETTY_PRINT));
?>
```

## 🧾 PART 4 – get_poses.php
```
<?php
$data = json_decode(file_get_contents("poses.json"), true) ?? [];

echo "<table>";
echo "<tr>
  <th>#</th>
  <th>Motor 1</th><th>Motor 2</th><th>Motor 3</th>
  <th>Motor 4</th><th>Motor 5</th><th>Motor 6</th>
  <th>Action</th>
</tr>";

foreach ($data as $index => $pose) {
  echo "<tr>";
  echo "<td>" . ($index + 1) . "</td>";
  foreach ($pose as $value) {
    echo "<td>$value</td>";
  }
  echo "<td>
    <button onclick='loadPose($index)'>Load</button>
    <button onclick='removePose($index)'>Remove</button>
  </td>";
  echo "</tr>";
}
echo "</table>";
?>
```
## 🧾 PART 5 – get_run_pose.php
```
<?php
$data = json_decode(file_get_contents("poses.json"), true) ?? [];
$id = $_GET["id"];
echo json_encode($data[$id]);
?>
```
## 🧾 PART 6 – remove_pose.php
```
<?php
$data = json_decode(file_get_contents("poses.json"), true) ?? [];
$id = $_GET["id"];
unset($data[$id]);
$data = array_values($data); // Reindex after removal
file_put_contents("poses.json", json_encode($data, JSON_PRETTY_PRINT));
?>
```




