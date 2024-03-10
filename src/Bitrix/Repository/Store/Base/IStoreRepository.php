<?php

namespace Alexpr94\BitrixModels\Bitrix\Repository\Store\Base;

use Alexpr94\BitrixModels\Bitrix\Repository\Store\Dto\StoreDto;

interface IStoreRepository
{
    /**
     * @return StoreDto[]
     */
    public function getStores(array $filter = [], array $order = []): array;
}