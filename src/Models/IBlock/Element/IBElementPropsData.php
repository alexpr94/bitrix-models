<?php

namespace Alexpr94\BitrixModels\Models\IBlock\Element;

use Alexpr94\BitrixModels\Bitrix\Tools;
use Alexpr94\BitrixModels\Models\IBlock\TypeValuesFields\BaseValueField;
use Alexpr94\BitrixModels\Models\IBlock\TypeValuesFields\ValueElementLinkField;
use Alexpr94\BitrixModels\Models\IBlock\TypeValuesFields\ValueField;
use Alexpr94\BitrixModels\Models\IBlock\TypeValuesFields\ValueFileField;
use Alexpr94\BitrixModels\Models\IBlock\TypeValuesFields\ValueListField;
use Alexpr94\BitrixModels\Models\IBlock\TypeValuesFields\ValueSectionLinkField;
use Alexpr94\BitrixModels\Models\QueryParams\BaseIBlockQuery;

abstract class IBElementPropsData
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
                foreach ($props as $codeProp => $propData) {
                    switch ($propData['PROPERTY_TYPE']) {
                        case 'L':
                            $value = new ValueListField();
                            $value->value = null;
                            $value->valueEnumId = $dataDb['PROPERTY_' . $propData['ID']] ?? null;
                            if (is_null($value->valueEnumId)) {
                                $value->valueEnumId = $dataDb['PROPERTY_' . $codeProp . '_VALUE'] ?? null;
                            }
                            $value->valueXmlId = null;
                            $this->{$mapField2Prop[$codeProp] ?? $codeProp} = $value;
                            break;
                        case 'F':
                            $value = new ValueFileField();
                            $this->setPropValue($dataDb, $propData['ID'], $value, $codeProp, $mapField2Prop[$codeProp]);
                            break;
                        case 'E':
                            $value = new ValueElementLinkField();
                            $this->setPropValue($dataDb, $propData['ID'], $value, $codeProp, $mapField2Prop[$codeProp]);
                            break;
                        case 'G':
                            $value = new ValueSectionLinkField();
                            $this->setPropValue($dataDb, $propData['ID'], $value, $codeProp, $mapField2Prop[$codeProp]);
                            break;
                        case 'N':
                        default:
                            $value = new ValueField();
                        $this->setPropValue($dataDb, $propData['ID'], $value, $codeProp, $mapField2Prop[$codeProp]);
                        break;
                    }
                }
                break;
            case BaseIBlockQuery::METHOD_GETTING_GET_NEXT_ELEMENT:
                foreach ($props as $codeProp => $propData) {
                    switch ($dataDb['props'][$codeProp]['PROPERTY_TYPE']) {
                        case 'L':
                            $value = new ValueListField();
                            $value->value = $dataDb['props'][$codeProp]['VALUE'] ?? null;
                            $value->valueEnumId = $dataDb['props'][$codeProp]['VALUE_ENUM_ID'] ?? null;
                            $value->valueXmlId = $dataDb['props'][$codeProp]['VALUE_XML_ID'] ?? null;
                            break;
                        case 'F':
                            $value = new ValueFileField();
                            $value->value = $dataDb['props'][$codeProp]['VALUE'] ?? null;
                            break;
                        case 'E':
                            $value = new ValueElementLinkField();
                            $value->value = $dataDb['props'][$codeProp]['VALUE'] ?? null;
                            break;
                        case 'G':
                            $value = new ValueSectionLinkField();
                            $value->value = $dataDb['props'][$codeProp]['VALUE'] ?? null;
                            break;
                        case 'N':
                        default:
                            $value = new ValueField();
                            $value->value = $dataDb['props'][$codeProp]['VALUE'] ?? null;
                            break;
                    }
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
            static::$props[$idIBlock] = Tools::getPropertiesByIdIBlock($idIBlock);
        }
        return static::$props[$idIBlock];
    }

    /**
     * @param $dataDb
     * @param $propId
     * @param BaseValueField $value
     * @param $codeField
     * @param $nameProp
     * @return void
     */
    protected function setPropValue(&$dataDb, $propId, BaseValueField $value, $codeField, $nameProp): void
    {
        $value->value = $dataDb['PROPERTY_' . $propId] ?? null;
        if (is_null($value->value)) {
            $value->value = $dataDb['PROPERTY_' . $codeField . '_VALUE'] ?? null;
        }
        $this->{$nameProp ?? $codeField} = $value;
    }
}