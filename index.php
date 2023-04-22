<?php

session_start();

require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('assets/templates');

$twig = new \Twig\Environment($loader);

\App\Registration::setDefaultUser();

echo $twig->render('nav-bar.twig', array('user' => $_SESSION['user'], 'id' => $_SESSION['id']));

switch($_GET['mode'])
{
    case "register":
        echo $twig->render('register.twig');
        break;
    case "authorization":
        echo $twig->render('authorization.twig');
        break;
    case "profile":
        echo $twig->render('profile.twig', array('user' => $_SESSION['user'], 'id' => $_SESSION['id'], 'phoneNumber' => $_SESSION['phoneNumber']));
        break;
    case "logout":
        unset($_SESSION['user'], $_SESSION['id'], $_SESSION['phoneNumber']);
        header('Location: ../index.php');
        break;
    case "ads":
        echo $twig->render('ads-main-page.twig', array('user' => 'im user'));
        break;
    case "ads-create":
        echo $twig->render('ads-create.twig', array('123' => '123'));
        break;
}

//case "create-account":
//        $register = new App\Registration($_POST['name'], $_POST['surname'], $_POST['middleName'], $_POST['email'], $_POST['phoneNumber'], $_POST['password']);
//        echo json_encode($register->responseCreateAccount());
//        break;
