<?php

namespace Alexpr94\BitrixModels\Models\User;

use Alexpr94\BitrixModels\Models\BaseModel;
use Alexpr94\BitrixModels\Models\QueryParams\UserQuery;

abstract class UserModel extends BaseModel
{
    protected array $dataDb = [];
    public UserFieldsData $fields;
    protected UserPropsData $props;
    protected ?string $methodGettingRecordInLoop = 'Fetch';

    public function __construct(string $methodGettingRecordInLoop)
    {
        parent::__construct();
        $this->fields = new UserFieldsData();
        $this->props = $this->propsDataObject();
        $this->methodGettingRecordInLoop = $methodGettingRecordInLoop;
    }

    abstract protected function propsDataObject(): UserPropsData;

    public function save(): bool
    {
        $result = false;
        if ($this->isNew()) {
            //addition
        } else {
            //update
        }
        return $result;
    }

    public static function query(): UserQuery
    {
        return new UserQuery(static::class);
    }

    public function delete(): bool
    {
        if (\CUser::Delete($this->getId())) {
            return true;
        }
        return false;
    }

    public function loadFromDb(array $dataDb): void
    {
        $this->id = $dataDb['ID'];
        $this->dataDb = $dataDb;
        $this->fields->load($dataDb);
        $this->props->load($dataDb, $this->methodGettingRecordInLoop);
    }

    protected function validate(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function getDataDb(): array
    {
        return $this->dataDb;
    }

    public function getEmail(): string
    {
        return $this->fields->email;
    }

    public function getLogin(): string
    {
        return $this->fields->login;
    }

    public function getPersonalPhone(): string
    {
        return $this->fields->personalPhone;
    }

    public function getWorkPhone(): string
    {
        return $this->fields->workPhone;
    }

    public function getFullName(): string
    {
        return implode(' ', [
            $this->fields->lastName,
            $this->fields->name,
            $this->fields->secondName
        ]);
    }

    public function isAuthorized(): bool
    {
        global $USER;
        if (!empty($this->id) && $USER->getId() == $this->id && $USER->isAuthorized()) {
            return true;
        }
        return false;
    }

    public function isGuest(): bool
    {
        return !$this->isAuthorized();
    }

    public function isCurrent(): bool
    {
        return $this->isAuthorized();
    }

    public function logout(): void
    {
        global $USER;
        $USER->logout();
    }

    public function getProps(): UserPropsData
    {
        return $this->props;
    }
}