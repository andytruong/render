<?php

use Zend\EventManager\EventManager;

$loader = require __DIR__ . "/../vendor/autoload.php";
$loader->addPsr4('AndyTruong\\Render\\TestCases\\', __DIR__.'/render');

// Setup Twig loader
$em = new EventManager();
$em->attach('at.twig.factory.init', function($e) {
    $e
        ->getTarget()
        ->setLoader($loader = new Twig_Loader_String());
});
at_event_manager('at.twig.factory', $em);
