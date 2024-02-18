<?php

namespace Alexpr94\BitrixModels\Models\QueryParams;

use Alexpr94\BitrixModels\Models\BaseModel;
use Alexpr94\BitrixModels\Models\User\UserModel;
use Alexpr94\BitrixModels\Models\User\UserModelsCollection;

class UserQuery extends BaseQuery
{
    const METHOD_GETTING_FETCH = 'Fetch';
    const METHOD_GETTING_GET_NEXT = 'GetNext';

    protected string $methodGettingRecordInLoop = 'Fetch';
    protected string $classNameModel;

    protected $select = ['UF_*'];
    protected int $iNumPage = 1;
    protected ?int $nPageSize = 10;

    public function __construct(string $classNameModel)
    {
        $this->classNameModel = $classNameModel;
    }

    protected function getClassModelsCollection(): UserModelsCollection
    {
        return new UserModelsCollection();
    }

    protected function createModel(): UserModel
    {
        return new $this->classNameModel($this->methodGettingRecordInLoop);
    }

    protected function getIBlockResult(array $order, array $filter, array $navParams, array $select): ?\CDBResult
    {
        $params = [
            'SELECT' => $select
        ];
        if (!empty($navParams)) {
            $params['NAV_PARAMS'] = $navParams;
        }
        return \CUser::GetList($order, '', $filter, $params);
    }

    protected function getNavParams(): array
    {
        $navParams = false;
        if (!is_null($this->getNPageSize())) {
            $navParams = [
                'nPageSize' => $this->getNPageSize(),
                'iNumPage' => $this->getINumPage()
            ];
        }
        return $navParams;
    }

    public function all(?string $namePropForKey = 'id'): UserModelsCollection
    {
        $collection = $this->getClassModelsCollection();
        $res = $this->getIBlockResult($this->getOrder(), $this->getFilter(), $this->getNavParams(), $this->getSelect());
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
        }
        $collection->setNamePropForKey($namePropForKey);
        return $collection;
    }

    public function one(): ?UserModel
    {
        $this->setNPageSize(1);
        return $this->all()->first();
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
     * @return static
     */
    public function setMethodGettingRecordInLoop(string $methodGettingRecordInLoop): UserQuery
    {
        $this->methodGettingRecordInLoop = $methodGettingRecordInLoop;
        return $this;
    }

    /**
     * @return int
     */
    public function getINumPage(): int
    {
        return $this->iNumPage;
    }

    /**
     * @param int $iNumPage
     * @return UserQuery
     */
    public function setINumPage(int $iNumPage): UserQuery
    {
        $this->iNumPage = $iNumPage;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNPageSize(): ?int
    {
        return $this->nPageSize;
    }

    /**
     * @param int|null $nPageSize
     * @return UserQuery
     */
    public function setNPageSize(?int $nPageSize): UserQuery
    {
        $this->nPageSize = $nPageSize;
        return $this;
    }
}