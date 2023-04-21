<?php

require_once 'vendor/autoload.php';
require_once 'app/navbar.php';

$loader = new \Twig\Loader\FilesystemLoader('assets/templates');

$twig = new \Twig\Environment($loader);


switch($_GET['mode'])
{
    case "register":
        echo $twig->render('register.twig');
        break;
    case "test":
        echo 'work';
        break;

}
