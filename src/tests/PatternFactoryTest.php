<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/13/17
 * Time: 10:30 AM
 */

namespace Tests;

use App\services\PatternFactory\PatternFactory;
use Tests\PopulationAssertion\PopulationTestCase;
use App\services\PatternFactory\PatternNotFoundException;

class PatternFactoryTest extends PopulationTestCase {

    protected $patternFactory;

    protected $patternsDir = '/../app/resources/patterns/';

    protected $patterns = [
        [
            'pattern1',
            [
                [0, 1, 0, 1],
                [1, 0, 1, 0],
                [0, 1, 0, 1],
                [1, 0, 1, 0]
            ],
            <<<'EOD'
0101
1010
0101
1010
EOD
        ],
        [
            'pattern2',
            [
                [0, 1, 0, 1, 0, 1],
                [1, 0, 1, 0, 1, 0],
                [0, 1, 0, 1, 0, 1],
                [1, 0, 1, 0, 1, 0],
                [0, 1, 0, 1, 0, 1],
                [1, 0, 1, 0, 1, 0]
            ],
            <<<'EOD'
010101
101010
010101
101010
010101
101010
EOD
        ]
    ];

    public function setUp() {

        $this->patternFactory = new PatternFactory();

        foreach ($this->patterns as $pattern) {
            $patternFile = fopen(__DIR__ . $this->patternsDir . $pattern[0] . '.txt', 'x');
            fwrite($patternFile, $pattern[2]);
        }

    }

    public function testPatternNotFound() {
        $this->expectException(PatternNotFoundException::class);
        $this->patternFactory->getPattern('randomPatternName');
    }

    public function testPatternParser() {

        $this->assertPopulationEquals([
            [0, 1],
            [1, 0]
        ], $this->patternFactory->parse(<<<'EOD'
01
10
EOD
        ));

        $this->assertPopulationEquals([
            [1, 1, 1],
            [0, 0, 0],
            [1, 1, 1]
        ], $this->patternFactory->parse(<<<'EOD'
111
000
111
EOD
        ));

    }

    public function testPatternReader() {

        foreach($this->patterns as $pattern) {

            $this->assertPopulationEquals($pattern[1], $this->patternFactory->getPattern($pattern[0]));

        }

    }

    public function testRandomPatternDimension() {

        $this->assertPopulationDimensions(
            3, 3,
            $this->patternFactory->getRandomPattern(0.5, 3, 3)
        );

        $this->assertPopulationDimensions(
            0, 0,
            $this->patternFactory->getRandomPattern(0.5, 0, 0)
        );

    }

    public function tearDown() {

        foreach ($this->patterns as $pattern) {
            unlink(__DIR__ . $this->patternsDir . $pattern[0] . '.txt');
        }

    }

}
