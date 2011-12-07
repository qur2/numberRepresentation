<?php
require 'Slim/Slim.php';
require 'lib/Factory.php';

$app = new Slim(array(
	'mode' => 'dev',
	// 'view' => 'MustacheView',
	'templates.path' => './templates',
));

// prod mode definition
$app->configureMode('prod', function() use ($app) {
	$app->config(array(
		'log.enable' => true,
		'log.path' => './logs',
		'log.level' => 4,
		'debug' => false
	));
});

// dev mode definition
$app->configureMode('dev', function() use ($app) {
	$app->config(array(
		'log.enable' => false,
		'debug' => true
	));
});

/**
 * 404 handler.
 */
$app->notFound(function() use ($app) {
	$app->response()->status(404);
});

/**
 * Answers to the service requests by doing the following steps :
 *  - Builds a class name base on parameters.
 *  - Instantiates an object of this type, giving the input value as a parameter.
 *  - Pass the object to the view and renders it based on required response type.
 * @param string $responseType The expected response type
 * @param string $language The language which the service is queried for
 * @param string $inputType The item type for which the representation is asked
 * @param string $inputValue The actual item for which the representation is asked
 */
$app->get('/:responseType/:language/:inputType/:inputValue', function($responseType, $language, $inputType, $inputValue) use ($app) {
	$ucLanguage = ucFirst($language);
	$ucInputType = ucFirst($inputType);
	// the vendor path is generated based on the current route parameters
	$vendor = "vendor/{$language}/{$ucLanguage}{$ucInputType}.php";
	if (!Factory::isLoadable($vendor)) {
		$app->notFound();
	}
	$result = $success = false;
	try {
		$result = Factory::load(realpath($vendor), array($inputValue));
		$success = true;
	}
	catch (RuntimeException $e) {
		$result = $e->getMessage();
		$success = false;
	}
	$template = $responseType.'.php';
	$app->response()->header('Content-Type', 'text/'.$responseType);
	$app->render($template, array(
		'result' => $result,
		'success' => $success,
	));
});

/**
 * Renders the simple UI.
 */
$app->get('/', function() use ($app) {
	$basePath = $app->request()->getRootUri();
	$app->render('home.php', array(
		'basePath' => $basePath,
	));
});

$app->run();
