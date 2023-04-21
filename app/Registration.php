<?php

namespace App;

class Registration
{

    private $name;
    private $surname;
    private $middleName;
    private $email;
    private $phoneNumber;
    private $password;
    private $connect;

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

    private function addUserToDataBase() : void {
        \App\DataBase::getConnectToDataBase()->exec(sprintf("INSERT INTO `user` (`id`, `name`, `surname`, `middleName`, `email`, `phoneNumber`, `password`) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s');", $this->name, $this->surname, $this->middleName, $this->email, $this->phoneNumber, md5($this->password)));
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