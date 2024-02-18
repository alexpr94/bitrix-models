<?php

namespace Alexpr94\BitrixModels\Models\QueryParams;

use Alexpr94\BitrixModels\Models\BaseModelsCollection;
use Alexpr94\BitrixModels\Models\HL\BaseDataManagerModel;

class DataManagerQuery extends BaseQuery
{
    protected $select = ['*'];
    protected int $offset = 0;
    protected ?int $limit = null;
    protected $group = [];
    protected string $classNameModel;

    public function __construct(string $classNameModel)
    {
        $this->classNameModel = $classNameModel;
    }

    public function getClassModelsCollection(): BaseModelsCollection
    {
        return new BaseModelsCollection();
    }

    protected function createModel(): BaseDataManagerModel
    {
        return new $this->classNameModel();
    }

    public function all(?string $namePropForKey = 'id'): BaseModelsCollection
    {
        $collection = $this->getClassModelsCollection();
        $entity = $this->classNameModel::getDataManager();
        $data = $entity->getList($this->buildParamsQuery())->fetchAll();
        foreach ($data as $item) {
            $model = $this->createModel();
            $model->loadFromDb($item);
            $collection->add($model);
        }
        $collection->setNamePropForKey($namePropForKey);
        return $collection;
    }

    public function one(): ?BaseDataManagerModel
    {
        $entity = $this->classNameModel::getDataManager();
        $params = $this->buildParamsQuery();
        $params['limit'] = 1;
        $data = $entity::getList($params)->fetch();
        if (isset($data['ID'])) {
            $model = $this->createModel();
            $model->loadFromDb($data);
            return $model;
        }
        return null;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return static
     */
    public function setOffset(int $offset): DataManagerQuery
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param int|null $limit
     * @return static
     */
    public function setLimit(?int $limit): DataManagerQuery
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return array
     */
    public function getGroup(): array
    {
        return $this->group;
    }

    /**
     * @param array $group
     * @return static
     */
    public function setGroup(array $group): DataManagerQuery
    {
        $this->group = $group;
        return $this;
    }

    protected function buildParamsQuery(): array
    {
        $paramsDb = [
            'select' => $this->getSelect(),
            'filter' => $this->getFilter(),
            'offset' => $this->getOffset()
        ];
        if (!empty($this->getOrder())) {
            $paramsDb['order'] = $this->getOrder();
        }
        if (!is_null($this->getLimit())) {
            $paramsDb['limit'] = $this->getLimit();
        }
        if (!is_null($this->getGroup())) {
            $paramsDb['group'] = $this->getGroup();
        }
        return $paramsDb;
    }
}