<?php

class FlavorTown
{
    private $db;

    public function __construct()
    {
        $this->db = new mysqli("ix.cs.uoregon.edu", "guest", "guest", "flavortown", 3586);
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function GetIngredient($id)
    {
        $query = "
            SELECT food.*, unit.id AS unit_id, unit.acronym as unit_acronym
            FROM food JOIN unit ON base_unit_id = unit.id
            WHERE food.id = $id
        ";

        return $this->db->query($query)->fetch_assoc();
    }

    public function GetIngredients()
    {
        $query = "
            SELECT food.*, unit.acronym AS unit_acronym
            FROM food
            JOIN unit ON food.base_unit_id = unit.id
            LEFT JOIN meal ON food.id = meal.id
            WHERE meal.id IS NULL
            ORDER BY name
        ";

        return $this->db->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function AddIngredient($name, $unit_quantity, $cost, $calories, $fat, $saturated_fat, $unsaturated_fat, $sodium, $carbohydrates, $fiber, $sugar, $protein, $base_unit_id)
    {
        $query = "
            INSERT INTO food
                (name, unit_quantity, cost, calories, fat, saturated_fat, unsaturated_fat, sodium, carbohydrates, fiber, sugar, protein, base_unit_id)
            VALUES
                ('$name', $unit_quantity, $cost, $calories, $fat, $saturated_fat, $unsaturated_fat, $sodium, $carbohydrates, $fiber, $sugar, $protein, $base_unit_id)
        ";

        $this->db->query($query);
    }

    public function ModifyIngredient($id, $unit_quantity, $cost, $calories, $fat, $saturated_fat, $unsaturated_fat, $sodium, $carbohydrates, $fiber, $sugar, $protein, $base_unit_id)
    {
        $query = "
            UPDATE food
            SET
                unit_quantity = $unit_quantity,
                cost = $cost,
                calories = $calories,
                fat = $fat,
                saturated_fat = $saturated_fat,
                unsaturated_fat = $unsaturated_fat,
                sodium = $sodium,
                carbohydrates = $carbohydrates,
                fiber = $fiber,
                sugar = $sugar,
                protein = $protein,
                base_unit_id = $base_unit_id
            WHERE id = $id
        ";

        $this->db->query($query);
    }

    public function GetRecipes()
    {

    }

    public function AddRecipe()
    {

    }

    public function GetUnits()
    {
        $query = "SELECT * FROM unit";
        return $this->db->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function GetUnitsExclude($id)
    {
        $query = "SELECT * FROM unit WHERE id != $id";
        return $this->db->query($query)->fetch_all(MYSQLI_ASSOC);
    }
}