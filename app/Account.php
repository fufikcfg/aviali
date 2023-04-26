<?php

namespace App;
use PDO;
abstract class Account
{
    public $name;
    public $surname;
    public $middleName;
    public $email;
    public $phoneNumber;
    public $password;

    public $errorMessage;

    public function __construct($name, $surname, $middleName, $email, $phoneNumber, $password)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->middleName = $middleName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->password = $password;
    }

    protected function checkValidEmail() : bool {
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        $this->errorMessage = 'Плохой email адрес';
        return false;
    }

    protected function mb_ucfirst($str, $encoding='UTF-8') : string {

        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
            mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }

    protected function getDataUser() : array {

        $result =  \App\DataBase::getConnectToDataBase()->query(sprintf("SELECT * FROM `user` WHERE `email` = '%s' AND `password` = '%s'", $this->email, md5($this->password)));

        return $result->fetchAll(PDO::FETCH_NUM);

    }

    protected function createSession() : void {

        $userData = $this->getDataUser();

        session_start();

        $_SESSION['id'] = $userData[0][0];

        $_SESSION['phoneNumber'] = $userData[0][5];

        $_SESSION['user'] = sprintf("%s %s %s", $userData[0][2], $userData[0][1], $userData[0][3]);

    }
}