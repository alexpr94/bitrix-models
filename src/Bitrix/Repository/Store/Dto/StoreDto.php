<?php

namespace Alexpr94\BitrixModels\Bitrix\Repository\Store\Dto;

class StoreDto
{
    public $id;
    public $title;
    public bool $active;
    public $address;
    public $description;
    public $gpsN;
    public $gpsS;
    public $imageId;
    public $locationId;
    public $dateModify;
    public $dateCreate;
    public $userId;
    public $modifiedBy;
    public $phone;
    public $schedule;
    public $xmlId;
    public $sort;
    public $email;
    public ?bool $issuingCenter;
    public ?bool $shippingCenter;
    public $siteId;
    public $code;
    public $isDefault;
}