<?php

namespace Alexpr94\BitrixModels\Bitrix\Repository\Price\Base;

use Alexpr94\BitrixModels\Bitrix\Repository\Price\Dto\PriceGroupDto;

interface IPriceRepository
{
    /**
     * @return PriceGroupDto[]
     */
    public function getPriceGroups(array $filter = [], array $order = []): array;
}