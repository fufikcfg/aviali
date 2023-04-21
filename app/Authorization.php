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

    private function getUserNameForSession() : string {
        $result =  \App\DataBase::getConnectToDataBase()->query(sprintf("SELECT * FROM `user` WHERE `email` = '%s' AND `password` = '%s'", $this->email, md5($this->password)));
        $userFullName = $result->fetchAll(PDO::FETCH_NUM);

        return sprintf("%s %s %s", $userFullName[0][1], $userFullName[0][2], $userFullName[0][3]);
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

        session_start();
        $_SESSION['user'] = $this->getUserNameForSession();
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

