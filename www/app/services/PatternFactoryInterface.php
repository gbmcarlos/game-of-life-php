<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/12/17
 * Time: 12:15 PM
 */

namespace App\services;


interface PatternFactoryInterface {

    public function getPattern($name) : array;

    public function getRandomPattern($randomRatio = 0.5, $width = 0, $height = 0) : array;

}