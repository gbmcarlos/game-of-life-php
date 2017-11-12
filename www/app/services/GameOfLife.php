<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/12/17
 * Time: 12:36 PM
 */

namespace App\services;

use App\services\GameOfLifeInterface;

class GameOfLife implements GameOfLifeInterface {

    public function getNextGeneration($population = []) : array {
        return [];
    }

    public function countNeighbours($population = [], $x = 0, $y = 0) : int {

        $count = 0;

        for ($i = -1; $i <= 1;$i++) {
            if (isset($population[$y + $i])) {
                for ($j = -1; $j <= 1;$j++) {
                    if ($i != 0 || $j != 0) { // if it's not the central cell we're looking at
                        if (isset($population[$y + $i][$x + $j]) && $population[$y + $i][$x + $j]) {
                            $count++;
                        }
                    }
                }
            }
        }

        return $count;

    }

    public function getCellNextGeneration($cell = false, $neighbours = 0) : bool {

        if ($cell) {
            return $neighbours == 2 || $neighbours == 3;
        } else {
            return $neighbours == 3;
        }

    }

}