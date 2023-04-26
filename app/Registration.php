<?php

namespace App;

use PDO;
class Registration extends Account
{
    public function __construct($name, $surname, $middleName, $email, $phoneNumber, $password)
    {
        parent::__construct($name, $surname, $middleName, $email, $phoneNumber, $password);
    }

    private function addUserToDataBase() : void {
        \App\DataBase::getConnectToDataBase()->exec(sprintf("INSERT INTO `user` (`id`, `name`, `surname`, `middleName`, `email`, `phoneNumber`, `password`) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s');", $this->mb_ucfirst($this->name), $this->mb_ucfirst($this->surname), $this->mb_ucfirst($this->middleName), $this->email, $this->phoneNumber, md5($this->password)));
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
            $this->createSession();

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