
<?php
session_start();

define('MODULE_USER_PATH', dirname(__FILE__));

define('SLIM_APP_NAME', 'Skeleton');
define('SLIM_TEMPLATE', MODULE_USER_PATH . '/templates');
define('SLIM_TEMPLATE_LAYOUT', SLIM_TEMPLATE . '/layout/');

include_once MODULE_USER_PATH . '/../lib/Slim/Slim.php';
include_once MODULE_USER_PATH . '/Base.php';
include_once MODULE_USER_PATH . '/FrontController.php';

\Slim\Slim::registerAutoloader();

$oApp = new \Slim\Slim(array(
	'templates.path' => SLIM_TEMPLATE,
	'debug' => true,
));
$oApp->setName(SLIM_APP_NAME);

$oFrontController = new FrontController();
$oFrontController->init();

