<?php

namespace Alexpr94\BitrixModels\Models\QueryParams;

use Alexpr94\BitrixModels\Models\IBlock\BaseIBlockModel;

class ElementQuery extends BaseIBlockQuery
{
    protected $select = ['ID', 'IBLOCK_ID', 'NAME', '*', 'PROPERTY_*'];
    protected int $offset = 0;
    protected ?int $limit = null;
    protected $group = [];

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
    public function setOffset(int $offset): ElementQuery
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
    public function setLimit(?int $limit): ElementQuery
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
    public function setGroup(array $group): ElementQuery
    {
        $this->group = $group;
        return $this;
    }

    protected function getIBlockResult(array $order, array $filter, array $navParams, array $select): ?\CIBlockResult
    {
        if (empty($navParams))
            $navParams = false;
        $res = \CIBlockElement::GetList($order, $filter, false, $navParams, $select);
        if (is_object($res)) {
            return $res;
        }
        return null;
    }

    protected function getNavParams(): array
    {
        $limit = $this->getLimit();
        $navParams = [];
        if (!is_null($limit)) {
            $navParams = [
                'nTopCount' => $this->getLimit(),
                'nOffset' => $this->getOffset()
            ];
        }
        return $navParams;
    }

    public function one(): ?BaseIBlockModel
    {
        $this->setLimit(1);
        return $this->all()->first();
    }
}