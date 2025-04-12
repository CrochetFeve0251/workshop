<?php
/**
 * Plugin Name: Workshop
 */

use Workshop\ChangeSitemap\Subscriber;
use Workshop\Kernel\EventManager\EventManager;
use Workshop\Kernel\Kernel;

require_once __DIR__ . '/vendor/autoload.php';

$kernel = new Kernel(new EventManager());

$kernel->boot([
    Subscriber::class,
]);