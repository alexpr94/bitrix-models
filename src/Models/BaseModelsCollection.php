<?php

namespace Alexpr94\BitrixModels\Models;

class BaseModelsCollection
{
    /**
     * @var BaseModel[]
     */
    protected array $models = [];
    protected ?string $namePropForKey = null;

    public function add(BaseModel $model)
    {
        $this->models[] = $model;
    }

    public function __construct()
    {
    }

    /**
     * @return BaseModel[]
     */
    public function getModels(): array
    {
        if (!is_null($this->namePropForKey)) {
            $result = [];
            if ($this->namePropForKey == 'id') {
                foreach ($this->models as $model) {
                    $result[$model->getId()] = $model;
                }
            } else {
                foreach ($this->models as $model) {
                    $result[$model->{$this->namePropForKey}] = $model;
                }
            }
            return $result;
        }
        return $this->models;
    }

    public function first(): ?BaseModel
    {
        $models = $this->getModels();
        foreach ($models as $model) {
            return $model;
        }
        return null;
    }

    public function getCount(): int
    {
        return count($this->getModels());
    }

    /**
     * @param string|null $namePropForKey
     * @return static
     */
    public function setNamePropForKey(?string $namePropForKey): BaseModelsCollection
    {
        $this->namePropForKey = $namePropForKey;
        return $this;
    }
}