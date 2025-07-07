<?php

use CodeIgniter\Router\RouteCollection;
$routes->setAutoRoute(false);
/**
 * @var RouteCollection $routes
 */
$routes->get('post/kategori', 'Post::kategori');
$routes->resource('post');

$routes->get('/home', 'page::home');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
// $routes->get('/faqs', 'Page::faqs');
// $routes->get('page/tos', 'Page::tos');
$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');
$routes->group('admin',['filters' => 'auth'], function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
    $routes->add('logout', 'User::logout');
    });

$routes->group('user', function($routes) {
    $routes->get('login', 'User::login');
    $routes->post('login', 'User::login');
    });  
    
$routes->get('/kategori/(:segment)', 'Artikel::kategori/$1');