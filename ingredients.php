<?php
require("FlavorTown.php");

$ft = new FlavorTown();
$ingredients = $ft->GetIngredients();
$units = $ft->GetUnits();
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

    <h2>View Ingredients</h2>
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
    <?php foreach($ingredients as $ingredient): ?>
        <tr>
            <td><?=$ingredient["name"]?></td>
            <td><?=$ingredient["unit_quantity"]?> <?=$ingredient["unit_acronym"]?></td>
            <td>$<?=$ingredient["cost"]?></td>
            <td><?=$ingredient["calories"]?></td>
            <td><?=$ingredient["fat"]?> g</td>
            <td><?=$ingredient["saturated_fat"]?> g</td>
            <td><?=$ingredient["unsaturated_fat"]?> g</td>
            <td><?=$ingredient["sodium"]?> mg</td>
            <td><?=$ingredient["carbohydrates"]?> g</td>
            <td><?=$ingredient["fiber"]?> g</td>
            <td><?=$ingredient["sugar"]?> g</td>
            <td><?=$ingredient["protein"]?> g</td>
        </tr>
    <?php endforeach; ?>
    </table>

    <h2>Modify Ingredient</h2>
    <form action="modify_ingredient.php", method="POST">
        <select name="modify_ingredient">
            <option>Select</option>
            <?php foreach($ingredients as $ingredient): ?>
                <option value="<?=$ingredient['id']?>"><?=$ingredient["name"]?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="submit" value="Modify">
    </form>

    <h2>Add Ingredient</h2>
    <form action="add_ingredient.post.php", method="POST">
        <label for="name">Name</label>
        <input id="name" type="text" name="name">

        <br>
        <label for="unit_quantity">Serving Size</label>
        <input id="unit_quantity" type="numeric" step="0.1" name="unit_quantity">

        <select name="base_unit_id">
            <option>Select Unit</option>
            <?php foreach($units as $unit): ?>
                <option value="<?=$unit['id']?>"><?= $unit["acronym"] ?></option>
            <?php endforeach; ?>
        </select>

        <br>
        <label for="cost">Cost ($)</label>
        <input id="cost" type="numeric" step="0.01" name="cost">

        <br>
        <label for="calories">Calories</label>
        <input id="calories" type="numeric" step="0.01" name="calories">

        <br>
        <label for="fat">Fat (g)</label>
        <input id="fat" type="numeric" step="0.01" name="fat">

        <br>
        <label for="saturated_fat">Saturated Fat (g)</label>
        <input id="saturated_fat" type="numeric" step="0.01" name="saturated_fat">

        <br>
        <label for="unsaturated_fat">Unsaturated Fat (g)</label>
        <input id="unsaturated_fat" type="numeric" step="0.01" name="unsaturated_fat">

        <br>
        <label for="sodium">Sodium (mg)</label>
        <input id="sodium" type="numeric" step="0.01" name="sodium">

        <br>
        <label for="carbohydrates">Carbohydrates (g)</label>
        <input id="carbohydrates" type="numeric" step="0.01" name="carbohydrates">

        <br>
        <label for="fiber">Fiber (g)</label>
        <input id="fiber" type="numeric" step="0.01" name="fiber">

        <br>
        <label for="sugar">Sugar (g)</label>
        <input id="sugar" type="numeric" step="0.01" name="sugar">

        <br>
        <label for="protein">Protein (g)</label>
        <input id="protein" type="numeric" step="0.01" name="protein">

        <br>
        <input type="submit" value="Submit">
    </form>
  </body>
</html>