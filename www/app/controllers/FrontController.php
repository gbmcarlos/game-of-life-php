<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/6/17
 * Time: 11:38 AM
 */

namespace App\controllers;


use App\services\GameDrawer\GameDrawerInterface;
use App\services\GameOfLife\Generation;
use App\services\PatternFactory\PatternFactoryInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;

class FrontController {

    private $twig;
    private $patternFactory;
    private $gameDrawer;

    public function __construct(\Twig_Environment $twig, PatternFactoryInterface $patternFactory, GameDrawerInterface $gameDrawer) {
        $this->twig = $twig;
        $this->patternFactory = $patternFactory;
        $this->gameDrawer = $gameDrawer;
    }

    public function index(Request $request) {
        return $this->twig->render('index.twig');
    }

    public function randomPattern(Request $request) {

        $generation = new Generation(
            38, 38,
            $pattern = $this->patternFactory->getRandomPattern(0.5, 38, 38)
        );

        $gifFile = $this->gameDrawer->drawGame($generation, 100);

        return new BinaryFileResponse($gifFile);

    }

    public function gospersGliderGun(Request $request) {

        $generation = new Generation(
            38, 38,
            $pattern = $this->patternFactory->getPattern('gospers-glider-gun', 38, 38)
        );
        $gifFile = $this->gameDrawer->drawGame($generation, 100);

        return new BinaryFileResponse($gifFile);

    }

}