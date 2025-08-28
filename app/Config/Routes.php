<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Task::index');
$routes->get('/tasks', 'Task::index');
$routes->get('/tasks/data', 'Task::getData');
$routes->post('/tasks', 'Task::create');
$routes->get('/tasks/(:num)', 'Task::show/$1');
$routes->put('/tasks/(:num)', 'Task::update/$1');
$routes->delete('/tasks/(:num)', 'Task::delete/$1');
$routes->post('/tasks/update-status', 'Task::updateStatus');
