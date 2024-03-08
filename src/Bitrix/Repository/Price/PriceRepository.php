<?php

namespace Alexpr94\BitrixModels\Bitrix\Repository\Price;

class PriceRepository implements IPriceRepository
{
    /**
     * @return PriceData[]
     */
    public function getPriceTypes(): array
    {
        $result = [];
        $dbRes = \CCatalogGroup::GetList(
            [],
            []
        );
        while ($data = $dbRes->Fetch()) {
            $priceData = new PriceData();
            $priceData->id = $data['ID'];
            $priceData->name = $data['NAME'];
            $priceData->base = $data['BASE'] == 'Y';
            $priceData->sort = $data['SORT'];
            $priceData->canAccess = $data['CAN_ACCESS'] == 'Y';
            $priceData->canBuy = $data['CAN_BUY'] == 'Y';
            $priceData->nameLang = $data['NAME_LANG'];
            $priceData->xmlId = $data['XML_ID'];
            $priceData->createdBy = $data['CREATED_BY'];
            $priceData->modifiedBy = $data['MODIFIED_BY'];
            $priceData->timestampX = $data['TIMESTAMP_X'];
            $priceData->dateCreate = $data['DATE_CREATE'];
            $result[] = $priceData;
        }
        return $result;
    }
}