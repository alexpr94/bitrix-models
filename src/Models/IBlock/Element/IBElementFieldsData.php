<?php

namespace Alexpr94\BitrixModels\Models\IBlock\Element;

class IBElementFieldsData
{
    public $iblockId;
    public $name;
    public $timestampX;
    public $timestampXUnix;
    public $modifiedBy;
    public $dateCreate;
    public $dateCreateUnix;
    public $createdBy;
    public $iblockSectionId;
    public $active;
    public $activeFrom;
    public $activeTo;
    public $dateActiveFrom;
    public $dateActiveTo;
    public $sort;
    public $previewPicture;
    public $previewText;
    public $previewTextType;
    public $detailPicture;
    public $detailText;
    public $detailTextType;
    public $searchableContent;
    public $wfStatusId;
    public $wfParentElementId;
    public $wfLastHistoryId;
    public $wfNew;
    public $lockStatus;
    public $wfLockedBy;
    public $wfDateLock;
    public $wfComments;
    public $inSections;
    public $showCounter;
    public $showCounterStart;
    public $showCounterStartX;
    public $code;
    public $tags;
    public $xmlId;
    public $externalId;
    public $tmpId;
    public $userName;
    public $lockedUserName;
    public $createdUserName;
    public $langDir;
    public $lid;
    public $iblockTypeId;
    public $iblockCode;
    public $iblockName;
    public $iblockExternalId;
    public $detailPageUrl;
    public $listPageUrl;
    public $canonicalPageUrl;
    public $createdDate;
    public $bpPublished;

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
            'iblockId' => 'IBLOCK_ID',
            'name' => 'NAME',
            'timestampX' => 'TIMESTAMP_X',
            'timestampXUnix' => 'TIMESTAMP_X_UNIX',
            'modifiedBy' => 'MODIFIED_BY',
            'dateCreate' => 'DATE_CREATE',
            'dateCreateUnix' => 'DATE_CREATE_UNIX',
            'createdBy' => 'CREATED_BY',
            'iblockSectionId' => 'IBLOCK_SECTION_ID',
            'active' => 'ACTIVE',
            'activeFrom' => 'ACTIVE_FROM',
            'activeTo' => 'ACTIVE_TO',
            'dateActiveFrom' => 'DATE_ACTIVE_FROM',
            'dateActiveTo' => 'DATE_ACTIVE_TO',
            'sort' => 'SORT',
            'previewPicture' => 'PREVIEW_PICTURE',
            'previewText' => 'PREVIEW_TEXT',
            'previewTextType' => 'PREVIEW_TEXT_TYPE',
            'detailPicture' => 'DETAIL_PICTURE',
            'detailText' => 'DETAIL_TEXT',
            'detailTextType' => 'DETAIL_TEXT_TYPE',
            'searchableContent' => 'SEARCHABLE_CONTENT',
            'wfStatusId' => 'WF_STATUS_ID',
            'wfParentElementId' => 'WF_PARENT_ELEMENT_ID',
            'wfLastHistoryId' => 'WF_LAST_HISTORY_ID',
            'wfNew' => 'WF_NEW',
            'lockStatus' => 'LOCK_STATUS',
            'wfLockedBy' => 'WF_LOCKED_BY',
            'wfDateLock' => 'WF_DATE_LOCK',
            'wfComments' => 'WF_COMMENTS',
            'inSections' => 'IN_SECTIONS',
            'showCounter' => 'SHOW_COUNTER',
            'showCounterStart' => 'SHOW_COUNTER_START',
            'showCounterStartX' => 'SHOW_COUNTER_START_X',
            'code' => 'CODE',
            'tags' => 'TAGS',
            'xmlId' => 'XML_ID',
            'externalId' => 'EXTERNAL_ID',
            'tmpId' => 'TMP_ID',
            'userName' => 'USER_NAME',
            'lockedUserName' => 'LOCKED_USER_NAME',
            'createdUserName' => 'CREATED_USER_NAME',
            'langDir' => 'LANG_DIR',
            'lid' => 'LID',
            'iblockTypeId' => 'IBLOCK_TYPE_ID',
            'iblockCode' => 'IBLOCK_CODE',
            'iblockName' => 'IBLOCK_NAME',
            'iblockExternalId' => 'IBLOCK_EXTERNAL_ID',
            'detailPageUrl' => 'DETAIL_PAGE_URL',
            'listPageUrl' => 'LIST_PAGE_URL',
            'canonicalPageUrl' => 'CANONICAL_PAGE_URL',
            'createdDate' => 'CREATED_DATE',
            'bpPublished' => 'BP_PUBLISHED',
        ];
    }
}