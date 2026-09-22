<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Público
$routes->get('/', 'Home::index');
$routes->get('proyectos', 'Projects::index');
$routes->get('proyectos/(:segment)', 'Projects::show/$1');
$routes->get('blog', 'Posts::index');
$routes->get('blog/(:segment)', 'Posts::show/$1');
$routes->post('blog/(:segment)/comentarios', 'Comments::store/$1');
$routes->get('privacidad', 'Pages::privacy');

// Auth
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('registro', 'Auth::register');
$routes->post('registro', 'Auth::attemptRegister');
$routes->post('logout', 'Auth::logout');

// Suscriptores
$routes->group('demo', ['filter' => 'subscriber'], static function ($routes) {
    $routes->get('(:segment)', 'Demo::show/$1');
});

// Admin
$routes->group('admin', ['filter' => 'admin', 'namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('/', 'Dashboard::index');

    $routes->get('proyectos', 'Projects::index');
    $routes->get('proyectos/nuevo', 'Projects::new');
    $routes->post('proyectos', 'Projects::create');
    $routes->get('proyectos/(:num)/editar', 'Projects::edit/$1');
    $routes->post('proyectos/(:num)', 'Projects::update/$1');
    $routes->post('proyectos/(:num)/eliminar', 'Projects::delete/$1');
    $routes->post('proyectos/imagenes/(:num)/eliminar', 'Projects::deleteImage/$1');
    $routes->post('proyectos/imagenes/(:num)/portada', 'Projects::coverImage/$1');

    $routes->get('comentarios', 'Comments::index');
    $routes->post('comentarios/(:num)/estado', 'Comments::setStatus/$1');
    $routes->post('comentarios/(:num)/eliminar', 'Comments::delete/$1');

    $routes->get('usuarios', 'Users::index');
    $routes->post('usuarios/(:num)/estado', 'Users::toggleStatus/$1');
    $routes->post('usuarios/(:num)/rol', 'Users::setRole/$1');
    $routes->post('usuarios/(:num)/eliminar', 'Users::delete/$1');

    $routes->get('posts', 'Posts::index');
    $routes->get('posts/nuevo', 'Posts::new');
    $routes->post('posts', 'Posts::create');
    $routes->get('posts/(:num)/editar', 'Posts::edit/$1');
    $routes->post('posts/(:num)', 'Posts::update/$1');
    $routes->post('posts/(:num)/eliminar', 'Posts::delete/$1');
});
