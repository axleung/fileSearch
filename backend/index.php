<?php
//  The application directory is the current directory
define('APP_PATH', __DIR__ . '/');

// Enable debug mode
define('APP_DEBUG', true);

require_once(APP_PATH . 'core/bootstrap.php');
$config = require(APP_PATH . 'config/config.php');

// Start the application
(new core\bootstrap($config))->run();
