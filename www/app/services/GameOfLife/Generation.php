<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/13/17
 * Time: 6:56 PM
 */

namespace App\services\GameOfLife;


class Generation {

    private $population;
    private $individuals = [];

    private $width;
    private $height;

    public function __construct($width, $height, $matrix = null) {

        $this->width = $width;
        $this->height = $height;

        if ($matrix) {
            $this->population = $matrix;
            $this->parseIndividuals($matrix);
        } else {
            $this->setEmptyPopulation();
        }
    }

    protected function setEmptyPopulation() {

        $population = [];

        for ($i = 0; $i < $this->height; $i++) {
            $newLine = array_fill(0, $this->width, 0);
            array_push($population, $newLine);
        }

        $this->population = $population;

    }

    protected function parseIndividuals(array $matrix) {

        for ($i = 0; $i < count($matrix); $i++) {
            for ($j = 0; $j < count($matrix[$i]); $j++) {
                if ($matrix[$i][$j]) {
                    array_push($this->individuals, [$i, $j]);
                }
            }
        }

    }

    public function getPopulation() {
        return $this->population;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function addIndividual($i, $j) {
        $this->population[$i][$j] = true;
        array_push($this->individuals, [$i, $j]);
    }

    public function getIndividuals() {
        return $this->individuals;
    }

}