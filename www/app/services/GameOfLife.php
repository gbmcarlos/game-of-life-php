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

        $result = [];

        for ($i = 0; $i < count($population); $i++) {

            if (is_array($population[$i])) {

                $result[$i] = [];
                for ($j = 0; $j < count($population[$i]); $j++) {

                    $neighbours = $this->countNeighbours($population, $i, $j);

                    $nextCell = $this->getCellNextGeneration($population[$i][$j], $neighbours);

                    $result[$i][$j] = $nextCell;

                }
            } else {

                $neighbours = $this->countNeighbours($population, 0, $i);
                $nextCell = $this->getCellNextGeneration($population[$i][0], $neighbours);

                $result[$i] = $nextCell;
            }
        }

        return $result;

    }

    public function countNeighbours($population = [], $y = 0, $x = 0) : int {

        $count = 0;

        for ($i = -1; $i <= 1;$i++) {
            if (isset($population[$y + $i])) {
                for ($j = -1; $j <= 1;$j++) {
                    if ($i != 0 || $j != 0) { // if it's not the central cell we're looking at
                        if (isset($population[$y + $i][$x + $j]) && $population[$y + $i][$x + $j]) { //x is the horizontal, y is the vertical
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