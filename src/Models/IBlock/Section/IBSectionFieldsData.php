<?php

namespace Alexpr94\BitrixModels\Models\IBlock\Section;

class IBSectionFieldsData
{
    public $code;
    public $externalId;
    public $xmlId;
    public $iblockId;
    public $iblockSectionId;
    public $timestampX;
    public $sort;
    public $name;
    public $active;
    public $globalActive;
    public $picture;
    public $description;
    public $descriptionType;
    public $leftMargin;
    public $rightMargin;
    public $depthLevel;
    public $searchableContent;
    public $sectionPageUrl;
    public $modifiedBy;
    public $dateCreate;
    public $createdBy;
    public $detailPicture;

    public function load($dataDb): void
    {
        $map = $this->map();
        foreach ($map as $prop => $field) {
            $this->{$prop} = $dataDb[$field] ?? null;
        }
    }

    protected function map(): array
    {
        return [
            'code' => 'CODE',
            'externalId' => 'EXTERNAL_ID',
            'xmlId' => 'XML_ID',
            'iblockId' => 'IBLOCK_ID',
            'iblockSectionId' => 'IBLOCK_SECTION_ID',
            'timestampX' => 'TIMESTAMP_X',
            'sort' => 'SORT',
            'name' => 'NAME',
            'active' => 'ACTIVE',
            'globalActive' => 'GLOBAL_ACTIVE',
            'picture' => 'PICTURE',
            'description' => 'DESCRIPTION',
            'descriptionType' => 'DESCRIPTION_TYPE',
            'leftMargin' => 'LEFT_MARGIN',
            'rightMargin' => 'RIGHT_MARGIN',
            'depthLevel' => 'DEPTH_LEVEL',
            'searchableContent' => 'SEARCHABLE_CONTENT',
            'sectionPageUrl' => 'SECTION_PAGE_URL',
            'modifiedBy' => 'MODIFIED_BY',
            'dateCreate' => 'DATE_CREATE',
            'createdBy' => 'CREATED_BY',
            'detailPicture' => 'DETAIL_PICTURE',
        ];
    }
}