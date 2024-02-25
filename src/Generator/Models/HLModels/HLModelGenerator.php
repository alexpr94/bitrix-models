<?php

namespace Alexpr94\BitrixModels\Generator\Models\HLModels;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\ScalarField;
use Alexpr94\BitrixModels\Store\BaseErrorStore;

class HLModelGenerator extends BaseErrorStore
{
    protected string $pathSave;
    protected string $nameHL;
    protected string $namespace;
    /** @var \Bitrix\Main\ORM\Fields\Field[]|null */
    protected ?array $fields;

    public function __construct(string $nameHL, string $pathSave, string $namespace)
    {
        \CModule::IncludeModule("highloadblock");
        $this->nameHL = $nameHL;
        if (substr($pathSave, -1) != '/') {
            $pathSave .= '/';
        }
        $this->pathSave = $pathSave . $this->nameClass() . '/';
        $this->namespace = $namespace . '\\' . $this->nameClass();
    }

    public function generate(): bool
    {
        $success = true;
        try {
            $this->init();
            if (!$this->generateModel())
                $success = false;
            if (!$this->generateCollection())
                $success = false;
            if (!$this->generateQuery())
                $success = false;
        } catch (\Throwable $e) {
            $this->addErrors($e->getMessage());
            $this->addErrors($e->getTrace());
            $success = false;
        }
        return $success;
    }

    protected function nameClass(): string
    {
        return ucwords($this->nameHL);
    }

    protected function toCamelCase($str): string
    {
        $result = '';
        $str = str_replace('-', ' ', $str);
        $str = str_replace('_', ' ', $str);
        $wordList = explode(' ', $str);
        foreach ($wordList as $word) {
            $result .= ucwords(strtolower($word));
        }
        return lcfirst($result);
    }

    protected function constFieldsDb(): string
    {
        $code = '';
        foreach ($this->fields as $nameField => $field) {
            if ($field instanceof Reference) {
                $columnName = $nameField;
            } else {
                $columnName = $field->getColumnName();
            }
            if ($columnName == 'ID')
                continue;
            $columnName2 = str_replace('UF_', '', $columnName);
            $code .= '    public const FIELD_' . $columnName2 . ' = \'' . $columnName . '\';
';
        }
        return $code;
    }

    protected function props(): string
    {
        $code = '';
        foreach ($this->fields as $field) {
            if ($field instanceof Reference)
                continue;
            $columnName = $field->getColumnName();
            if ($columnName == 'ID')
                continue;
            $columnName2 = str_replace('UF_', '', $columnName);
            $code .= '    public $' . $this->toCamelCase($columnName2) . ';
';
        }
        return $code;
    }

    protected function map(): string
    {
        $code = [];
        foreach ($this->fields as $field) {
            if ($field instanceof Reference)
                continue;
            $columnName = $field->getColumnName();
            if ($columnName == 'ID')
                continue;
            $columnName2 = str_replace('UF_', '', $columnName);
            $code[] = '            static::FIELD_' . $columnName2 . ' => \'' . $this->toCamelCase($columnName2) . '\',';
        }
        return implode('
', $code);
    }

    protected function generateModel(): bool
    {
        $fn = fopen(__DIR__ . '/TemplateModel', "r");
        $code = '';
        while (!feof($fn)) {
            $code .= fgets($fn);
        }
        fclose($fn);
        $code = str_replace("{{namespace}}", $this->namespace, $code);
        $code = str_replace("{{namespaceOverrides}}", $this->getNamespaceOverrides(), $code);
        $code = str_replace("{{nameClass}}", $this->nameClass(), $code);
        $code = str_replace("{{constFieldsDb}}", $this->constFieldsDb(), $code);
        $code = str_replace("{{props}}", $this->props(), $code);
        $code = str_replace("{{map}}", $this->map(), $code);
        $code = str_replace("{{nameHL}}", $this->nameHL, $code);
        $nameFile = $this->pathSave . $this->nameClass() . 'Model.php';
        if (!file_exists($nameFile)) {
            file_put_contents($nameFile, $code);
            return true;
        }
        $this->addErrors('Класс ' . $this->namespace . '\\' . $this->nameClass() . 'Model уже существует');
        return false;
    }

    protected function generateCollection(): bool
    {
        $fn = fopen(__DIR__ . '/TemplateCollection', "r");
        $code = '';
        while (!feof($fn)) {
            $code .= fgets($fn);
        }
        fclose($fn);
        $code = str_replace("{{namespace}}", $this->namespace, $code);
        $code = str_replace("{{namespaceOverrides}}", $this->getNamespaceOverrides(), $code);
        $code = str_replace("{{nameClass}}", $this->nameClass(), $code);
        $code = str_replace("{{constFieldsDb}}", $this->constFieldsDb(), $code);
        $code = str_replace("{{props}}", $this->props(), $code);
        $code = str_replace("{{map}}", $this->map(), $code);
        $code = str_replace("{{nameHL}}", $this->nameHL, $code);
        $nameFile = $this->getPathOverridesClases() . $this->nameClass() . 'Collection.php';
        if (!file_exists($nameFile)) {
            file_put_contents($nameFile, $code);
            return true;
        }
        $this->addErrors('Класс ' . $this->getNamespaceOverrides() . '\\' . $this->nameClass() . 'Collection уже существует');
        return false;
    }

    protected function generateQuery(): bool
    {
        $fn = fopen(__DIR__ . '/TemplateQuery', "r");
        $code = '';
        while (!feof($fn)) {
            $code .= fgets($fn);
        }
        fclose($fn);
        $code = str_replace("{{namespace}}", $this->namespace, $code);
        $code = str_replace("{{namespaceOverrides}}", $this->getNamespaceOverrides(), $code);
        $code = str_replace("{{nameClass}}", $this->nameClass(), $code);
        $code = str_replace("{{constFieldsDb}}", $this->constFieldsDb(), $code);
        $code = str_replace("{{props}}", $this->props(), $code);
        $code = str_replace("{{map}}", $this->map(), $code);
        $code = str_replace("{{nameHL}}", $this->nameHL, $code);
        $nameFile = $this->getPathOverridesClases() . $this->nameClass() . 'Query.php';
        if (!file_exists($nameFile)) {
            file_put_contents($nameFile, $code);
            return true;
        }
        $this->addErrors('Класс ' . $this->getNamespaceOverrides() . '\\' . $this->nameClass() . 'Query уже существует');
        return false;
    }

    protected function getPathOverridesClases(): string
    {
        return $this->pathSave . 'Overrides/';
    }

    protected function getNamespaceOverrides(): string
    {
        return $this->namespace . '\\Overrides';
    }

    /**
     * @return void
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    protected function init(): void
    {
        if (!file_exists($this->pathSave)) {
            mkdir($this->pathSave, 0777, true);
        }
        if (!file_exists($this->getPathOverridesClases())) {
            mkdir($this->getPathOverridesClases(), 0777, true);
        }
        $filter = ['NAME' => $this->nameHL];
        $hlBlock = HighloadBlockTable::getList(array('filter' => $filter))->fetch();
        if (empty($hlBlock['ID']))
            throw new \Exception('Highload block not found by code ' . $this->nameHL);
        /** @var \Bitrix\Main\ORM\Entity $obEntity */
        $obEntity = HighloadBlockTable::compileEntity($hlBlock);
        /** @var ScalarField[] $fields */
        $this->fields = $obEntity->getFields();
    }
}