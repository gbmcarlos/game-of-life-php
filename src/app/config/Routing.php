<?php
/**
 * Created by PhpStorm.
 * User: gbmcarlos
 * Date: 11/6/17
 * Time: 11:34 AM
 */

namespace App\config;

use Silex\Application;

class Routing {

    public static function registerRoutes(Application $app){

        // Register routes here
        $app->get('/', "FrontController:index")
            ->bind('index');

        $app->get('/random-pattern', "FrontController:randomPattern")
            ->bind('random-pattern');

        $app->get('/gospers-glider-gun', "FrontController:gospersGliderGun")
            ->bind('gospers-glider-gun');

    }

}