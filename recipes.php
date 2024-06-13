<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require ("FlavorTown.php");

$ft = new FlavorTown();
$ingredients = $ft->GetIngredients();
$units = $ft->GetUnits();

$db = new mysqli("ix.cs.uoregon.edu", "guest", "guest", "flavortown", 3586);

$recipes = $db->query("SELECT food.*, unit.acronym AS unit_acronym FROM food JOIN unit ON food.base_unit_id = unit.id JOIN meal ON food.id = meal.id ORDER BY name")->fetch_all(MYSQLI_ASSOC);
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
    <h1>FlavorTown</h1>

    <nav>
        <ul>
            <li><a href="ingredients.php">Ingredients</a></li>
            <li><a href="recipes.php">Recipes</a></li>
        </ul>
    </nav>

    <h2>View Recipes</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Serving Size</th>
            <th>Cost</th>
            <th>Calories</th>
            <th>Fat</th>
            <th>Saturated Fat</th>
            <th>Unsaturated Fat</th>
            <th>Sodium</th>
            <th>Carbohydrates</th>
            <th>Fiber</th>
            <th>Sugar</th>
            <th>Protein</th>
        </tr>
        <?php foreach ($recipes as $recipe): ?>
            <tr>
                <td><?= $recipe["name"] ?></td>
                <td><?= $recipe["unit_quantity"] ?>     <?= $recipe["unit_acronym"] ?></td>
                <td>$<?= $recipe["cost"] ?></td>
                <td><?= $recipe["calories"] ?></td>
                <td><?= $recipe["fat"] ?> g</td>
                <td><?= $recipe["saturated_fat"] ?> g</td>
                <td><?= $recipe["unsaturated_fat"] ?> g</td>
                <td><?= $recipe["sodium"] ?> mg</td>
                <td><?= $recipe["carbohydrates"] ?> g</td>
                <td><?= $recipe["fiber"] ?> g</td>
                <td><?= $recipe["sugar"] ?> g</td>
                <td><?= $recipe["protein"] ?> g</td>
            </tr>
        <?php endforeach; ?>
    </table>

    <form action="view_recipe.php" method="POST">
        <select name="recipe_id">
            <option>Select</option>
            <?php foreach ($recipes as $recipe): ?>
                <option value="<?= $recipe['id'] ?>"><?= $recipe["name"] ?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="submit" value="View">
    </form>

    <h2>Add Recipe</h2>
    <form action="add_recipe.post.php" method="POST">
        <label for="name">Recipe Name</label>
        <input id="name" type="text" name="name">

        <div id="ingredient-container">
            <div class="ingredient-container">
                <select name="ingredient[]">
                    <option>Select</option>
                    <?php foreach ($ingredients as $ingredient): ?>
                        <option value="<?= $ingredient['id'] ?>"><?= $ingredient["name"] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" step="0.01" name="unit_quantity[]">
                <select name="base_unit_id[]">
                    <option value="unit">Whole</option>
                    <?php foreach ($units as $unit): ?>
                        <option value="<?= $unit['id'] ?>"><?= $unit["acronym"] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" onclick="removeIngredient(this)">Remove</button>
            </div>
        </div>

        <button type="button" onclick="addIngredient()">Add Ingredient</button>

        <br>
        <label for="recipe">Recipe Instructions</label>
        <br>
        <textarea id="recipe" name="recipe"></textarea>

        <br>
        <button type="submit">Submit</button>
    </form>

    <script>
        function addIngredient() {
            const container = document.getElementById('ingredient-container');
            const ingredientDiv = document.createElement('div');
            ingredientDiv.className = 'ingredient-container';
            ingredientDiv.innerHTML = `
                <select name="ingredient[]">
                    <option>Select</option>
                    <?php foreach ($ingredients as $ingredient): ?>
                                <option value="<?= $ingredient['id'] ?>"><?= $ingredient["name"] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" step="0.01" name="unit_quantity[]">
                <select name="base_unit_id[]">
                    <option value="unit">Whole</option>
                    <?php foreach ($units as $unit): ?>
                                <option value="<?= $unit['id'] ?>"><?= $unit["acronym"] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" onclick="removeIngredient(this)">Remove</button>`;
            container.appendChild(ingredientDiv);
        }

        function removeIngredient(button) {
            const ingredientDiv = button.parentNode;
            ingredientDiv.remove();
        }
    </script>
</body>

</html>