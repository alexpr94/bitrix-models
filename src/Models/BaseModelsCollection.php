<?php

namespace Alexpr94\BitrixModels\Models;

class BaseModelsCollection
{
    /**
     * @var BaseModel[]
     */
    protected array $items = [];
    protected ?string $namePropForKey = null;

    public function add(BaseModel $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return BaseModel[]
     */
    public function items(): array
    {
        if (!is_null($this->namePropForKey)) {
            $result = [];
            if ($this->namePropForKey == 'id') {
                foreach ($this->items as $item) {
                    $result[$item->getId()] = $item;
                }
            } else {
                foreach ($this->items as $item) {
                    $result[$item->{$this->namePropForKey}] = $item;
                }
            }
            return $result;
        }
        return $this->items;
    }

    public function first(): ?BaseModel
    {
        $items = $this->items();
        if (!empty($items))
            return $items[array_key_first($items)];
        return null;
    }

    public function last(): ?BaseModel
    {
        $items = $this->items();
        if (!empty($items))
            return $items[array_key_last($items)];
        return null;
    }

    public function getCount(): int
    {
        return count($this->items());
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