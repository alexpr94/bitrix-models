<?php

namespace Alexpr94\BitrixModels\Models\QueryParamsBuilder;

use Alexpr94\BitrixModels\Bitrix\PriceManager;
use Alexpr94\BitrixModels\Models\BaseModelsCollection;
use Alexpr94\BitrixModels\Models\IBlock\BaseIBlockModel;
use Alexpr94\BitrixModels\Models\QueryParams\ElementQuery;

class PriceIBlockBuilder
{
    protected ElementQuery $elementQuery;
    protected PriceManager $priceManager;

    public function __construct(ElementQuery $elementQuery)
    {
        $this->elementQuery = $elementQuery;
        $this->priceManager = new PriceManager();
    }

    public function all(): BaseModelsCollection
    {
        return $this->elementQuery->all();
    }

    public function one(): ?BaseIBlockModel
    {
        return $this->elementQuery->one();
    }
}