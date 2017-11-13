<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/13/17
 * Time: 12:42 PM
 */

namespace App\services\GameDrawer;

use App\services\GameOfLife\GameOfLifeInterface;
use App\services\GIFEncoder;

class GameDrawer implements GameDrawerInterface {

    protected $cellWidth;
    protected $cellheight;
    protected $gifDelay;
    protected $gameOfLife;
    protected $colors = [];

    public function __construct($cellWidth, $cellHeight, $gifDelay, GameOfLifeInterface $gameOfLife) {
        $this->cellWidth = $cellWidth;
        $this->cellheight = $cellHeight;
        $this->gifDelay = $gifDelay;
        $this->gameOfLife = $gameOfLife;
    }

    public function drawPopulation($grid = []) {

        $numberCells = count($grid[0]);
        $numberLines = count($grid);

        // canvas dimensions
        $width = $numberCells * $this->cellWidth;
        $height = $numberLines * $this->cellheight;

        $image = $this->createCanvas($width, $height);

        for ($y = 0; $y < $numberLines; $y++) {
            for ($x = 0; $x < $numberCells; $x++) {

                if ($grid[$y][$x]) {
                    $image = $this->drawCell($image, $x, $y);
                }

            }
        }

        return $image;

    }

    public function createCanvas(int $width, int $height) {

        $image = imagecreate($width, $height);

        $this->colors['black'] = imagecolorallocate($image, 0, 0, 0);
        $this->colors['white'] = $white = imagecolorallocate($image, 255, 255, 255);

        // fill the background
        imagefill($image, 0, 0, $white);

        return $image;
    }

    public function drawCell($image, $positionX, $positionY) {

        $rectangleX1 = $positionX * $this->cellWidth;
        $rectangleY1 = $positionY * $this->cellheight;

        $rectangleX2 = $rectangleX1 + $this->cellWidth;
        $rectangleY2 = $rectangleY1 + $this->cellheight;
        $color = $this->colors['black'];
        imagefilledrectangle(
            $image,
            $rectangleX1,
            $rectangleY1,
            $rectangleX2,
            $rectangleY2,
            $color
        );

        return $image;

    }

    public function getImageBinaryData($image) : string {

        ob_start();
        imagegif($image);
        $binaryData = ob_get_contents();
        ob_end_clean();

        return $binaryData;

    }

    public function saveTemporary($imageBin) {

        $tempFilePath = tempnam(null, 'gol');
        $file = fopen($tempFilePath, 'w');
        fwrite($file, $imageBin);
        fclose($file);

        return $tempFilePath;

    }

}