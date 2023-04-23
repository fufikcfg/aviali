<?php

namespace App;

use PDO;
class Registration
{

    private $name;
    private $surname;
    private $middleName;
    private $email;
    private $phoneNumber;
    private $password;

    private $errorMessage;

    public function __construct($name, $surname, $middleName, $email, $phoneNumber, $password)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->middleName = $middleName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->password = $password;
    }

    private function getUpperName()
    {
        return str_replace($this->name[0], strtoupper($this->name[0]), $this->name);
    }

    private function getUpperSurname()
    {
        return str_replace($this->surname[0], strtoupper($this->surname[0]), $this->surname);
    }

    private function getUpperMiddleName()
    {
        return str_replace($this->middleName[0], strtoupper($this->middleName[0]), $this->middleName);
    }

    private function addUserToDataBase() : void {
        \App\DataBase::getConnectToDataBase()->exec(sprintf("INSERT INTO `user` (`id`, `name`, `surname`, `middleName`, `email`, `phoneNumber`, `password`) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s');", $this->getUpperName(), $this->getUpperSurname(), $this->getUpperMiddleName(), $this->email, $this->phoneNumber, md5($this->password)));
    }

    private function getDataByUser() : array {

        $result =  \App\DataBase::getConnectToDataBase()->query(sprintf("SELECT * FROM `user` WHERE `email` = '%s' AND `password` = '%s'", $this->email, md5($this->password)));

        return $result->fetchAll(PDO::FETCH_NUM);

    }

    private function createSessionForAuthUser() : void {

        $userData = $this->getDataByUser();

        session_start();

        $_SESSION['id'] = $userData[0][0];

        $_SESSION['phoneNumber'] = $userData[0][5];

        $_SESSION['user'] = sprintf("%s %s %s", $this->surname, $this->name, $this->middleName);

    }

    public static function setDefaultUser() {
        if(empty($_SESSION['user'])) {
            $_SESSION['user'] = 'Non auth';
        }
    }

    private function checkingTheFillingBox() : bool {
        if(empty($this->name) or empty($this->surname) or empty($this->middleName) or empty($this->email) or empty($this->phoneNumber) or empty($this->password)){

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

    private function checkValidPhoneNumber() : bool {
        if (preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $this->phoneNumber)) {

            return true;
        }
        $this->errorMessage = 'Плохой номер телефона';
        return false;
    }

    private function checkDuplication() : bool {
        $check_duplication_FIO = \App\DataBase::getConnectToDataBase()->query(sprintf("SELECT * FROM `user` WHERE `name` = '%s' AND `surname` = '%s' AND `middleName` = '%s' AND `email` = '%s' AND `phoneNumber` = '%s'",$this->name, $this->surname, $this->middleName, $this->email, $this->phoneNumber));

        if($check_duplication_FIO->fetch() > 0)  {

            $this->errorMessage = sprintf('Такое пользователь уже есть: %s %s %s %s', $this->surname, $this->name, $this->middleName, $this->email);

            return false;

        }
        return true;
    }

    private function successfulCreateAccount() : bool {
        if($this->checkingTheFillingBox() and $this->checkValidEmail() and $this->checkValidPhoneNumber() and $this->checkDuplication()) {

            $this->addUserToDataBase();
            $this->createSessionForAuthUser();

            return true;
        }
        return false;
    }

    public function responseCreateAccount() : array {
        if($this->successfulCreateAccount()) {
            return [
                "status" => true,
            ];
        }
        else {
            return [
                "status" => false,
                "message" => $this->errorMessage,
            ];
        }
    }



}