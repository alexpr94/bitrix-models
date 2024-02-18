<?php

namespace Alexpr94\BitrixModels\Models\HL;

use Bitrix\Main\ORM\Data\DataManager;
use Alexpr94\BitrixModels\Models\BaseModel;
use Alexpr94\BitrixModels\Models\QueryParams\DataManagerQuery;

abstract class BaseDataManagerModel extends BaseModel
{
    protected array $errors = [];

    abstract static public function getDataManager(): DataManager;

    abstract static public function getMapFieldsDb2Properties(): array;

    public static function query(): DataManagerQuery
    {
        return new DataManagerQuery(static::class);
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        $map = $this->getMapFieldsDb2Properties();
        $fields = [];
        foreach ($map as $fieldDb => $nameProp) {
            $fields[$fieldDb] = $this->{$nameProp};
        }
        $entity = static::getDataManager();
        if ($this->isNew()) {
            $result = $entity::add($fields);
        } else {
            $result = $entity::update($this->id, $fields);
        }
        if ($result->isSuccess()) {
            $this->id = $result->getId();
            $this->errors = [];
            return true;
        }
        $this->errors = $result->getErrorMessages();
        return false;
    }

    public function delete(): bool
    {
        if (!$this->isNew()) {
            $entity = static::getDataManager();
            $result = $entity::delete($this->getId());
            return $result->isSuccess();
        }
        return false;
    }

    protected function validate(): bool
    {
        $isValid = true;
        $props = static::requiredProps();
        foreach ($props as $prop) {
            if (!$this->validateRequired($prop)) {
                $isValid = false;
            }
        }
        return $isValid;
    }

    public static function requiredProps(): array
    {
        return [];
    }

    protected function validateRequired($nameProp): bool
    {
        if ($this->isEmpty($nameProp)) {
            $this->errors[] = 'Поле ' . $nameProp . ' обязательное';
            return false;
        }
        return true;
    }

    protected function isEmpty($nameProp): bool
    {
        return in_array($this->{$nameProp}, [null, '']);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function loadFromDb(array $item): void
    {
        $map = static::getMapFieldsDb2Properties();
        $this->id = $item['ID'];
        foreach ($map as $fieldDb => $nameProp) {
            $this->{$nameProp} = $item[$fieldDb];
        }
    }
}