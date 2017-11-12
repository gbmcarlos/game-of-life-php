<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/12/17
 * Time: 1:28 PM
 */

namespace Tests\PopulationAssertion;

class PopulationTestCaseTest extends PopulationTestCase {

    public function testPopulationEquals() {

        $this->assertEquals(
            true, (new Constraint_PopulationEquals(
            []))->matches(
            [])
        );

        $this->assertEquals(
            true, (new Constraint_PopulationEquals(
            [0]))->matches(
            [0]
        ));

        $this->assertEquals(
            false, (new Constraint_PopulationEquals(
            [1]))->matches(
            [0]
        ));

        $this->assertEquals(
            false, (new Constraint_PopulationEquals(
            [0]))->matches(
            [1]
        ));

        $this->assertEquals(
            false, (new Constraint_PopulationEquals(
            [0, 1]))->matches(
            [0]
        ));

        $this->assertEquals(
            false, (new Constraint_PopulationEquals(
            [0]))->matches(
            [0, 1]
        ));

        $this->assertEquals(
            true, (new Constraint_PopulationEquals(
            [0, 1]))->matches(
            [0, 1]
        ));

        $this->assertEquals(
            true, (new Constraint_PopulationEquals(
            [
                [0, 0]
            ]))->matches(
            [
                [0, 0]
            ]
        ));

        $this->assertEquals(
            true, (new Constraint_PopulationEquals(
            [
                [1, 0]
            ]))->matches(
            [
                [1, 0]
            ]
        ));

        $this->assertEquals(
            false, (new Constraint_PopulationEquals(
            [
                [1, 0]
            ]))->matches(
            [
                [1, 0, 1]
            ]
        ));

        $this->assertEquals(
            false, (new Constraint_PopulationEquals(
            [
                [1, 0, 1]
            ]))->matches(
            [
                [1, 0]
            ]
        ));

        $this->assertEquals(
            false, (new Constraint_PopulationEquals(
            [
                [1, 0]
            ]))->matches(
            [
                [1, 0],
                [1, 0]
            ]
        ));

    }

}