<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function printAllTables()
{
  $db = new mysqli("ix.cs.uoregon.edu", "guest", "guest", "flavortown", 3586);

  $tables = $db->query("SHOW TABLES");

  while ($table = $tables->fetch_array()) {
    $table = $table[0];

    $columnsData = $db->query("SHOW COLUMNS FROM $table");
    $columns = [];

    while ($columnData = $columnsData->fetch_array()) {
      $columns[] = $columnData["Field"];
    }

    $data = $db->query("SELECT * FROM $table");

    echo "<h2>Table: $table</h2>";

    echo "<table border='1'>";
    echo "<tr>";
    foreach ($columns as $column) {
      echo "<th>$column</th>";
    }
    echo "</tr>";

    if ($data->num_rows > 0) {
      // Fetch rows
      while ($row = $data->fetch_assoc()) {
        echo "<tr>";
        foreach ($columns as $column) {
          echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
        }
        echo "</tr>";
      }
    } else {
      echo "<tr><td colspan='" . count($columns) . "'>No data available</td></tr>";
    }

    echo "</table><br>";
  }


}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>FlavorTown</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <nav>
    <ul>
      <li><a href="ingredients.php">Ingredients</a></li>
      <li><a href="recipes.php">Recipes</a></li>
    </ul>
  </nav>
  <?php printAllTables(); ?>
</body>

</html>