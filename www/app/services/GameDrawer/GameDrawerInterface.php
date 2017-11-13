<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/12/17
 * Time: 12:21 PM
 */

namespace App\services\GameDrawer;

interface GameDrawerInterface {

    public function drawPopulation($grid = []);

    public function drawGame(array $grid, int $iterations) : string;

    public function getImageBinaryData($image) : string;

    public function saveTemporary($imageBin);

}