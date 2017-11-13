<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/13/17
 * Time: 11:39 AM
 */

namespace Tests\PopulationAssertion;

use PHPUnit\Framework\Constraint\Constraint;

class Constraint_PopulationDimensions extends Constraint {

    protected $dimensionX;
    protected $dimensionY;

    public function __construct(int $dimensionX, int $dimensionY) {
        parent::__construct();
        $this->dimensionX = $dimensionX;
        $this->dimensionY = $dimensionY;
    }

    public function matches($other) {

        if (empty($other) || empty($other[0])) {
            return $this->dimensionX == 0 && $this->dimensionY == 0;
        }

        return count($other) == $this->dimensionY && count($other[0]) == $this->dimensionX;

    }

    public function toString() {
        return "dimensions are $this->dimensionX x $this->dimensionY";
    }

}
