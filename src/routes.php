<?php

use lib\User;
use lib\Project;
use lib\Requirement;
use lib\ProgrammingLanguage;

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
    $router->respond('GET', '/profile/[i:id]', function($request, $response, $service, $app) {
        $user = new User($app->db);
        $user->getProfile($request->id);

        $service->render(__DIR__ . '/Views/profile.php', [
            'user' => $user->getProfile($_SESSION['user_id'])
        ]);
    });
    $router->respond('GET', '/profile', function($request, $response, $service, $app) {
        $user = new User($app->db);

        $service->render(__DIR__ . '/Views/profile.php', [
            'user' => $user->getProfile($_SESSION['user_id'])
        ]);
    });

    // project route
    $router->respond('GET', '/project', function($request, $response, $service, $app) {
      $projects = Project::findAll($app->db,[
        'owner' => $_SESSION['user_id']
      ]);
      $service->render(__DIR__ . '/Views/project.php', [
        'projects' => $projects
      ]);
    });

    $router->respond('GET', '/project/new', function($request, $response, $service, $app) {
      $service->render(__DIR__ . '/Views/editProject.php', [
        'project' => new Project($app->db),
        'programmingLanguages' => ProgrammingLanguage::findAll($app->db)
      ]);
    });
    $router->respond('GET', '/project/edit/[i:id]', function($request, $response, $service, $app) {
      $service->render(__DIR__ . '/Views/editProject.php', [
        'project' => new Project($app->db,$request->id),
        'programmingLanguages' => ProgrammingLanguage::findAll($app->db)
      ]);
    });
    $router->respond('POST', '/project/save', function($request, $response, $service, $app) {
      $id = ($_POST['id']!=='')?(int)$_POST['id']:null;
      $project = new Project($app->db,$id);
      $project->set("name", $_POST['name']);
      $project->set("owner", $_SESSION['user_id']);
      $project->set("description", $_POST['description']);
      $project->save();
      $id = $project->getId();
      $pl = $_POST['pl'];
      $oldRequirements = $project->getRequirements();
      foreach($oldRequirements as $opl){
        if( !in_array( $opl->getId('programmingLanguage'), $pl ) )
          $opl->remove();
      }
      foreach($pl as $plid){
        $requirement = new Requirement($app->db,$id,$plid);
        $requirement->save();
      }
      $response->redirect(App::getBaseUrl().'project');
    });
	

    // project route
    $router->respond('GET', '/search', function($request, $response, $service, $app) {
		$service->render(__DIR__ . '/Views/search.php', []);
    });
	
	// project route
    $router->respond('POST', '/search', function($request, $response, $service, $app) {
        $db = $app->db;
		
		$query = $request->param('query');

		$result = $db->query('Select id, firstname, lastname, CONCAT(firstname, lastName,email) AS search FROM User HAVING search LIKE "%'.$query.'%"')->fetchAll();
		$result2 = $db->query('Select id, CONCAT(name) AS search FROM Project HAVING search LIKE "%'.$query.'%"')->fetchAll();
		$service->render(__DIR__ . '/Views/resultsearch.php', ['userList' => $result, 'projectList' => $result2]);
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
