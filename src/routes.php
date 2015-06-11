<?php

require_once("lib/project.php");

/**
 * Documentation:
 * @see https://github.com/chriso/klein.php
 *
 * @param \Klein\Klein $router
 */
$routes = function (\Klein\Klein $router) {
    /////////////////////////
    // Define Routes here
    /////////////////////////

    // index route
    $router->respond('GET', '/', function($request, $response, $service, $app) {
        $service->render(__DIR__ . '/Views/index.php', []);
    });

    // login route
    $router->respond('GET', '/login', function($request, $response, $service, $app) {
        $service->render(__DIR__ . '/Views/login.php', []);
    });

    // profile route
    $router->respond('GET', '/profile', function($request, $response, $service, $app) {
        $service->render(__DIR__ . '/Views/profile.php', []);
    });

    // project route
    $router->respond('GET', '/project', function($request, $response, $service, $app) {
      $projects = \lib\Project::findAll($app->db);
//      $projects = \lib\Project::findAllByOwner($app->db,$current_user);
      $service->render(__DIR__ . '/Views/project.php', [
        'projects' => $projects
      ]);
    });
};
$routes($this);



// Demo
$this->respond('GET', '/demo/[a:param]?', function($request, $response, $service, $app) {
    /**
     * $app->db is an instance of PDO @see http://php.net/manual/de/book.pdo.php
     */
    $db = $app->db;

    $result = $db->query('SELECT * FROM test;')->fetchAll();

    $response->dump($result);
    $response->dump($request->param);

    $service->render(__DIR__ . '/Views/demo.php', ['param' => 'test123äöü']);
});
