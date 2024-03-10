<?php

namespace Alexpr94\BitrixModels\Bitrix\Tools;

use Bitrix\Main\UserFieldTable;

class UserTools
{
    public static function getUserProperties(): array
    {
        $runtime = [];
        $runtime[] = UserFieldTable::getLabelsReference('LABELS', 'ru');
        $dbUserFields = UserFieldTable::getList(array(
            'select' => ['*', 'EDIT_FORM_LABEL' => 'LABELS.EDIT_FORM_LABEL'],
            'filter' => array('ENTITY_ID' => 'USER'),
            'runtime' => $runtime,
        ));
        $result = [];
        while ($ob = $dbUserFields->fetch()) {
            $result[$ob['FIELD_NAME']] = $ob;
        }
        return $result;
    }
}