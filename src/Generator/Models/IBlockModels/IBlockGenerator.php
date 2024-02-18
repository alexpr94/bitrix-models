<?php

namespace Alexpr94\BitrixModels\Generator\Models\IBlockModels;

use Alexpr94\BitrixModels\BaseErrorStore;
use Alexpr94\BitrixModels\Bitrix\Tools;

class IBlockGenerator extends BaseErrorStore
{
    protected string $pathSave;
    protected string $codeIblock;
    protected string $namespace;

    public function __construct(string $codeIblock, string $pathSave, string $namespace)
    {
        \CModule::IncludeModule("iblock");
        $this->codeIblock = $codeIblock;
        $this->pathSave = $pathSave . '/' . $this->nameClass() . '/';
        $this->namespace = $namespace . '\\' . $this->nameClass();
        if (!file_exists($this->pathSave)) {
            mkdir($this->pathSave, 0777, true);
        }
        if (!file_exists($this->getPathOverridesClases())) {
            mkdir($this->getPathOverridesClases(), 0777, true);
        }
    }

    protected function getPathOverridesClases(): string
    {
        return $this->pathSave . 'Overrides/';
    }

    protected function getNamespaceOverrides(): string
    {
        return $this->namespace . '\\Overrides';
    }

    public function generate(): bool
    {
        $success = true;
        try {
            $this->init();
            if (!$this->generateModel())
                $success = false;
            if (!$this->generateSectionModel())
                $success = false;
            if (!$this->generateCollection())
                $success = false;
            if (!$this->generateSectionCollection())
                $success = false;
            if (!$this->generatePropData())
                $success = false;
            if (!$this->generateSectionPropData())
                $success = false;
            if (!$this->generateElementQuery())
                $success = false;
            if (!$this->generateSectionQuery())
                $success = false;
        } catch (\Throwable $e) {
            $this->addErrors($e->getMessage());
            $this->addErrors($e->getTrace());
            $success = false;
        }
        return $success;
    }

    protected function generateModel(): bool
    {
        $fn = fopen(__DIR__ . '/TemplateModel', "r");
        $code = '';
        while (!feof($fn)) {
            $code .= fgets($fn);
        }
        fclose($fn);
        $code = str_replace("{{codeIBlock}}", $this->codeIblock, $code);
        $code = str_replace("{{namespace}}", $this->namespace, $code);
        $code = str_replace("{{namespaceOverrides}}", $this->getNamespaceOverrides(), $code);
        $code = str_replace("{{nameClass}}", $this->nameClass(), $code);
        $nameFile = $this->pathSave . $this->nameClass() . 'Model.php';
        if (!file_exists($nameFile)) {
            file_put_contents($nameFile, $code);
            return true;
        }
        $this->addErrors('Класс ' . $this->namespace . '\\' . $this->nameClass() . 'Model уже существует');
        return false;
    }

    protected function generateSectionModel(): bool
    {
        $fn = fopen(__DIR__ . '/TemplateSectionModel', "r");
        $code = '';
        while (!feof($fn)) {
            $code .= fgets($fn);
        }
        fclose($fn);
        $code = str_replace("{{codeIBlock}}", $this->codeIblock, $code);
        $code = str_replace("{{namespace}}", $this->namespace, $code);
        $code = str_replace("{{namespaceOverrides}}", $this->getNamespaceOverrides(), $code);
        $code = str_replace("{{nameClass}}", $this->nameClass(), $code);
        $nameFile = $this->pathSave . $this->nameClass() . 'SectionModel.php';
        if (!file_exists($nameFile)) {
            file_put_contents($nameFile, $code);
            return true;
        }
        $this->addErrors('Класс ' . $this->namespace . '\\' . $this->nameClass() . 'SectionModel уже существует');
        return false;
    }

    protected function generateCollection(): bool
    {
        $fn = fopen(__DIR__ . '/TemplateModelCollection', "r");
        $code = '';
        while (!feof($fn)) {
            $code .= fgets($fn);
        }
        fclose($fn);
        $code = str_replace("{{namespace}}", $this->namespace, $code);
        $code = str_replace("{{namespaceOverrides}}", $this->getNamespaceOverrides(), $code);
        $code = str_replace("{{nameClass}}", $this->nameClass(), $code);
        $nameFile = $this->getPathOverridesClases() . $this->nameClass() . 'ModelCollection.php';
        if (!file_exists($nameFile)) {
            file_put_contents($nameFile, $code);
            return true;
        }
        $this->addErrors('Класс ' . $this->getNamespaceOverrides() . '\\' . $this->nameClass() . 'ModelCollection уже существует');
        return false;
    }

    protected function generateSectionCollection(): bool
    {
        $fn = fopen(__DIR__ . '/TemplateSectionModelCollection', "r");
        $code = '';
        while (!feof($fn)) {
            $code .= fgets($fn);
        }
        fclose($fn);
        $code = str_replace("{{namespace}}", $this->namespace, $code);
        $code = str_replace("{{namespaceOverrides}}", $this->getNamespaceOverrides(), $code);
        $code = str_replace("{{nameClass}}", $this->nameClass(), $code);
        $nameFile = $this->getPathOverridesClases() . $this->nameClass() . 'SectionModelCollection.php';
        if (!file_exists($nameFile)) {
            file_put_contents($nameFile, $code);
            return true;
        }
        $this->addErrors('Класс ' . $this->getNamespaceOverrides() . '\\' . $this->nameClass() . 'SectionModelCollection уже существует');
        return false;
    }

    protected function generatePropData(): bool
    {
        $fn = fopen(__DIR__ . '/TemplatePropData', "r");
        $code = '';
        while (!feof($fn)) {
            $code .= fgets($fn);
        }
        fclose($fn);
        $code = str_replace("{{namespace}}", $this->namespace, $code);
        $code = str_replace("{{namespaceOverrides}}", $this->getNamespaceOverrides(), $code);
        $code = str_replace("{{nameClass}}", $this->nameClass(), $code);
        $code = str_replace("{{props}}", $this->props(), $code);
        $code = str_replace("{{map}}", $this->map(), $code);
        $code = str_replace("{{labels}}", $this->labels(), $code);
        $nameFile = $this->getPathOverridesClases() . $this->nameClass() . 'PropsData.php';
        if (!file_exists($nameFile)) {
            file_put_contents($nameFile, $code);
            return true;
        }
        $this->addErrors('Класс ' . $this->getNamespaceOverrides() . '\\' . $this->nameClass() . 'PropData уже существует');
        return false;
    }

    protected function generateElementQuery(): bool
    {
        $fn = fopen(__DIR__ . '/TemplateElementQuery', "r");
        $code = '';
        while (!feof($fn)) {
            $code .= fgets($fn);
        }
        fclose($fn);
        $code = str_replace("{{namespace}}", $this->namespace, $code);
        $code = str_replace("{{namespaceOverrides}}", $this->getNamespaceOverrides(), $code);
        $code = str_replace("{{nameClass}}", $this->nameClass(), $code);
        $nameFile = $this->getPathOverridesClases() . $this->nameClass() . 'ElementQuery.php';
        if (!file_exists($nameFile)) {
            file_put_contents($nameFile, $code);
            return true;
        }
        $this->addErrors('Класс ' . $this->getNamespaceOverrides() . '\\' . $this->nameClass() . 'ElementQuery уже существует');
        return false;
    }

    protected function generateSectionQuery(): bool
    {
        $fn = fopen(__DIR__ . '/TemplateSectionQuery', "r");
        $code = '';
        while (!feof($fn)) {
            $code .= fgets($fn);
        }
        fclose($fn);
        $code = str_replace("{{namespace}}", $this->namespace, $code);
        $code = str_replace("{{namespaceOverrides}}", $this->getNamespaceOverrides(), $code);
        $code = str_replace("{{nameClass}}", $this->nameClass(), $code);
        $nameFile = $this->getPathOverridesClases() . $this->nameClass() . 'SectionQuery.php';
        if (!file_exists($nameFile)) {
            file_put_contents($nameFile, $code);
            return true;
        }
        $this->addErrors('Класс ' . $this->getNamespaceOverrides() . '\\' . $this->nameClass() . 'SectionQuery уже существует');
        return false;
    }

    protected function generateSectionPropData(): bool
    {
        $fn = fopen(__DIR__ . '/TemplateSectionPropData', "r");
        $code = '';
        while (!feof($fn)) {
            $code .= fgets($fn);
        }
        fclose($fn);
        $code = str_replace("{{namespace}}", $this->namespace, $code);
        $code = str_replace("{{namespaceOverrides}}", $this->getNamespaceOverrides(), $code);
        $code = str_replace("{{nameClass}}", $this->nameClass(), $code);
        $code = str_replace("{{props}}", $this->propsSection(), $code);
        $code = str_replace("{{map}}", $this->mapSection(), $code);
        $code = str_replace("{{labels}}", $this->labelsSection(), $code);
        $nameFile = $this->getPathOverridesClases() . $this->nameClass() . 'SectionPropsData.php';
        if (!file_exists($nameFile)) {
            file_put_contents($nameFile, $code);
            return true;
        }
        $this->addErrors('Класс ' . $this->getNamespaceOverrides() . '\\' . $this->nameClass() . 'SectionPropData уже существует');
        return false;
    }

    protected function nameClass(): string
    {
        return ucwords($this->toCamelCase($this->codeIblock));
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

    protected function toCamelCaseSection($str): string
    {
        $str = preg_replace("/^UF_/", '', $str);
        $result = $this->toCamelCase($str);
        if (is_numeric($result)) {
            $result = 'uf' . $result;
        }
        return $result;
    }

    protected function props(): string
    {
        $props = Tools::getPropertiesByIdIBlock(Tools::getIblockId($this->codeIblock));
        $code = '';
        foreach ($props as $propName => $prop) {
            $code .= '    /** @var BaseValueField ' . $prop['NAME'] . ' [' . $prop['CODE'] . '] */
    public $' . $this->toCamelCase($propName) . ';
';
        }
        return $code;
    }

    protected function propsSection(): string
    {
        $props = Tools::getSectionPropertiesByIdIBlock(Tools::getIblockId($this->codeIblock));
        $code = '';
        foreach ($props as $propName => $prop) {
            $code .= '    /** @var BaseValueField ' . $prop['EDIT_FORM_LABEL'] . ' [' . $prop['FIELD_NAME'] . '] */
    public $' . $this->toCamelCaseSection($propName) . ';
';
        }
        return $code;
    }

    protected function map(): string
    {
        $props = Tools::getPropertiesByIdIBlock(Tools::getIblockId($this->codeIblock));
        $code = [];
        foreach ($props as $propName => $prop) {
            $code[] = '            \'' . $this->toCamelCase($propName) . '\' => \'' . $propName . '\',';
        }
        return implode('
', $code);
    }

    protected function mapSection(): string
    {
        $props = Tools::getSectionPropertiesByIdIBlock(Tools::getIblockId($this->codeIblock));
        $code = [];
        foreach ($props as $propName => $prop) {
            $code[] = '            \'' . $this->toCamelCaseSection($propName) . '\' => \'' . $propName . '\',';
        }
        return implode('
', $code);
    }

    protected function labels(): string
    {
        $props = Tools::getPropertiesByIdIBlock(Tools::getIblockId($this->codeIblock));
        $code = [];
        foreach ($props as $propName => $prop) {
            $code[] = '            \'' . $this->toCamelCase($propName) . '\' => \'' . $prop['NAME'] . '\',';
        }
        return implode('
', $code);
    }

    protected function labelsSection(): string
    {
        $props = Tools::getSectionPropertiesByIdIBlock(Tools::getIblockId($this->codeIblock));
        $code = [];
        foreach ($props as $propName => $prop) {
            $code[] = '            \'' . $this->toCamelCaseSection($propName) . '\' => \'' . $prop['EDIT_FORM_LABEL'] . '\',';
        }
        return implode('
', $code);
    }

    protected function init(): void
    {
        if (is_null(Tools::getIblockId($this->codeIblock)))
            throw new \Exception('IBlock not found by code ' . $this->codeIblock);
    }
}