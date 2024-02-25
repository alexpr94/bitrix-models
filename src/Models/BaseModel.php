<?php

namespace Alexpr94\BitrixModels\Models;

use Alexpr94\BitrixModels\Store\BaseErrorStore;
use Alexpr94\BitrixModels\Models\QueryParams\IQuery;

abstract class BaseModel
{
    protected $id = null;
    protected BaseErrorStore $errorStore;

    public function __construct()
    {
        $this->errorStore = new BaseErrorStore();
    }

    abstract public function save(): bool;

    abstract public static function query(): IQuery;

    abstract public function delete(): bool;

    public function getId()
    {
        return $this->id;
    }

    public function isNew(): bool
    {
        return is_null($this->id);
    }

    abstract protected function validate(): bool;
}