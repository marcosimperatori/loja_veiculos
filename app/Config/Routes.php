<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('/fabricantes', 'FabricanteController::index');
$routes->post('/fabricantes/criar', 'FabricanteController::criar');

$routes->post('/fabricantes/atualizar/(:alphanum)', 'FabricanteController::atulizar/$1'); //ajax
$routes->get('/fabricantes/editar/(:alphanum)', 'FabricanteController::edit/$1'); //ajax
$routes->get('/fabricantes_all', 'FabricanteController::getAll'); //ajax


$routes->get('/clientes', 'ClienteController::index');
