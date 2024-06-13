<?php
require("FlavorTown.php");

$ft = new FlavorTown();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $unit_quantity = floatval($_POST["unit_quantity"]);
    $cost = floatval($_POST["cost"]);
    $calories = floatval($_POST["calories"]);
    $fat = floatval($_POST["fat"]);
    $saturated_fat = floatval($_POST["saturated_fat"]);
    $unsaturated_fat = floatval($_POST["unsaturated_fat"]);
    $sodium = floatval($_POST["sodium"]);
    $carbohydrates = floatval($_POST["carbohydrates"]);
    $fiber = floatval($_POST["fiber"]);
    $sugar = floatval($_POST["sugar"]);
    $protein = floatval($_POST["protein"]);
    $base_unit_id = intval($_POST["base_unit_id"]);

    $ft->AddIngredient($name, $unit_quantity, $cost, $calories, $fat, $saturated_fat, $unsaturated_fat, $sodium, $carbohydrates, $fiber, $sugar, $protein, $base_unit_id);
}

header('Location: ingredients.php');
exit;