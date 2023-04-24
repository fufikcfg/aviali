<?php

namespace App;

use PDO;

class Ads
{
    private function queryByCategory($categories) : array {
        $result =  \App\DataBase::getConnectToDataBase()->query(sprintf("SELECT * FROM `ads` WHERE `category` = '%s'", $categories));
        return $result->fetchAll(PDO::FETCH_NUM);
    }

    public function getAllAds() : array {
        $result =  \App\DataBase::getConnectToDataBase()->query("SELECT * FROM `ads` ORDER BY `ads`.`idAds` DESC");
        return $result->fetchAll(PDO::FETCH_NUM);
    }

    public function getArrayAds($category) : array {
        switch ($category) {
            case 'auto':
                return $this->queryByCategory('Авто');
            case 'property':
                return $this->queryByCategory('Недвижимость');
            case 'services':
                return $this->queryByCategory('Услуги');
            case 'forhome':
                return $this->queryByCategory('Вещи для дома');
            default:
                return [0];
        }
    }

    public function queryForDeleteAds($id) : void {
        \App\DataBase::getConnectToDataBase()->exec(sprintf("DELETE FROM ads WHERE `ads`.`idAds` = '%d'", $id));
    }

    public function queryForEdit($id) : array {
        $result =  \App\DataBase::getConnectToDataBase()->query(sprintf("SELECT * FROM `ads` WHERE `idAds` = '%d'", $id));
        return $result->fetchAll(PDO::FETCH_NUM);
    }

    public function updateEditAds($nameValue, $categoryValue, $priceValue, $descriptionValue, $statusValue, $id) : void {
            \App\DataBase::getConnectToDataBase()->exec(sprintf("UPDATE `ads` SET `name` = '%s', `category` = '%s', `price` = '%d', `description` = '%s', `status` = '%s' WHERE `ads`.`idAds` = '%d'", $nameValue, $categoryValue, $priceValue, $descriptionValue, $statusValue, $id));
    }
}
