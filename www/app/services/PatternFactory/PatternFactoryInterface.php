<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/12/17
 * Time: 12:15 PM
 */

namespace App\services\PatternFactory;


interface PatternFactoryInterface {

    public function getPattern($name, $width, $height) : array;

    public function getRandomPattern($randomRatio = 0.5, $width = 0, $height = 0) : array;

}