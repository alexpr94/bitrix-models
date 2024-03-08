<?php

namespace Alexpr94\BitrixModels\Models\HL;

use Alexpr94\BitrixModels\Bitrix\HLTools;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Highloadblock\HighloadBlockTable;

abstract class BaseHLModel extends BaseDataManagerModel
{
    abstract public static function getNameHL(): string;

    final static public function getDataManager(): DataManager
    {
        $filter = ['NAME' => static::getNameHL()];
        $hlBlock = HighloadBlockTable::getList(array('filter' => $filter))->fetch();
        /** @var \Bitrix\Main\ORM\Entity $obEntity */
        $obEntity = HighloadBlockTable::compileEntity($hlBlock);
        $entity = $obEntity->getDataClass();
        return new $entity();
    }

    public static function getEnum(string $fieldCode): array
    {
        return HLTools::getHLPropEnum($fieldCode, static::getNameHL());
    }
}