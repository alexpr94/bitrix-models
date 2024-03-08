<?php

namespace Alexpr94\BitrixModels\Bitrix;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\UserFieldTable;

class HLTools
{
    public static function getHLPropEnum(string $fieldCode, string $nameHL): array
    {
        global $USER_FIELD_MANAGER;
        $userField = new \CUserFieldEnum;
        $hlBlockId = static::getHlBlockId($nameHL);
        if (empty($hlBlockId)) {
            throw new RuntimeException('HlBlock with code ' . $nameHL . ' not found.');
        }
        $fieldTemplateId = $USER_FIELD_MANAGER->GetUserFields("HLBLOCK_" . $hlBlockId)[$fieldCode]["ID"];
        $fieldTemplateIdValue = $userField->GetList(array(), array('USER_FIELD_ID' => $fieldTemplateId));
        $fields = [];
        while ($field = $fieldTemplateIdValue->Fetch()) {
            $fields[$field['ID']] = $field['XML_ID'];
        }
        return $fields;
    }

    public static function getHlBlockId(string $hlCode): ?int
    {
        $filter = ['NAME' => $hlCode];
        $hlData = HighloadBlockTable::getList(array('filter' => $filter))->fetch();
        return $hlData['ID'] ?? null;
    }
}