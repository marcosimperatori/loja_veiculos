<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('/fabricantes', 'FabricanteController::index');

$routes->get('/clientes', 'ClienteController::index');
