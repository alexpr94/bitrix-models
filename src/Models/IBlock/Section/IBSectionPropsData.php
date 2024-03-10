<?php

namespace Alexpr94\BitrixModels\Models\IBlock\Section;

use Alexpr94\BitrixModels\Bitrix\Tools\IBlockTools;
use Alexpr94\BitrixModels\Models\IBlock\TypeValuesFields\ValueField;
use Alexpr94\BitrixModels\Models\QueryParams\BaseIBlockQuery;

abstract class IBSectionPropsData
{
    protected static array $props = [];

    abstract protected function mapProp2Field(): array;

    public function load($dataDb, string $methodGettingRecordInLoop, int $idIBlock): void
    {
        $props = $this->getProperties($idIBlock);
        $mapProp2Field = $this->mapProp2Field();
        $mapField2Prop = [];
        foreach ($mapProp2Field as $prop => $field) {
            $mapField2Prop[$field] = $prop;
        }
        switch ($methodGettingRecordInLoop) {
            case BaseIBlockQuery::METHOD_GETTING_FETCH:
            case BaseIBlockQuery::METHOD_GETTING_GET_NEXT:
            case BaseIBlockQuery::METHOD_GETTING_GET_NEXT_ELEMENT:
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

    protected function getProperties(int $idIBlock): array
    {
        if (!isset(static::$props[$idIBlock])) {
            static::$props[$idIBlock] = IBlockTools::getSectionPropertiesByIdIBlock($idIBlock);
        }
        return static::$props[$idIBlock];
    }
}