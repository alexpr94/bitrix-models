<?php

namespace Alexpr94\BitrixModels\Models\User;

class UserFieldsData
{
    public $id;
    public $timestampX;
    public $login;
    public $password;
    public $checkword;
    public $active;
    public $name;
    public $lastName;
    public $email;
    public $lastLogin;
    public $dateRegister;
    public $lid;
    public $personalProfession;
    public $personalWww;
    public $personalIcq;
    public $personalGender;
    public $personalBirthdate;
    public $personalPhoto;
    public $personalPhone;
    public $personalFax;
    public $personalMobile;
    public $personalPager;
    public $personalStreet;
    public $personalMailbox;
    public $personalCity;
    public $personalState;
    public $personalZip;
    public $personalCountry;
    public $personalNotes;
    public $workCompany;
    public $workDepartment;
    public $workPosition;
    public $workWww;
    public $workPhone;
    public $workFax;
    public $workPager;
    public $workStreet;
    public $workMailbox;
    public $workCity;
    public $workState;
    public $workZip;
    public $workCountry;
    public $workProfile;
    public $workLogo;
    public $workNotes;
    public $adminNotes;
    public $storedHash;
    public $xmlId;
    public $personalBirthday;
    public $externalAuthId;
    public $checkwordTime;
    public $secondName;
    public $confirmCode;
    public $loginAttempts;
    public $lastActivityDate;
    public $autoTimeZone;
    public $timeZone;
    public $timeZoneOffset;
    public $title;
    public $bxUserId;
    public $languageId;
    public $blocked;
    public $passwordExpired;
    public $isOnline;

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
            'id' => 'ID',
            'timestampX' => 'TIMESTAMP_X',
            'login' => 'LOGIN',
            'password' => 'PASSWORD',
            'checkword' => 'CHECKWORD',
            'active' => 'ACTIVE',
            'name' => 'NAME',
            'lastName' => 'LAST_NAME',
            'email' => 'EMAIL',
            'lastLogin' => 'LAST_LOGIN',
            'dateRegister' => 'DATE_REGISTER',
            'lid' => 'LID',
            'personalProfession' => 'PERSONAL_PROFESSION',
            'personalWww' => 'PERSONAL_WWW',
            'personalIcq' => 'PERSONAL_ICQ',
            'personalGender' => 'PERSONAL_GENDER',
            'personalBirthdate' => 'PERSONAL_BIRTHDATE',
            'personalPhoto' => 'PERSONAL_PHOTO',
            'personalPhone' => 'PERSONAL_PHONE',
            'personalFax' => 'PERSONAL_FAX',
            'personalMobile' => 'PERSONAL_MOBILE',
            'personalPager' => 'PERSONAL_PAGER',
            'personalStreet' => 'PERSONAL_STREET',
            'personalMailbox' => 'PERSONAL_MAILBOX',
            'personalCity' => 'PERSONAL_CITY',
            'personalState' => 'PERSONAL_STATE',
            'personalZip' => 'PERSONAL_ZIP',
            'personalCountry' => 'PERSONAL_COUNTRY',
            'personalNotes' => 'PERSONAL_NOTES',
            'workCompany' => 'WORK_COMPANY',
            'workDepartment' => 'WORK_DEPARTMENT',
            'workPosition' => 'WORK_POSITION',
            'workWww' => 'WORK_WWW',
            'workPhone' => 'WORK_PHONE',
            'workFax' => 'WORK_FAX',
            'workPager' => 'WORK_PAGER',
            'workStreet' => 'WORK_STREET',
            'workMailbox' => 'WORK_MAILBOX',
            'workCity' => 'WORK_CITY',
            'workState' => 'WORK_STATE',
            'workZip' => 'WORK_ZIP',
            'workCountry' => 'WORK_COUNTRY',
            'workProfile' => 'WORK_PROFILE',
            'workLogo' => 'WORK_LOGO',
            'workNotes' => 'WORK_NOTES',
            'adminNotes' => 'ADMIN_NOTES',
            'storedHash' => 'STORED_HASH',
            'xmlId' => 'XML_ID',
            'personalBirthday' => 'PERSONAL_BIRTHDAY',
            'externalAuthId' => 'EXTERNAL_AUTH_ID',
            'checkwordTime' => 'CHECKWORD_TIME',
            'secondName' => 'SECOND_NAME',
            'confirmCode' => 'CONFIRM_CODE',
            'loginAttempts' => 'LOGIN_ATTEMPTS',
            'lastActivityDate' => 'LAST_ACTIVITY_DATE',
            'autoTimeZone' => 'AUTO_TIME_ZONE',
            'timeZone' => 'TIME_ZONE',
            'timeZoneOffset' => 'TIME_ZONE_OFFSET',
            'title' => 'TITLE',
            'bxUserId' => 'BX_USER_ID',
            'languageId' => 'LANGUAGE_ID',
            'blocked' => 'BLOCKED',
            'passwordExpired' => 'PASSWORD_EXPIRED',
            'isOnline' => 'IS_ONLINE',
        ];
    }
}