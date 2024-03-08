<?php

namespace Alexpr94\BitrixModels\Models\IBlock\Element;

use Alexpr94\BitrixModels\Models\IBlock\BaseIBlockModel;
use Alexpr94\BitrixModels\Models\QueryParams\ElementQuery;

abstract class BaseElementIBlockModel extends BaseIBlockModel
{
    public IBElementFieldsData $fields;
    public IBElementPriceData $price;
    protected IBElementPropsData $props;

    public function __construct(string $methodGettingRecordInLoop)
    {
        parent::__construct($methodGettingRecordInLoop);
        $this->fields = new IBElementFieldsData();
        $this->props = $this->propsDataObject();
        $this->price = new IBElementPriceData();
    }

    abstract protected function propsDataObject(): IBElementPropsData;

    public function loadFromDb(array $dataDb): void
    {
        parent::loadFromDb($dataDb);
        $this->fields->load($dataDb);
        $this->props->load($dataDb, $this->getMethodGettingRecordInLoop(), static::getIdIBlock());
        $this->price->load($dataDb);
    }

    public static function query(): ElementQuery
    {
        return new ElementQuery(static::getIdIBlock(), static::class);
    }

    public function props(): IBElementPropsData
    {
        return $this->props;
    }
 
    public function delete(): bool
    {
        if (!$this->isNew()) {
            if (\CIBlockElement::Delete($this->getId())) {
                return true;
            }
        }
        return false;
    }
}