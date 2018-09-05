<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/12/17
 * Time: 2:13 PM
 */

namespace App\services\PatternFactory;

use App\services\PatternFactory\PatternFactoryInterface;

class PatternFactory implements PatternFactoryInterface{

    protected $patternsDir = __DIR__ . '/../../resources/patterns/';

    public function getPattern($name, $width, $height) : array {

        try {

        } catch (PatternNotFoundException $e) {
            throw $e;
        }

        $fileContent = $this->readFile($name);
        $matrix = $this->parse($fileContent);

        $matrix = $this->expandMatrix($matrix, $width, $height);

        return $matrix;

    }

    public function expandMatrix($matrix, $width, $height) {

        $currentWidth = count($matrix[0]);
        $currentHeight = count($matrix);

        $missingLines = $height - $currentHeight;
        $missingCells = $width - $currentWidth;

        if ($missingLines > 0) {

            $newLines = [];
            for ($i = 0; $i < $missingLines; $i++) {
                $newLine = array_fill(0, $currentWidth, 0); // create a new line, with the current width
                array_push($newLines, $newLine);
            }
            $matrix = array_merge($matrix, $newLines);
        }

        if ($missingCells > 0) {

            for ($j = 0; $j < count($matrix); $j++) {
                $newCells = array_fill(0, $missingCells, 0); // create the rest of line
                $matrix[$j] = array_merge($matrix[$j], $newCells);
            }

        }

        return $matrix;

    }

    protected function readFile($filename) {

        $filePath = $this->patternsDir . $filename . '.txt';

        try {
            $file = fopen($filePath, 'r');
        } catch (\Exception $e) {
            throw new PatternNotFoundException();
        }

        $fileContent = fread($file, filesize($filePath));
        fclose($file);

        return $fileContent;

    }

    public function parse($text) {

        $result = [];

        $lines = explode(PHP_EOL, $text);

        for ($i = 0; $i < count($lines); $i++) {
            $chars = str_split($lines[$i]);
            if ($chars[0] != '') {
                $result[$i] = [];
                for ($j = 0; $j < count($chars); $j++) {
                    if ($chars[$j] == '0') {
                        $result[$i][$j] = 0;
                    } else if ($chars[$j] == '1') {
                        $result[$i][$j] = 1;
                    }
                }
            }
        }

        return $result;

    }

    public function getRandomPattern($randomRatio = 0.5, $width = 0, $height = 0) : array {

        $result = [];

        for ($i = 0; $i < $height; $i++) {
            $result[$i] = [];
            for ($j = 0; $j < $width; $j++) {
                $result[$i][$j] = $this->getRandomCell($randomRatio);
            }
        }

        return $result;

    }

    public function getRandomCell($randomRatio = 0.5) {
        $random = rand(0, 1);
        return $random <= $randomRatio;
    }

}