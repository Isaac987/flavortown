<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$db = new mysqli("ix.cs.uoregon.edu", "guest", "guest", "flavortown", 3586);

$recipe_id = $_POST["recipe_id"];
$rating = $_POST["rating"];
$comment = $db->real_escape_string($_POST["comment"]);

$recipe = $db->query("SELECT * FROM meal WHERE id = $recipe_id")->fetch_assoc();

$rating_sum = $recipe["rating_sum"] + $rating;
$rating_count = $recipe["rating_count"] + 1;

$db->query("UPDATE meal SET rating_sum=$rating_sum, rating_count=$rating_count WHERE id = $recipe_id");
$db->query("INSERT INTO review (meal_id, rating, comment) VALUES ($recipe_id, $rating, '$comment')");

$db->close();
header("Location: view_recipe.php?recipe_id=$recipe_id");
exit;