<?php

require_once '../vendor/autoload.php';

$auth = new App\Authorization($_POST['email'], $_POST['password']);

echo json_encode($auth->responseCheckDataUser());
