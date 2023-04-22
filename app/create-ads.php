<?php

session_start();

require_once '../vendor/autoload.php';

$creat = new App\CreateAds($_POST['name'], $_POST['category'], $_POST['price'], $_POST['description'], $_SESSION['phoneNumber'], $_SESSION['id']);

echo json_encode($creat->responseCreateAds());