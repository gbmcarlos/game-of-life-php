<?php

namespace Tests\PopulationAssertion;

use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/12/17
 * Time: 1:18 PM
 */
abstract class PopulationTestCase extends TestCase {

    public static function assertPopulationEquals($expected, $actual) {
        self::assertThat($actual, self::populationEquals($expected));
    }

    public static function populationEquals($expected) {
    return new Constraint_PopulationEquals($expected);
}

}