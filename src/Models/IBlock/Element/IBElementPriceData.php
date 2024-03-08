<?php

namespace Alexpr94\BitrixModels\Models\IBlock\Element;

use Alexpr94\BitrixModels\Bitrix\PriceManager;

class IBElementPriceData
{
    protected ?array $dataDb = null;
    protected PriceManager $priceManager;

    public function __construct()
    {
        $this->priceManager = new PriceManager();
    }

    public function load($dataDb): void
    {
        $this->dataDb = $dataDb;
    }

    public function getFieldsPriceId(): array
    {
        $result = [];
        $priceTypes = $this->priceManager->getPriceTypes();
        foreach ($priceTypes as $priceType) {
            $key = 'CATALOG_PRICE_ID_' . $priceType->id;
            if (isset($this->dataDb[$key])) {
                $result[$key] = $this->dataDb[$key];
            }
        }
        return $result;
    }

    public function getFieldsPrices(): array
    {
        return array_merge($this->getFieldsPriceId(), $this->getFieldsPriceValues());
    }

    public function getMinPriceValue(bool $ignoreZeroPrice = true): ?float
    {
        $mapPriceName2Id = $this->mapPriceName2Id();
        if (empty($mapPriceName2Id))
            return null;
        $priceValuesByName = $this->getPriceValuesByName();
        if (empty($priceValuesByName))
            return null;

        $minPriceValue = null;
        $k = 0;
        foreach ($priceValuesByName as $value) {
            $value = (float)$value;
            if ($k === 0)
                $minPriceValue = $value;
            if ($ignoreZeroPrice && $value == 0)
                continue;
            if ($value < $minPriceValue) {
                $minPriceValue = $value;
            }
            $k++;
        }
        return $minPriceValue;
    }

    public function getFieldsPriceValues(): array
    {
        $result = [];
        $priceTypes = $this->priceManager->getPriceTypes();
        foreach ($priceTypes as $priceType) {
            $key = 'CATALOG_PRICE_' . $priceType->id;
            if (isset($this->dataDb[$key])) {
                $result[$key] = $this->dataDb[$key];
            }
        }
        return $result;
    }

    public function getPriceValuesByName(): array
    {
        $result = [];
        $priceTypes = $this->priceManager->getPriceTypes();
        foreach ($priceTypes as $priceType) {
            $key = 'CATALOG_PRICE_' . $priceType->id;
            if (isset($this->dataDb[$key])) {
                $result[$priceType->name] = $this->dataDb[$key];
            }
        }
        return $result;
    }
}