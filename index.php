<?php

session_start();

require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('assets/templates');

$twig = new \Twig\Environment($loader);

\App\Registration::setDefaultUser();

echo $twig->render('nav-bar.twig', array('user' => $_SESSION['user']));

switch($_GET['mode'])
{
    case "register":
        echo $twig->render('register.twig');
        break;
    case "authorization":
        echo $twig->render('authorization.twig');
        break;
    case "profile":
        echo $twig->render('profile.twig', array('user' => $_SESSION['user']));
        break;
    case "logout":
        unset($_SESSION['user']);
        header('Location: ../index.php');
        break;

}

//case "create-account":
//        $register = new App\Registration($_POST['name'], $_POST['surname'], $_POST['middleName'], $_POST['email'], $_POST['phoneNumber'], $_POST['password']);
//        echo json_encode($register->responseCreateAccount());
//        break;
