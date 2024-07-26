<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\AgendaController;
use Controllers\PerfilController;
use Controllers\ClientesController;
use Controllers\UsuariosController;
use Controllers\DashboardController;
use Controllers\EventosAPI;
use Controllers\PaginaError;

$router = new Router();


//Iniciar Sesion
$router->get('/', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/logout', [LoginController::class, 'logout']);

//Area Privada
$router->get('/dashboard/panel', [DashboardController::class, 'index']);
$router->get('/dashboard/clientes', [ClientesController::class, 'index']);
$router->get('/dashboard/clientes/agregar', [ClientesController::class, 'agregar']);
$router->post('/dashboard/clientes/agregar', [ClientesController::class, 'agregar']);
$router->get('/dashboard/clientes/editar', [ClientesController::class, 'editar']);
$router->post('/dashboard/clientes/editar', [ClientesController::class, 'editar']);
$router->post('/dashboard/clientes/eliminar', [ClientesController::class, 'eliminar']);
$router->get('/dashboard/agenda', [AgendaController::class, 'index'] );
$router->post('/dashboard/agenda/agregar', [AgendaController::class, 'store'] );
$router->get('/dashboard/api/eventos', [EventosAPI::class, 'index'] );
$router->get('/dashboard/api/evento', [EventosAPI::class, 'evento'] );
$router->post('/dashboard/api/evento/actualizar', [EventosAPI::class, 'editar'] );


//Admin
$router->get('/dashboard/empleados', [UsuariosController::class, 'index']);
$router->get('/dashboard/empleados/agregar', [UsuariosController::class, 'agregar']);
$router->post('/dashboard/empleados/agregar', [UsuariosController::class, 'agregar']);
$router->get('/dashboard/empleados/editar', [UsuariosController::class, 'editar']);
$router->post('/dashboard/empleados/editar', [UsuariosController::class, 'editar']);
$router->post('/dashboard/empleados/eliminar', [UsuariosController::class, 'eliminar']);

//Perfil
$router->get('/dashboard/ajustes', [PerfilController::class, 'index']);
$router->post('/dashboard/ajustes', [PerfilController::class, 'index']);

//404
$router->get('/404', [PaginaError::class, 'index']);



$router->comprobarRutas();
