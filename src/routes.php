<?php

use lib\ProjectHelpers;
use lib\UserHelpers;

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
    $router->respond(function ($request, $response, $service, $app) {
        // skip login check if its / or /login or /logout or /signup
        $uri = $request->uri();
        if ($uri === '/' || 0 === strpos($uri, '/login') ||
            0 === strpos($uri, '/logout') || 0 === strpos($uri, '/signup')
        ) {
            return;
        }

        $user = new UserHelpers($app->db);
        if (!$user->isLoggedIn()) {
            $response->redirect(App::getBaseUrl() . 'login', 405);
            $response->send();
        }
    });

    // index route
    $router->respond('GET', '/', function ($request, $response, $service, $app) {
        $service->render(__DIR__ . '/Views/index.php', []);
    });

    // signup route
    $router->respond('GET', '/signup', function ($request, $response, $service, $app) {
        $service->render(__DIR__ . '/Views/signup.php', []);
    });

    // signup route
    $router->respond('POST', '/signup', function ($request, $response, $service, $app) {
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

        $user = new UserHelpers($app->db);

        if ($user->create($userdata)) {
            $user->login($userdata['email'], $userdata['password']);
            $service->flash(sprintf('Du bist registriert und eingeloggt %s %s.', $userdata['firstName'], $userdata['lastName']));
            $response->redirect(App::getBaseUrl());
        } else {
            $service->flash('UserHelpers konnte nicht erstellt werden!', 'signup-error');
            $service->back();
        }
    });

    // login route
    $router->respond('GET', '/login', function ($request, $response, $service, $app) {
        $service->render(__DIR__ . '/Views/login.php', []);
    });

    // login route
    $router->respond('POST', '/login', function ($request, $response, $service, $app) {
        $user = new UserHelpers($app->db);
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
    $router->respond('GET', '/logout', function ($request, $response, $service, $app) {
        $user = new UserHelpers($app->db);
        $user->logout();
        $service->flash('Du bist ausgeloggt.');
        $response->redirect(App::getBaseUrl() . 'login');
    });

    // profile route
    $router->respond('GET', '/profile', function ($request, $response, $service, $app) {
        $user = new UserHelpers($app->db);

        $service->render(__DIR__ . '/Views/profile.php', [
            'user' => $user->getProfile($_SESSION['user_id'])
        ]);
    });

    $router->respond('GET', '/profile/[i:id]', function ($request, $response, $service, $app) {
        $user = new UserHelpers($app->db);

        $service->render(__DIR__ . '/Views/profile.php', [
            'user' => $user->getProfile($request->id)
        ]);
    });

    $router->respond('GET', '/profile/edit', function ($request, $response, $service, $app) {
        $user = new UserHelpers($app->db);
        $project = new ProjectHelpers($app->db);

        $userInfo = $user->getLoginUserInfo();
        $userLangs = $user->getUserLangs($_SESSION['user_id']);
        $langs = $project->getLangs();

        $service->render(__DIR__ . '/Views/editProfile.php', [
            'user' => $userInfo,
            'langs' => array_diff_key($langs, $userLangs),
            'userLangs' => $userLangs

        ]);
    });

    $router->respond('POST', '/profile/edit', function ($request, $response, $service, $app) {
        $user = new UserHelpers($app->db);
        $input = $request->params(['firstName', 'lastName', 'email', 'description', 'pl']);
        $input['id'] = $_SESSION['user_id'];
        $user->update($input);
        $response->redirect(App::getBaseUrl() . 'profile');
    });

    // project route
    /* $router->respond('GET', '/project', function ($request, $response, $service, $app) {
        $project = new ProjectHelpers($app->db);

        $projects = $project->getAllFromOwner($_SESSION['user_id']);
        $idList = array_column($projects, 'id');
        $requirements = $project->getLangsForProjects($idList);

        $service->render(__DIR__ . '/Views/project.php', [
            'projects' => $projects,
            'requirements' => $requirements
        ]);
    });*/

    $router->respond('GET', '/project/[i:id]', function ($request, $response, $service, $app) {
        $projectHelper = new ProjectHelpers($app->db);
        $projectInfo = $projectHelper->getProjectPage($request->id);

        $service->render(__DIR__ . '/Views/viewProject.php', [
            'project' => $projectInfo
        ]);
    });

    $router->respond('GET', '/project/new', function ($request, $response, $service, $app) {
        $project = new ProjectHelpers($app->db);
        $langs = $project->getLangs();

        $service->render(__DIR__ . '/Views/editProject.php', [
            'edit' => false,
            'langs' => $langs
        ]);
    });

    $router->respond('POST', '/project/new', function ($request, $response, $service, $app) {
        $project = new ProjectHelpers($app->db);
        $input = $request->params(['name', 'description', 'pl']);
        $id = $project->create($_SESSION['user_id'], $input);
        $response->redirect(App::getBaseUrl() . 'project/' . $id);
    });

    $router->respond('GET', '/project/edit/[i:id]', function ($request, $response, $service, $app) {
        $projectHelper = new ProjectHelpers($app->db);
        $projectInfo = $projectHelper->getProjectPage($request->id);

        // Check if logged in user is owner
        if ($projectInfo['project']['Owner_Id'] !== $_SESSION['user_id']) {
            $service->flash('Nur der Besitzer eines Projekts kann dieses Bearbeiten!', 'error');
            $service->back();

            return;
        }

        $langs = $projectHelper->getLangs();

        $service->render(__DIR__ . '/Views/editProject.php', [
            'edit' => true,
            'project' => $projectInfo['project'],
            'projectLangs' => $projectInfo['languages'],
            'langs' => array_diff_key($langs, $projectInfo['languages'])
        ]);
    });

    $router->respond('POST', '/project/edit/[i:id]', function ($request, $response, $service, $app) {
        $project = new ProjectHelpers($app->db);
        $input = $request->params(['name', 'description', 'pl']);
        $input['id'] = $request->id;
        $project->update($input);
        $response->redirect(App::getBaseUrl() . 'project/' . $request->id);
    });

    $router->respond('GET', '/profile/applyproject/[i:id]', function ($request, $response, $service, $app) {
        $sql = "INSERT INTO developer (Project_id, User_id, statusProject, statusUser)
                VALUES ('$request->id', '{$_SESSION['user_id']}', 'UNDECIDED', 'ACCEPTED');";

        if ($app->db->query($sql)->rowCount() === 1) {
            $service->flash('Projekt wurde angefragt!');
        } else {
            $service->flash('Konnte nicht angefragt werden!', 'error');
        }
        $service->back();
    });

    $router->respond('GET', '/profile/respondproject/[i:id]/[a:response]', function ($request, $response, $service, $app) {
        $response = $request->response === 'ACCEPTED' ? 'ACCEPTED' : 'DECLINED';
        $sql = "UPDATE developer SET statusUser = '$response'
                WHERE Project_id = '$request->id' AND User_id = '{$_SESSION['user_id']}' AND statusProject = 'ACCEPTED';";

        if ($app->db->query($sql)->rowCount() === 1) {
            $service->flash('Projekt wurde genatwortet!');
        } else {
            $service->flash('Konnte nicht antworten!', 'error');
        }
        $service->back();
    });

    $router->respond('GET', '/project/[i:id]/applyuser/[i:userId]', function ($request, $response, $service, $app) {
        $sql = "INSERT INTO developer (Project_id, User_id, statusProject, statusUser)
                VALUES ('$request->id', '$request->userId', 'ACCEPTED', 'UNDECIDED');";

        if ($app->db->query($sql)->rowCount() === 1) {
            $service->flash('Projekt wurde angefragt!');
        } else {
            $service->flash('Konnte nicht angefragt werden!', 'error');
        }
        $service->back();
    });

    $router->respond('GET', '/project/[i:id]/responduser/[i:userId]/[a:response]', function ($request, $response, $service, $app) {
        $response = $request->response === 'ACCEPTED' ? 'ACCEPTED' : 'DECLINED';
        $sql = "UPDATE developer SET statusProject = '$response'
                WHERE Project_id = '$request->id' AND User_id = '$request->userId' AND statusUser = 'ACCEPTED';";

        if ($app->db->query($sql)->rowCount() === 1) {
            $service->flash('Projekt wurde genatwortet!');
        } else {
            $service->flash('Konnte nicht antworten!', 'error');
        }
        $service->back();
    });

    // project route
    $router->respond('GET', '/search', function ($request, $response, $service, $app) {
        $service->render(__DIR__ . '/Views/search.php', []);
    });

    // project route
    $router->respond('POST', '/search', function ($request, $response, $service, $app) {
        $db = $app->db;

        $query = $request->param('query');

        $result = $db->query('SELECT id, firstname, lastname, CONCAT(firstname, lastName,email) AS search FROM User HAVING search LIKE "%' . $query . '%"')->fetchAll();
        $result2 = $db->query('SELECT id, name, CONCAT(name) AS search FROM Project HAVING search LIKE "%' . $query . '%"')->fetchAll();
        $service->render(__DIR__ . '/Views/resultsearch.php', ['userList' => $result, 'projectList' => $result2]);
    });

};
$routes($this);


// Demo
$this->respond('GET', '/demo/[a:param]?', function ($request, $response, $service, $app) {
    /**
     * $app->db is an instance of PDO @see http://php.net/manual/de/book.pdo.php
     */
    $db = $app->db;

    $result = $db->query('SELECT * FROM test;')->fetchAll();

    $response->dump($result);
    $response->dump($request->param);

    $service->render(__DIR__ . '/Views/demo.php', ['param' => 'test123äöü']);
});
