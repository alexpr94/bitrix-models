<?php

namespace Alexpr94\BitrixModels\Models\QueryParams;

use Alexpr94\BitrixModels\Models\BaseModel;
use Alexpr94\BitrixModels\Models\BaseModelsCollection;
use Alexpr94\BitrixModels\Models\IBlock\BaseIBlockModel;

abstract class BaseIBlockQuery extends BaseQuery
{
    const METHOD_GETTING_FETCH = 'Fetch';
    const METHOD_GETTING_GET_NEXT = 'GetNext';
    const METHOD_GETTING_GET_NEXT_ELEMENT = 'GetNextElement';

    protected string $methodGettingRecordInLoop = 'Fetch';

    protected int $idIBlock;
    protected string $classNameModel;

    public function __construct(int $idIBlock, string $classNameModel)
    {
        $this->idIBlock = $idIBlock;
        $this->classNameModel = $classNameModel;
    }

    protected function getClassModelsCollection(): BaseModelsCollection
    {
        return new BaseModelsCollection();
    }

    protected function createModel(): BaseIBlockModel
    {
        return new $this->classNameModel($this->getMethodGettingRecordInLoop());
    }

    abstract protected function getIBlockResult(array $order, array $filter, array $navParams, array $select): ?\CIBlockResult;

    abstract protected function getNavParams(): array;

    public function all(?string $namePropForKey = 'id'): BaseModelsCollection
    {
        $collection = $this->getClassModelsCollection();
        $filter = $this->getFilter();
        $filter["IBLOCK_ID"] = $this->idIBlock;
        $res = $this->getIBlockResult($this->getOrder(), $filter, $this->getNavParams(), $this->getSelect());
        switch ($this->getMethodGettingRecordInLoop()) {
            case static::METHOD_GETTING_FETCH:
                while ($ob = $res->Fetch()) {
                    $model = $this->createModel();
                    $model->loadFromDb($ob);
                    $collection->add($model);
                }
                break;
            case static::METHOD_GETTING_GET_NEXT:
                while ($ob = $res->GetNext()) {
                    $model = $this->createModel();
                    $model->loadFromDb($ob);
                    $collection->add($model);
                }
                break;
            case static::METHOD_GETTING_GET_NEXT_ELEMENT:
                while ($ob = $res->GetNextElement()) {
                    $model = $this->createModel();
                    $model->loadFromDb($this->handlerGetNextElement($ob));
                    $collection->add($model);
                }
                break;
        }
        $collection->setNamePropForKey($namePropForKey);
        return $collection;
    }

    abstract public function one(): ?BaseModel;

    protected function handlerGetNextElement($ob)
    {
        $fields = $ob->GetFields();
        $dataDb = $fields;
        $dataDb['props'] = $ob->GetProperties();
        return $dataDb;
    }

    /**
     * @return string
     */
    public function getMethodGettingRecordInLoop(): string
    {
        return $this->methodGettingRecordInLoop;
    }

    /**
     * @param string $methodGettingRecordInLoop
     * @return BaseIBlockQuery
     */
    public function setMethodGettingRecordInLoop(string $methodGettingRecordInLoop): BaseIBlockQuery
    {
        $this->methodGettingRecordInLoop = $methodGettingRecordInLoop;
        return $this;
    }
}