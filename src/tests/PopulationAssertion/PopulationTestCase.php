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

    public static function assertPopulationDimensions(int $expectedX, int $expectedY, $actual) {
        self::assertThat($actual, self::populationDimensions($expectedX, $expectedY));
    }

    public static function populationDimensions(int $expectedX, int $expectedY) {
        return new Constraint_PopulationDimensions($expectedX, $expectedY);
    }

    public static function assertPopulationEquals($expected, $actual) {
        self::assertThat($actual, self::populationEquals($expected));
    }

    public static function populationEquals($expected) {
        return new Constraint_PopulationEquals($expected);
    }

}