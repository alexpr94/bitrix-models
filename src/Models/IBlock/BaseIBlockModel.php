<?php

namespace Alexpr94\BitrixModels\Models\IBlock;

use Alexpr94\BitrixModels\Models\BaseModel;

abstract class BaseIBlockModel extends BaseModel
{
    protected ?array $dataDb = null;
    protected ?string $methodGettingRecordInLoop = 'Fetch';

    abstract public static function getIdIBlock(): int;

    public function __construct(string $methodGettingRecordInLoop)
    {
        parent::__construct();
        $this->methodGettingRecordInLoop = $methodGettingRecordInLoop;
    }

    public function save(): bool
    {
        $result = false;
        if ($this->isNew()) {
            //addition
        } else {
            //update
        }
        return $result;
    }

    protected function validate(): bool
    {
        //todo
        return true;
    }

    public function loadFromDb(array $dataDb): void
    {
        $this->id = $dataDb['ID'];
        $this->dataDb = $dataDb;
    }

    public function getMethodGettingRecordInLoop(): string
    {
        return $this->methodGettingRecordInLoop;
    }

    public function getDataDb(): ?array
    {
        return $this->dataDb;
    }

    public function getErrors(): array
    {
        return $this->errorStore->getErrors();
    }
}