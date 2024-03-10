<?php

namespace Alexpr94\BitrixModels\Bitrix\Repository\Store;

use Alexpr94\BitrixModels\Bitrix\Repository\Store\Base\IStoreRepository;
use Alexpr94\BitrixModels\Bitrix\Repository\Store\Dto\StoreDto;
use Bitrix\Catalog\StoreTable;

class StoreRepository implements IStoreRepository
{
    /**
     * @return StoreDto[]
     */
    public function getStores(array $filter = [], array $order = []): array
    {
        $result = [];
        $stores = StoreTable::query()
            ->setSelect(['*'])
            ->setFilter($filter)
            ->setOrder($order)
            ->fetchAll();
        foreach ($stores as $store) {
            $storeDto = new StoreDto();
            $storeDto->id = $store['ID'];
            $storeDto->title = $store['TITLE'];
            $storeDto->active = $store['ACTIVE'] == 'Y';
            $storeDto->address = $store['ADDRESS'];
            $storeDto->description = $store['DESCRIPTION'];
            $storeDto->gpsN = $store['GPS_N'];
            $storeDto->gpsS = $store['GPS_S'];
            $storeDto->imageId = $store['IMAGE_ID'];
            $storeDto->locationId = $store['LOCATION_ID'];
            $storeDto->dateModify = $store['DATE_MODIFY'];
            $storeDto->dateCreate = $store['DATE_CREATE'];
            $storeDto->userId = $store['USER_ID'];
            $storeDto->modifiedBy = $store['MODIFIED_BY'];
            $storeDto->phone = $store['PHONE'];
            $storeDto->schedule = $store['SCHEDULE'];
            $storeDto->xmlId = $store['XML_ID'];
            $storeDto->sort = $store['SORT'];
            $storeDto->email = $store['EMAIL'];
            $storeDto->issuingCenter = $store['ISSUING_CENTER'] == 'Y';
            $storeDto->shippingCenter = $store['SHIPPING_CENTER'] == 'Y';
            $storeDto->siteId = $store['SITE_ID'];
            $storeDto->code = $store['CODE'];
            $storeDto->isDefault = $store['IS_DEFAULT'];
            $result[] = $storeDto;
        }
        return $result;
    }
}