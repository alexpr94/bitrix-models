<?php

namespace Alexpr94\BitrixModels\Models\QueryParams;

abstract class BaseQuery implements IQuery
{
    protected $select = [];
    protected $filter = [];
    protected $order = [];

    /**
     * @return array
     */
    public function getSelect(): array
    {
        return $this->select;
    }

    /**
     * @param array $select
     * @return static
     */
    public function setSelect(array $select): BaseQuery
    {
        $this->select = $select;
        return $this;
    }

    /**
     * @return array
     */
    public function getFilter(): array
    {
        return $this->filter;
    }

    /**
     * @param array $filter
     * @return static
     */
    public function setFilter(array $filter): BaseQuery
    {
        $this->filter = $filter;
        return $this;
    }

    /**
     * @return array
     */
    public function getOrder(): array
    {
        return $this->order;
    }

    /**
     * @param array $order
     * @return static
     */
    public function setOrder(array $order): BaseQuery
    {
        $this->order = $order;
        return $this;
    }
}