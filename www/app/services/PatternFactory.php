<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/12/17
 * Time: 2:13 PM
 */

namespace App\services;

use App\services\PatternFactoryInterface;

class PatternFactory implements PatternFactoryInterface{

    public function getPattern($name) : array {
        // TODO: Implement getPattern() method.
    }

    public function getRandomPattern($randomRatio = 0.5, $width = 0, $height = 0) : array {
        // TODO: Implement getRandomPattern() method.
    }

    public function getRandomCell($randomRatio) {

    }

}