<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('/fabricantes', 'FabricanteController::index');
$routes->post('/fabricantes/criar', 'FabricanteController::criar'); //ajax
$routes->post('/fabricantes/atualizar', 'FabricanteController::atualizar'); //ajax
$routes->get('/fabricantes/editar/(:alphanum)', 'FabricanteController::edit/$1'); //ajax
$routes->post('/fabricantes/excluir/(:alphanum)', 'FabricanteController::deletar/$1'); //ajax
$routes->get('/fabricantes_all', 'FabricanteController::getAll'); //ajax


$routes->get('clientes', 'ClienteController::index');
$routes->get('clientes_all', 'ClienteController::getAll'); //ajax
$routes->get('clientes/criar', 'ClienteController::criar');
$routes->post('clientes/inserir', 'ClienteController::cadastrar'); //ajax

$routes->get('veiculos', 'VeiculoController::index');
$routes->get('veiculos_all', 'VeiculoController::getAll'); //ajax
$routes->get('veiculos/criar', 'VeiculoController::criar'); //ajax
$routes->post('veiculos/inserir', 'VeiculoController::cadastrar');
$routes->get('veiculos/editar/(:alphanum)', 'VeiculoController::edit/$1');
$routes->post('veiculos/atualizar', 'VeiculoController::atualizar');
$routes->get('veiculos/deletar/(:alphanum)', 'VeiculoController::deletar/$1');
$routes->get('veiculos/confirma_exclusao/(:alphanum)', 'VeiculoController::confirma_exclusao/$1');
