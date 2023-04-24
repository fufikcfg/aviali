<?php

namespace App;

class CreateAds
{
    private $nameAds;
    private $categoryAds;
    private $priceAds;
    private $descriptionAds;
    private $phoneNumberAds;
    private $errorMessage;
    private $creatorId;

    public function __construct($nameAds, $categoryAds, $priceAds, $descriptionAds, $phoneNumberAds, $creatorId)
    {
        $this->nameAds = $nameAds;
        $this->categoryAds = $categoryAds;
        $this->priceAds = $priceAds;
        $this->descriptionAds = $descriptionAds;
        $this->phoneNumberAds = $phoneNumberAds;
        $this->creatorId = $creatorId;
    }

    private function checkingTheFillingBox() : bool {
        if(empty($this->nameAds) or empty($this->categoryAds) or empty($this->priceAds) or empty($this->descriptionAds)){

            $this->errorMessage = 'Какое то из полей пустое. Надо заполнить все поля';

            return false;
        }
        return true;
    }

    private function replaceSpacesForPrice($price) : string {
        return preg_replace("/\s+/", "", $price);
    }

    private function getDefaultStatusAds() : string {
        return "Активно";
    }

    private function addAdsToDataBase() : void {
        \App\DataBase::getConnectToDataBase()->exec(sprintf("INSERT INTO `ads` (`idAds` , `name`, `category`, `price`, `description`, `contact`, `status`, `idUser`) VALUES (NULL ,'%s', '%s', '%d', '%s', '%s', '%s', '%d')", $this->nameAds, $this->categoryAds, $this->replaceSpacesForPrice($this->priceAds), $this->descriptionAds, $this->phoneNumberAds, $this->getDefaultStatusAds(), $this->creatorId));
    }

    private function successfulCreateAds() : bool {
        if($this->checkingTheFillingBox()) {

            $this->addAdsToDataBase();

            return true;
        }
        return false;
    }

    public function responseCreateAds() : array {
        if($this->successfulCreateAds()) {
            return [
                "status" => true,
            ];
        }
        else {
            return [
                "status" => false,
                "message" => $this->errorMessage
            ];
        }
    }

}