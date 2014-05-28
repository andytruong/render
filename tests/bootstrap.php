<?php

use Zend\EventManager\EventManager;

require_once __DIR__ . '/../src/functions/fn.php';

$locations[] = __DIR__ . "/../vendor/autoload.php";
$locations[] = __DIR__ . "/../../../autoload.php";

foreach ($locations as $location) {
    if (is_file($location)) {
        $loader = require $location;
        $loader->addPsr4('AndyTruong\\Render\\TestCases\\', __DIR__.'/render');
        break;
    }
}

// Setup Twig loader
$em = new EventManager();
$em->attach('at.twig.factory.init', function($e) {
    $e
        ->getTarget()
        ->setLoader($loader = new Twig_Loader_String());
});
at_event_manager('at.twig.factory', $em);
