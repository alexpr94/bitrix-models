<?php

namespace Alexpr94\BitrixModels\Bitrix;

use Bitrix\Main\UserFieldTable;

class Tools
{
    public static function getIblockId(string $iblockCode): ?int
    {
        $res = \CIBlock::GetList([], ['CODE' => $iblockCode, 'CHECK_PERMISSIONS' => 'N']);
        $item = $res->Fetch();
        if (!$item['ID']) {
            return null;
        }
        return $item['ID'];
    }

    public static function getPropertiesByIdIBlock(int $idIBlock): array
    {
        $props = [];
        $res = \CIBlock::GetProperties($idIBlock, array('ID' => 'ASC'), array());
        while ($data = $res->Fetch()) {
            $props[$data['CODE']] = $data;
        }
        return $props;
    }

    public static function getSectionPropertiesByIdIBlock(int $idIBlock): array
    {
        $runtime = [];
        $runtime[] = UserFieldTable::getLabelsReference('LABELS', 'ru');
        $dbUserFields = UserFieldTable::getList(array(
            'select' => ['*', 'EDIT_FORM_LABEL' => 'LABELS.EDIT_FORM_LABEL'],
            'filter' => array('ENTITY_ID' => 'IBLOCK_' . $idIBlock . '_SECTION'),
            'order' => ['ID' => 'asc'],
            'runtime' => $runtime,
        ));
        $result = [];
        while ($ob = $dbUserFields->fetch()) {
            $result[$ob['FIELD_NAME']] = $ob;
        }
        return $result;
    }

    public static function getUserProperties(): array
    {
        $runtime = [];
        $runtime[] = UserFieldTable::getLabelsReference('LABELS', 'ru');
        $dbUserFields = UserFieldTable::getList(array(
            'select' => ['*', 'EDIT_FORM_LABEL' => 'LABELS.EDIT_FORM_LABEL'],
            'filter' => array('ENTITY_ID' => 'USER'),
            'order' => ['ID' => 'asc'],
            'runtime' => $runtime,
        ));
        $result = [];
        while ($ob = $dbUserFields->fetch()) {
            $result[$ob['FIELD_NAME']] = $ob;
        }
        return $result;
    }
}