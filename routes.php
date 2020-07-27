<?php 
use Core\Router;

Router::connect('/', ['controller' => 'app', 'action' => 'index']);
Router::connect('/register', ['controller' => 'user', 'action' => 'register']);
Router::connect('/film/show/{id}', ['controller' => 'film', 'action' => 'show']);
Router::connect('/film/update/{id}', ['controller' => 'film', 'action' => 'update']);
Router::connect('/film/delete/{id}', ['controller' => 'film', 'action' => 'delete']);



?>