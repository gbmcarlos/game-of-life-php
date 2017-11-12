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

    }

    public function countNeighbours($population = [], $i = 0, $j = 0) : int {

    }

    public function getCellNextGeneration($cell = false, $neighbours = 0) : bool {

    }

}