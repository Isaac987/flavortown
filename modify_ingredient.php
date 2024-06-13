<?php
require("FlavorTown.php");

$ft = new FlavorTown();
$ingredient = $ft->GetIngredient($_POST["modify_ingredient"]);
$units = $ft->GetUnitsExclude($ingredient["base_unit_id"]);
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

    <h2>Modify <?=$ingredient["name"]?></h2>
    <form action="modify_ingredient.post.php", method="POST">
        <input type="hidden" name="id" value="<?= $ingredient['id'] ?>">

        <label for="unit_quantity">Serving Size</label>
        <input id="unit_quantity" type="numeric" step="0.1" name="unit_quantity" value="<?= $ingredient['unit_quantity'] ?>">

        <select name="base_unit_id">
            <option value="<?=$ingredient['base_unit_id']?>"><?= $ingredient["unit_acronym"] ?></option>
            <?php foreach($units as $unit): ?>
                <option value="<?=$unit['id']?>"><?= $unit["acronym"] ?></option>
            <?php endforeach; ?>
        </select>

        <br>
        <label for="cost">Cost ($)</label>
        <input id="cost" type="numeric" step="0.01" name="cost" value="<?=$ingredient["cost"]?>">

        <br>
        <label for="calories">Calories</label>
        <input id="calories" type="numeric" step="0.01" name="calories" value="<?=$ingredient["calories"]?>">

        <br>
        <label for="fat">Fat (g)</label>
        <input id="fat" type="numeric" step="0.01" name="fat" value="<?=$ingredient["fat"]?>">

        <br>
        <label for="saturated_fat">Saturated Fat (g)</label>
        <input id="saturated_fat" type="numeric" step="0.01" name="saturated_fat" value="<?=$ingredient["saturated_fat"]?>">

        <br>
        <label for="unsaturated_fat">Unsaturated Fat (g)</label>
        <input id="unsaturated_fat" type="numeric" step="0.01" name="unsaturated_fat" value="<?=$ingredient["unsaturated_fat"]?>">

        <br>
        <label for="sodium">Sodium (mg)</label>
        <input id="sodium" type="numeric" step="0.01" name="sodium" value="<?=$ingredient["sodium"]?>">

        <br>
        <label for="carbohydrates">Carbohydrates (g)</label>
        <input id="carbohydrates" type="numeric" step="0.01" name="carbohydrates" value="<?=$ingredient["carbohydrates"]?>">

        <br>
        <label for="fiber">Fiber (g)</label>
        <input id="fiber" type="numeric" step="0.01" name="fiber" value="<?=$ingredient["fiber"]?>">

        <br>
        <label for="sugar">Sugar (g)</label>
        <input id="sugar" type="numeric" step="0.01" name="sugar" value="<?=$ingredient["sugar"]?>">

        <br>
        <label for="protein">Protein (g)</label>
        <input id="protein" type="numeric" step="0.01" name="protein" value="<?=$ingredient["protein"]?>">

        <br>
        <input type="submit" value="Submit">
    </form>
  </body>
</html>