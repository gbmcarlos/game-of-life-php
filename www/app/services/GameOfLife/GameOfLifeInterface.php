<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/12/17
 * Time: 12:18 PM
 */

namespace App\services\GameOfLife;


interface GameOfLifeInterface {

    public function getNextGeneration($population = []) : array;

}