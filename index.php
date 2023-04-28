<?php

require_once "vendor/autoload.php";

use phpQuinielas\controllers\EquiposController;
use phpQuinielas\controllers\JornadasController;
use phpQuinielas\controllers\PartidosController;

// use phpQuinielas\models\Jornadas;
// $selectJornadas = Jornadas::getSelect(0);

$routes = require 'routes/routes.php';

// $uri = trim($_SERVER['REQUEST_URI'], '/');

$requestURI = explode("/", $_SERVER['REQUEST_URI']);
$requestURI = array_filter($requestURI);

if (count($requestURI) == 0)
{
    $uri = "equipos";
}
else
{
    $uri = $requestURI[1];
}

if (array_key_exists($uri, $routes))
{
    switch ($uri) {
        case 'equipos':
            include "./views/EquiposView.php";
            break;

        case 'ajaxequipos':
            // require $routes[$uri];
            EquiposController::procesar();
            break;

        case 'jornadas':
            include "./views/JornadasView.php";
            // require $routes[$uri];
            // PartidosController::procesar();
            break;

        case 'ajaxjornadas':
            // require $routes[$uri];
            JornadasController::procesar();
            break;
    
        case 'partidos':
            include "./views/PartidosView.php";
            // require $routes[$uri];
            // PartidosController::procesar();
            break;

        case 'ajaxpartidos':
            // require $routes[$uri];
            PartidosController::procesar();
            break;
        }
}
else
{
    echo "ERROR en url\n";
}

?>