<?php

use PHPUnit\Framework\TestCase;
use App\services\GameOfLife;

/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/12/17
 * Time: 12:33 PM
 */
class GameOfLifeTest extends TestCase {

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

    public function tearDown() {
        unset($this->game);
    }

}