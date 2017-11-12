<?php

namespace Tests;

use Tests\PopulationAssertion\PopulationTestCase;
use App\services\GameOfLife;

/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/12/17
 * Time: 12:33 PM
 */
class GameOfLifeTest extends PopulationTestCase {

    protected $game;

    public function setUp() {
        $this->game = new GameOfLife();
    }

    public function testCellNextGeneration() {

        $this->assertEquals(false, $this->game->getCellNextGeneration(true, 0)); // alive cell with 0 nehgbours, dies
        $this->assertEquals(false, $this->game->getCellNextGeneration(true, 1)); // alive cell with 1 nehgbours, dies
        $this->assertEquals(true, $this->game->getCellNextGeneration(true, 2)); // alive cell with 2 nehgbours, lives
        $this->assertEquals(true, $this->game->getCellNextGeneration(true, 3)); // alive cell with 3 nehgbours, lives
        $this->assertEquals(false, $this->game->getCellNextGeneration(true, 4)); // alive cell with 4 nehgbours, dies
        $this->assertEquals(false, $this->game->getCellNextGeneration(true, 5)); // alive cell with 5 nehgbours, dies
        $this->assertEquals(false, $this->game->getCellNextGeneration(true, 6)); // alive cell with 6 nehgbours, dies
        $this->assertEquals(false, $this->game->getCellNextGeneration(true, 7)); // alive cell with 7 nehgbours, dies
        $this->assertEquals(false, $this->game->getCellNextGeneration(true, 8)); // alive cell with 8 nehgbours, dies
        $this->assertEquals(false, $this->game->getCellNextGeneration(false, 0)); // alive cell with 0 nehgbours, dies
        $this->assertEquals(false, $this->game->getCellNextGeneration(false, 1)); // alive cell with 1 nehgbours, dies
        $this->assertEquals(false, $this->game->getCellNextGeneration(false, 2)); // alive cell with 2 nehgbours, dies
        $this->assertEquals(true, $this->game->getCellNextGeneration(false, 3)); // alive cell with 3 nehgbours, lives
        $this->assertEquals(false, $this->game->getCellNextGeneration(false, 4)); // alive cell with 4 nehgbours, dies
        $this->assertEquals(false, $this->game->getCellNextGeneration(false, 5)); // alive cell with 5 nehgbours, dies
        $this->assertEquals(false, $this->game->getCellNextGeneration(false, 6)); // alive cell with 6 nehgbours, dies
        $this->assertEquals(false, $this->game->getCellNextGeneration(false, 7)); // alive cell with 7 nehgbours, dies
        $this->assertEquals(false, $this->game->getCellNextGeneration(false, 8)); // alive cell with 8 nehgbours, dies

    }

    public function testCountNeighbours() {

        $this->assertEquals(0, $this->game->countNeighbours([
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0]
        ]), 1, 1);

        $this->assertEquals(1, $this->game->countNeighbours([
            [1, 0, 0],
            [0, 0, 0],
            [0, 0, 0]
        ]), 1, 1);

        $this->assertEquals(2, $this->game->countNeighbours([
            [1, 1, 0],
            [0, 0, 0],
            [0, 0, 0]
        ]), 1, 1);

        $this->assertEquals(3, $this->game->countNeighbours([
            [1, 1, 1],
            [0, 0, 0],
            [0, 0, 0]
        ]), 1, 1);

        $this->assertEquals(4, $this->game->countNeighbours([
            [1, 1, 1],
            [1, 0, 0],
            [0, 0, 0]
        ]), 1, 1);

        $this->assertEquals(5, $this->game->countNeighbours([
            [1, 1, 1],
            [1, 0, 1],
            [0, 0, 0]
        ]), 1, 1);

        $this->assertEquals(6, $this->game->countNeighbours([
            [1, 1, 1],
            [1, 0, 1],
            [1, 0, 0]
        ]), 1, 1);

        $this->assertEquals(7, $this->game->countNeighbours([
            [1, 1, 1],
            [1, 0, 1],
            [1, 1, 0]
        ]), 1, 1);

        $this->assertEquals(8, $this->game->countNeighbours([
            [1, 1, 1],
            [1, 0, 1],
            [1, 1, 1]
        ]), 1, 1);

    }

    public function testNextGeneration() {

        $this->assertPopulationEquals(
            [], $this->game->getNextGeneration(
            []
        )
        );

        $this->assertPopulationEquals(
            [0], $this->game->getNextGeneration(
            [0]
        )
        );

        $this->assertPopulationEquals(
            [1], $this->game->getNextGeneration(
            [0]
        )
        );

        $this->assertPopulationEquals(
            [
                [0, 0],
                [0, 0]
            ], $this->game->getNextGeneration(
            [
                [0, 0],
                [0, 0]
            ]
        )
        );

        $this->assertPopulationEquals(
            [
                [1, 1],
                [0, 0]
            ], $this->game->getNextGeneration(
            [
                [0, 0],
                [1, 1]
            ]
        )
        );

        $this->assertPopulationEquals(
            [
                [0, 1, 0],
                [0, 1, 0],
                [0, 1, 0]
            ], $this->game->getNextGeneration(
            [
                [0, 0, 0],
                [1, 1, 1],
                [0, 0, 0]
            ]
        )
        );

        $this->assertPopulationEquals(
            [
                [1, 1, 0],
                [1, 1, 0],
                [0, 0, 0]
            ], $this->game->getNextGeneration(
            [
                [1, 1, 0],
                [1, 1, 0],
                [0, 0, 0]
            ]
        )
        );

        $this->assertPopulationEquals(
            [
                [1, 1, 0],
                [1, 0, 0],
                [0, 0, 0]
            ], $this->game->getNextGeneration(
            [
                [1, 1, 0],
                [1, 1, 0],
                [0, 0, 0]
            ]
        )
        );

    }

    public function tearDown() {
        unset($this->game);
    }

}