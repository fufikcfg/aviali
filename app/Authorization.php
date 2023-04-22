<?php

namespace App;

use PDO;

class Authorization
{
    private $email;
    private $password;
    private $errorMessage;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    private function checkDataUser() : bool {
        $result =  \App\DataBase::getConnectToDataBase()->query(sprintf("SELECT * FROM `user` WHERE `email` = '%s' AND `password` = '%s'", $this->email, md5($this->password)));

        if($result->fetch() > 0) {

            return true;
        }

        $this->errorMessage = 'Такого пользователя нет';

        return false;
    }

    private function getUserDataForSession() : array {
        $result =  \App\DataBase::getConnectToDataBase()->query(sprintf("SELECT * FROM `user` WHERE `email` = '%s' AND `password` = '%s'", $this->email, md5($this->password)));

        return $result->fetchAll(PDO::FETCH_NUM);

    }

    private function checkingTheFillingBox() : bool {
        if(empty($this->email) or empty($this->password)){

            $this->errorMessage = 'Какое то из полей пустое. Надо заполнить все поля';

            return false;
        }
        return true;
    }

    private function checkValidEmail() : bool {
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        $this->errorMessage = 'Плохой email адрес';
        return false;
    }

    private function createSession() : void {

        $userData = $this->getUserDataForSession();

        session_start();

        $_SESSION['user'] = sprintf("%s %s %s", $userData[0][1], $userData[0][2], $userData[0][3]);

        $_SESSION['id'] = $userData[0][0];

        $_SESSION['phoneNumber'] = $userData[0][5];
    }

    private function successfulAuth() : bool {
        if($this->checkingTheFillingBox() and $this->checkValidEmail() and $this->checkDataUser()) {

            $this->createSession();

            return true;
        }
        return false;
    }

    public function responseCheckDataUser() : array {
        if($this->successfulAuth()) {
            return [
                "status" => $this->successfulAuth(),
            ];
        }
        else {
            return [
                "status" => $this->successfulAuth(),
                "message" => $this->errorMessage
            ];
        }
    }
}

