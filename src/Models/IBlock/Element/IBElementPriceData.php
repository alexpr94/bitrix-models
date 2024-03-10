<?php

namespace Alexpr94\BitrixModels\Models\IBlock\Element;

class IBElementPriceData
{
    protected ?array $dataDb = null;

    public function __construct()
    {
    }

    public function load($dataDb): void
    {
        $this->dataDb = $dataDb;
    }
}