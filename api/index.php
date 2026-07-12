<?php
// Set Laravel cache paths to Vercel's writable /tmp directory
$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
$_SERVER['APP_SERVICES_CACHE'] = '/tmp/services.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
$_SERVER['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_SERVER['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes-v7.php';
$_SERVER['APP_ROUTES_CACHE'] = '/tmp/routes-v7.php';
$_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';
$_SERVER['APP_EVENTS_CACHE'] = '/tmp/events.php';
$_ENV['VIEW_COMPILED_PATH'] = '/tmp';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp';

// Forward Vercel requests to normal Laravel index.php
require __DIR__ . '/../public/index.php';
