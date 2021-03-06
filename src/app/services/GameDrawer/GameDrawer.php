<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/13/17
 * Time: 12:42 PM
 */

namespace App\services\GameDrawer;

use App\services\GameOfLife\GameOfLifeInterface;
use App\services\GameOfLife\Generation;
use App\services\GIFEncoder;

class GameDrawer implements GameDrawerInterface {

    protected $cellWidth;
    protected $cellHeight;
    protected $gifDelay;
    protected $gameOfLife;
    protected $colors = [];

    public function __construct($cellWidth, $cellHeight, $gifDelay, GameOfLifeInterface $gameOfLife) {
        $this->cellWidth = $cellWidth;
        $this->cellHeight = $cellHeight;
        $this->gifDelay = $gifDelay;
        $this->gameOfLife = $gameOfLife;
    }

    public function drawGeneration(array $individuals, int $width, int $height) {

        $image = $this->createCanvas($width, $height);

        foreach ($individuals as $individual) {
            $this->drawCell(
                $image,
                $individual[1],
                $individual[0]);
        }

        return $image;

    }

    public function drawGame(Generation $generation, int $iterations) : string {

        $frames = [];
        $delays = [];

        $width = $generation->getWidth() * $this->cellWidth;
        $height = $generation->getHeight() * $this->cellHeight;

        for ($i = 0; $i < $iterations; $i++) {

            $frame = $this->drawGeneration($generation->getIndividuals(), $width, $height);
            array_push($frames, $this->getImageBinaryData($frame));
            array_push($delays, $this->gifDelay);

            $generation = $this->gameOfLife->getNextGeneration($generation);

        }

        $gif = new GIFEncoder(
            $frames,
            $delays,
            0,
            3,
            255, 255, 0,
            [],
            'bin'
        );

        $gifFile = $this->saveTemporary($gif->GetAnimation());

        return $gifFile;

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
        $rectangleY1 = $positionY * $this->cellHeight;

        $rectangleX2 = $rectangleX1 + $this->cellWidth;
        $rectangleY2 = $rectangleY1 + $this->cellHeight;
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