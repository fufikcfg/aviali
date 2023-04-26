<?php

namespace App;

use PDO;

class Authorization extends Account
{

    public function __construct($email, $password)
    {
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
    private function checkingTheFillingBox() : bool {
        if(empty($this->email) or empty($this->password)){

            $this->errorMessage = 'Какое то из полей пустое. Надо заполнить все поля';

            return false;
        }
        return true;
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

