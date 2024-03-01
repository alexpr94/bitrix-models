<?php

namespace Alexpr94\BitrixModels\Models\QueryParams;

use Alexpr94\BitrixModels\Models\IBlock\BaseIBlockModel;

class SectionQuery extends BaseIBlockQuery
{
    protected $select = [
        'ID',
        'CODE',
        'EXTERNAL_ID',
        'XML_ID',
        'IBLOCK_ID',
        'IBLOCK_SECTION_ID',
        'TIMESTAMP_X',
        'SORT',
        'NAME',
        'ACTIVE',
        'GLOBAL_ACTIVE',
        'PICTURE',
        'DESCRIPTION',
        'DESCRIPTION_TYPE',
        'LEFT_MARGIN',
        'RIGHT_MARGIN',
        'DEPTH_LEVEL',
        'SEARCHABLE_CONTENT',
        'SECTION_PAGE_URL',
        'MODIFIED_BY',
        'DATE_CREATE',
        'CREATED_BY',
        'DETAIL_PICTURE',
        'UF_*'
    ];
    protected int $iNumPage = 1;
    protected ?int $nPageSize = null;

    /**
     * @return int
     */
    public function getINumPage(): int
    {
        return $this->iNumPage;
    }

    /**
     * @param int $iNumPage
     * @return static
     */
    public function setINumPage(int $iNumPage): SectionQuery
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
     * @return static
     */
    public function setNPageSize(?int $nPageSize): SectionQuery
    {
        $this->nPageSize = $nPageSize;
        return $this;
    }

    protected function getIBlockResult(array $order, array $filter, array $navParams, array $select): ?\CIBlockResult
    {
        if (empty($navParams))
            $navParams = false;
        $res = \CIBlockSection::GetList($order, $filter, false, $select, $navParams);
        if (is_object($res)) {
            return $res;
        }
        return null;
    }

    protected function getNavParams(): array
    {
        $navParams = [];
        if (!is_null($this->getNPageSize())) {
            $navParams = [
                'nPageSize' => $this->getNPageSize(),
                'iNumPage' => $this->getINumPage()
            ];
        }
        return $navParams;
    }

    protected function handlerGetNextElement($ob)
    {
        return $ob->GetFields();
    }

    public function one(): ?BaseIBlockModel
    {
        $this->setNPageSize(1);
        return $this->all()->first();
    }
}