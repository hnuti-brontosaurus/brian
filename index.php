<?php

use Tracy\Debugger;
use App\Config;
use App\Utils\Env;
use App\User;

use App\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Matcher\UrlMatcher;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;

use App\Controller\Error;

require_once ('vendor/autoload.php');

// loading configuration

$config = new Config();
$config->load('Config/global.php');

$envUtils = new Env();
if ($envUtils->getEnv('ENVIRONMENT') !== false) {
    $config->load('Config/'. $envUtils->getEnv('ENVIRONMENT') .'.php');
}

// starting debugger

if ($config->get('env.showDebbuger')) {
    Debugger::enable(Debugger::DEVELOPMENT);
}

// matching requests

/** @var App\Request $request */
$request = Request::createFromGlobals();
$request->setSession(new Session());

$user = new User($request);

$routes = new RouteCollection();

$routes->add('index', new Route('/', ['_controller' => 'Index']));
$routes->add('logout', new Route('/logout', ['_controller' => 'Logout']));
$login = new Route('/login', ['_controller' => 'Login']);
$login->setMethods(['GET']);
$routes->add('login', $login);
$loginPost = new Route('/login', ['_controller' => 'Login']);
$loginPost->setMethods(['POST']);
$routes->add('postLogin', $loginPost);

$context = new RequestContext();
$context->fromRequest($request);
$router = new UrlMatcher($routes, $context);

try {
    $match = $router->matchRequest($request);

    // calling controller
    $calledControllerName = 'App\Controller\\' . $match['_controller'];
    if (class_exists($calledControllerName)) {
        /** @var \App\Controller $controller */
        $controller = new $calledControllerName($config, $request, $match);
    } else {
        throw new ResourceNotFoundException('Controller '. $match['_controller'] .' not found.');
    }
} catch (ResourceNotFoundException $e) {
    $controller = new Error($config, $request, []);
}




/** @var \Symfony\Component\HttpFoundation\Response $response */
$response = $controller->run();
$response->send();
