<?php

use lib\User;
use lib\Project;

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

    // Check if logged in
    $router->respond(function($request, $response, $service, $app) {
        // skip login check if its / or /login or /logout or /signup
        if ($request->uri() === '/' || $request->uri() === '/login' ||
            $request->uri() === '/logout' || $request->uri() === '/signup') {
            return;
        }

        $user = new User($app->db);
        if(!$user->isLoggedIn()) {
            $response->redirect(App::getBaseUrl() . 'login', 405);
        }
    });

    // index route
    $router->respond('GET', '/', function($request, $response, $service, $app) {
        $service->render(__DIR__ . '/Views/index.php', []);
    });

    // signup route
    $router->respond('GET', '/signup', function($request, $response, $service, $app) {
        $service->render(__DIR__ . '/Views/signup.php', []);
    });

    // signup route
    $router->respond('POST', '/signup', function($request, $response, $service, $app) {
        $userdata = $request->params(['email', 'password', 'confirmPassword', 'firstName', 'lastName']);

        if ($userdata['password'] !== $userdata['confirmPassword']) {
            $service->flash('Passwort muss gleich sein!', 'signup-error');
            $service->back();
            return;
        } elseif (count($userdata) != count(array_filter($userdata, 'strlen'))) {
            $service->flash('Alle Felder müssen ausgefüllt sein!', 'signup-error');
            $service->back();
            return;
        }

        unset($userdata['confirmPassword']);

        $user = new User($app->db);

        if ($user->createUser($userdata)) {
            $user->login($userdata['email'], $userdata['password']);
            $service->flash(sprintf('Du bist registriert und eingeloggt %s %s.', $userdata['firstName'], $userdata['lastName']));
            $response->redirect(App::getBaseUrl());
        } else {
            $service->flash('User konnte nicht erstellt werden!', 'signup-error');
            $service->back();
        }
    });

    // login route
    $router->respond('GET', '/login', function($request, $response, $service, $app) {
        $service->render(__DIR__ . '/Views/login.php', []);
    });

    // login route
    $router->respond('POST', '/login', function($request, $response, $service, $app) {
        $user = new User($app->db);
        if ($user->login($request->param('email'), $request->param('password'))) {
            // success
            $info = $user->getLoginUserInfo();
            $service->flash(sprintf('Du bist eingeloggt %s %s.', $info['firstName'], $info['lastName']));
            $response->redirect(App::getBaseUrl());
        } else {
            // fail
            $service->flash('Konnte nicht eingeloggt werden! (Username / Passwort falsch)', 'login-error');
            $service->back();
        }
    });

    // logout
    $router->respond('GET', '/logout', function($request, $response, $service, $app) {
        $user = new User($app->db);
        $user->logout();
        $service->flash('Du bist ausgeloggt.');
        $response->redirect(App::getBaseUrl());
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
