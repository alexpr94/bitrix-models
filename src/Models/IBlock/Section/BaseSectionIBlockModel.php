<?php

namespace Alexpr94\BitrixModels\Models\IBlock\Section;

use Alexpr94\BitrixModels\Models\IBlock\BaseIBlockModel;
use Alexpr94\BitrixModels\Models\QueryParams\SectionQuery;

abstract class BaseSectionIBlockModel extends BaseIBlockModel
{
    public IBSectionFieldsData $fields;
    protected IBSectionPropsData $props;

    public function __construct(string $methodGettingRecordInLoop)
    {
        parent::__construct($methodGettingRecordInLoop);
        $this->fields = new IBSectionFieldsData();
        $this->props = $this->propsDataObject();
    }

    abstract protected function propsDataObject(): IBSectionPropsData;

    public function props(): IBSectionPropsData
    {
        return $this->props;
    }

    public function loadFromDb(array $dataDb): void
    {
        parent::loadFromDb($dataDb);
        $this->fields->load($dataDb);
        $this->props->load($dataDb, $this->getMethodGettingRecordInLoop(), static::getIdIBlock());
    }

    public static function query(): SectionQuery
    {
        return new SectionQuery(static::getIdIBlock(), static::class);
    }

    public function delete(): bool
    {
        if (!$this->isNew()) {
            if (\CIBlockSection::Delete($this->getId())) {
                return true;
            }
        }
        return false;
    }
}