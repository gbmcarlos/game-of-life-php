<?php

namespace Tests\PopulationAssertion;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/12/17
 * Time: 1:09 PM
 */
class Constraint_PopulationEquals extends Constraint {

    private $population;

    public function __construct($population) {
        parent::__construct();
        $this->population = $population;
    }

    public function matches($other = []) {

        $result = count($other) == count($this->population);

        for ($i = 0; $i < count($this->population) && $result; $i++) {

            if (is_array($this->population[$i])) {

                $result = count($this->population[$i]) == count($other[$i]);

                for ($j = 0; $j < count($this->population[$i]) && $result; $j++) {
                    $result = $other[$i][$j] == $this->population[$i][$j];
                }

            } else {
                $result = $other[$i] == $this->population[$i];
            }
        }

        return $result;

    }

    public function toString() {
        return 'populations are equal';
    }

}