<?php

namespace Alexpr94\BitrixModels\Bitrix;

use Alexpr94\BitrixModels\Bitrix\Repository\Price\PriceData;
use Alexpr94\BitrixModels\Bitrix\Repository\Price\PriceRepository;
use Bitrix\Main\UserFieldTable;

class PriceManager
{
    protected static ?array $priceTypes = null;
    protected PriceRepository $repo;

    public function __construct()
    {
        $this->repo = new PriceRepository();
    }

    /**
     * @return PriceData[]
     */
    public function getPriceTypes(bool $cache = true): array
    {
        if ($cache) {
            if (is_null(static::$priceTypes)) {
                static::$priceTypes = $this->repo->getPriceTypes();
            }
            return static::$priceTypes;
        }
        return $this->repo->getPriceTypes();
    }

    public function mapPriceName2Id(bool $cache = true): array
    {
        $result = [];
        $priceTypes = $this->getPriceTypes($cache);
        foreach ($priceTypes as $priceType) {
            $result[$priceType->name] = $priceType->id;
        }
        return $result;
    }
}