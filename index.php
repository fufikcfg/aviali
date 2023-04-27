<?php

session_start();

require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('assets/templates');

$twig = new \Twig\Environment($loader);

\App\Registration::setDefaultUser();

$ads = new \App\Ads();

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
        echo $twig->render('ads-main-page.twig', array('ads' => $ads->getAdsByCategory($_GET['category']), 'id' => $_SESSION['id']));
        break;
    case "ads-create":
        echo $twig->render('ads-create.twig');
        break;
    case "delete-ads":
        $ads->queryForDeleteAds($_GET['id']);
        header('Location: index.php');
        break;
    case "edit-ads":
        echo $twig->render('ads-edit.twig', array('adsValue' => $ads->queryForEdit($_GET['id'])));
        break;
    default:
        echo $twig->render('ads-main-page.twig', array('ads' => $ads->getAllAds(), 'id' => $_SESSION['id']));
}

//case "create-account":
//        $register = new App\Registration($_POST['name'], $_POST['surname'], $_POST['middleName'], $_POST['email'], $_POST['phoneNumber'], $_POST['password']);
//        echo json_encode($register->responseCreateAccount());
//        break;
