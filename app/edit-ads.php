<?php

require_once '../vendor/autoload.php';

$ads = new App\Ads();

$ads->updateEditAds($_POST['name'], $_POST['category'] , $_POST['price'], $_POST['description'] , $_POST['status'], $_POST['id']);

//echo json_encode($ads->responseUpdateAds());
