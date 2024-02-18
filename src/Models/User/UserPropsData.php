<?php

namespace Alexpr94\BitrixModels\Models\User;

use Alexpr94\BitrixModels\Bitrix\Tools;
use Alexpr94\BitrixModels\Models\IBlock\TypeValuesFields\ValueField;
use Alexpr94\BitrixModels\Models\QueryParams\BaseIBlockQuery;

abstract class UserPropsData
{
    protected static ?array $props = null;

    abstract protected function mapProp2Field(): array;

    public function load($dataDb, string $methodGettingRecordInLoop): void
    {
        $props = $this->getProperties();
        $mapProp2Field = $this->mapProp2Field();
        $mapField2Prop = [];
        foreach ($mapProp2Field as $prop => $field) {
            $mapField2Prop[$field] = $prop;
        }
        switch ($methodGettingRecordInLoop) {
            case BaseIBlockQuery::METHOD_GETTING_FETCH:
            case BaseIBlockQuery::METHOD_GETTING_GET_NEXT:
                foreach ($props as $codeProp => $propData) {
                    $value = new ValueField();
                    $value->value = $dataDb[$codeProp] ?? null;
                    $this->{$mapField2Prop[$codeProp] ?? $codeProp} = $value;
                }
                break;
        }
    }

    public static function labels(): array
    {
        return [];
    }

    public function label(string $propName): string
    {
        return static::labels()[$propName] ?? '';
    }

    protected function getProperties(): array
    {
        if (is_null(static::$props)) {
            static::$props = Tools::getUserProperties();
        }
        return static::$props;
    }
}