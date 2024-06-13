<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("FlavorTown.php");

$ft = new FlavorTown();
$ingredients = $ft->GetIngredients();
$units = $ft->GetUnits();

$db = new mysqli("ix.cs.uoregon.edu", "guest", "guest", "flavortown", 3586);

$recipe_id = (isset($_POST["recipe_id"])) ? $_POST["recipe_id"] : $_GET["recipe_id"];

$recipe = $db->query("SELECT * FROM meal WHERE id = $recipe_id")->fetch_assoc();
$ingredients = $db->query("SELECT meal_ingredient.*, food.name AS name, unit.acronym as acronym FROM meal_ingredient JOIN food ON ingredient_id = food.id JOIN unit ON meal_ingredient.base_unit_id = unit.id WHERE meal_id = $recipe_id")->fetch_all(MYSQLI_ASSOC);
$reviews = $db->query("SELECT * FROM review WHERE meal_id = $recipe_id")->fetch_all(MYSQLI_ASSOC);

$rating_average = ($recipe["rating_count"] != 0) ? $recipe["rating_sum"] / $recipe["rating_count"] : 0;

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
    <h1>FlavorTown</h1>

    <nav>
        <ul>
            <li><a href="ingredients.php">Ingredients</a></li>
            <li><a href="recipes.php">Recipes</a></li>
        </ul>
    </nav>

    <h2>Ingredients</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Amount</th>
        </tr>
        <?php foreach ($ingredients as $ingredient): ?>
            <tr>
                <td><?= $ingredient["name"] ?></td>
                <td><?= $ingredient["unit_quantity"] ?>     <?= $ingredient["acronym"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Instructions</h2>
    <pre>
        <?php print_r($recipe["recipe_text"])?>
    </pre>

    <h2>Leave a Review</h2>
    <form action="rate_recipe.post.php" method="POST">
        <input type="hidden" name="recipe_id" value="<?=$recipe_id?>">

        <label for="rating">Rate 1-5</label><br>
        <input id="rating" name="rating" type="number" step="1" min="1" max="5">

        <br>
        <label for="comment">Leave a Comment</label>
        <br>
        <textarea id="comment" name="comment"></textarea>

        <br>
        <input type="submit" value="Submit Rating">
    </form>

    <h2>Reviews (Average Rating: <?=round($rating_average, 2)?> / 5)</h2>
    <ul>
    <?php foreach($reviews as $review):?>
        <li>
            <?=$review["comment"]?> (<?=$review["rating"]?> / 5)
        </li>
    <?php endforeach; ?>
    </ul>
</body>

</html>