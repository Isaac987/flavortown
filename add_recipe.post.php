<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$db = new mysqli("ix.cs.uoregon.edu", "guest", "guest", "flavortown", 3586);

// Create food record
$recipe_name = $_POST["name"];
$db->query("INSERT INTO food (name, base_unit_id) VALUES ('$recipe_name', 1)");

// Get food record id
$food_id = $db->insert_id;

// Create meal record
$recipe_text = $db->real_escape_string($_POST["recipe"]);
$db->query("INSERT INTO meal (id, recipe_text) VALUES ($food_id, '$recipe_text')");

// Stats for this meal
$grams = 0.0;
$cost = 0.0;
$calories = 0;
$fat = 0.0;
$saturated_fat = 0.0;
$unsaturated_fat = 0.0;
$carbohydrates = 0.0;
$fiber = 0.0;
$sugar = 0.0;
$protein = 0.0;

// Create recipe ingredient records and food stats
$recipe_ingredient_ids = $_POST["ingredient"];
$recipe_quantities = $_POST["unit_quantity"];
$recipe_unit_ids = $_POST["base_unit_id"];

for ($i = 0; $i < count($recipe_ingredient_ids); $i++) {
    $ingredient_id = $recipe_ingredient_ids[$i];
    $recipe_unit_id = $recipe_unit_ids[$i];

    // Get this ingredient and unit
    $ingredient = $db->query("SELECT food.*, unit.conversion AS conversion FROM food JOIN unit ON base_unit_id = unit.id WHERE food.id = $ingredient_id")->fetch_assoc();

    // Get unit conversions and quantities
    $ingredient_quantity = $ingredient["unit_quantity"];
    $ingredient_conversion = $ingredient["conversion"];
    $recipe_quantity = $recipe_quantities[$i];

    // Handle whole units
    if ($recipe_unit_id == "unit") {
        $recipe_unit_id = $ingredient["base_unit_id"];
        $recipe_quantity *= $ingredient_quantity;
    }

    $recipe_conversion = $db->query("SELECT * FROM unit WHERE id = $recipe_unit_id")->fetch_assoc()["conversion"];

    // Add nutrition and cost with unit conversions in mind
    $quantity = ($recipe_quantity * $recipe_conversion);

    $grams += $quantity;
    $cost += (((float)$ingredient["cost"] / $ingredient_quantity) * $ingredient_conversion) * $quantity;
    $calories += (((float)$ingredient["calories"] / $ingredient_quantity) * $ingredient_conversion) * $quantity;
    $fat += (((float)$ingredient["fat"] / $ingredient_quantity) * $ingredient_conversion) * $quantity;
    $saturated_fat += (((float)$ingredient["saturated_fat"] / $ingredient_quantity) * $ingredient_conversion) * $quantity;
    $unsaturated_fat += (((float)$ingredient["unsaturated_fat"] / $ingredient_quantity) * $ingredient_conversion) * $quantity;
    $carbohydrates += (((float)$ingredient["carbohydrates"] / $ingredient_quantity) * $ingredient_conversion) * $quantity;
    $fiber += (((float)$ingredient["fiber"] / $ingredient_quantity) * $ingredient_conversion) * $quantity;
    $sugar += (((float)$ingredient["sugar"] / $ingredient_quantity) * $ingredient_conversion) * $quantity;
    $protein += (((float)$ingredient["protein"] / $ingredient_quantity) * $ingredient_conversion) * $quantity;

    // Create recipe ingredient record
    $db->query("INSERT INTO meal_ingredient VALUES ($food_id, $ingredient_id, $recipe_quantity, $recipe_unit_id)");
}

// Update food record new stats
$db->query("UPDATE food SET unit_quantity=$grams, cost=$cost, calories=$calories, fat=$fat, saturated_fat=$saturated_fat, unsaturated_fat=$unsaturated_fat, carbohydrates=$carbohydrates, fiber=$fiber, sugar=$sugar, protein=$protein WHERE id=$food_id");
$db->close();

header('Location: recipes.php');
exit;