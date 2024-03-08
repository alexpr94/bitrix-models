<?php

namespace Alexpr94\BitrixModels\Bitrix\Repository\Price;

interface IPriceRepository
{
    /**
     * @return PriceData[]
     */
    public function getPriceTypes(): array;
}