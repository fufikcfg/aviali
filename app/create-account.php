<?php

require_once '../vendor/autoload.php';

$register = new App\Registration($_POST['name'], $_POST['surname'], $_POST['middleName'], $_POST['email'], $_POST['phoneNumber'], $_POST['password']);

echo json_encode($register->responseCreateAccount());

