<?php

namespace Alexpr94\BitrixModels\Bitrix\Repository\Price;

use Alexpr94\BitrixModels\Bitrix\Repository\Price\Base\IPriceRepository;
use Alexpr94\BitrixModels\Bitrix\Repository\Price\Dto\PriceGroupDto;
use Bitrix\Catalog\GroupTable;

class PriceRepository implements IPriceRepository
{
    /**
     * @return PriceGroupDto[]
     */
    public function getPriceGroups(array $filter = [], array $order = []): array
    {
        $result = [];
        $priceGroups = GroupTable::query()
            ->setSelect(['*'])
            ->setFilter($filter)
            ->setOrder($order)
            ->fetchAll();
        foreach ($priceGroups as $priceGroup) {
            $priceData = new PriceGroupDto();
            $priceData->id = $priceGroup['ID'];
            $priceData->name = $priceGroup['NAME'];
            $priceData->base = $priceGroup['BASE'] == 'Y';
            $priceData->sort = $priceGroup['SORT'];
            $priceData->xmlId = $priceGroup['XML_ID'];
            $priceData->createdBy = $priceGroup['CREATED_BY'];
            $priceData->modifiedBy = $priceGroup['MODIFIED_BY'];
            $priceData->timestampX = $priceGroup['TIMESTAMP_X'];
            $priceData->dateCreate = $priceGroup['DATE_CREATE'];
            $result[] = $priceData;
        }
        return $result;
    }
}