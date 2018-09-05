<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/12/17
 * Time: 12:21 PM
 */

namespace App\services\GameDrawer;

use App\services\GameOfLife\Generation;

interface GameDrawerInterface {

    public function drawGeneration(array $individuals, int $width, int $height);

    public function drawGame(Generation $generation, int $iterations) : string;

    public function getImageBinaryData($image) : string;

    public function saveTemporary($imageBin);

}