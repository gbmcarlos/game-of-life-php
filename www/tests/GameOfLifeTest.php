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

    public function tearDown() {
        unset($this->game);
    }

}