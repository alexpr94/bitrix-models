<?php

namespace Alexpr94\BitrixModels\Models\HL;

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
}