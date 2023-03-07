<?php

namespace App;

class Bakery
{
    /**
     * Calculate the output of cakes for a giver recipe
     *
     * @param array $recipe      Contains the necessary ingredients to make one cake
     * @param array $ingredients Contains the amount of ingredients you have available to bake
     *
     * @return int The number of cakes you can bake
     */
    public static function calculateOutput(array $recipe, array $ingredients): int
    {
        $countRecipe = count($recipe);
        $countIngredients = count($ingredients);
        if ($countIngredients < $countRecipe) return 0; 
        
        $numberOfCakes = PHP_INT_MAX; 
        
        foreach ($recipe as $ingredient => $quantity) {

            if (array_key_exists($ingredient, $ingredients)) {
            $quantityIngredients = $ingredients[$ingredient];

            $countCakes = floor($quantityIngredients / $quantity);
            
            if ($countCakes < $numberOfCakes) {
                $numberOfCakes = $countCakes;
            }
            } else {
                return 0; 
            }
        }

        return $numberOfCakes;
    }
}