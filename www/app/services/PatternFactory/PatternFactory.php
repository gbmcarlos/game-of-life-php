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

    public function getPattern($name) : array {

        try {

        } catch (PatternNotFoundException $e) {
            throw $e;
        }

        $fileContent = $this->readFile($name);
        $matrix = $this->parse($fileContent);

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
        // TODO: Implement getRandomPattern() method.
    }

    public function getRandomCell($randomRatio) {

    }

}