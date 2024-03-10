<?php

namespace Alexpr94\BitrixModels\Generator\Models\UserModels;

use Alexpr94\BitrixModels\Bitrix\UserTools;
use Alexpr94\BitrixModels\Store\BaseErrorStore;

class UserModelGenerator extends BaseErrorStore
{
    protected string $pathSave;
    protected string $namespace;

    public function __construct(string $pathSave, string $namespace)
    {
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
            if (!$this->generateModel())
                $success = false;
            if (!$this->generateCollection())
                $success = false;
            if (!$this->generatePropData())
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
        $fn = fopen(__DIR__ . '/TemplateModelCollection', "r");
        $code = '';
        while (!feof($fn)) {
            $code .= fgets($fn);
        }
        fclose($fn);
        $code = str_replace("{{namespace}}", $this->namespace, $code);
        $code = str_replace("{{namespaceOverrides}}", $this->getNamespaceOverrides(), $code);
        $code = str_replace("{{nameClass}}", $this->nameClass(), $code);
        $nameFile = $this->getPathOverridesClases() . $this->nameClass() . 'ModelsCollection.php';
        if (!file_exists($nameFile)) {
            file_put_contents($nameFile, $code);
            return true;
        }
        $this->addErrors('Класс ' . $this->getNamespaceOverrides() . '\\' . $this->nameClass() . 'ModelCollection уже существует');
        return false;
    }

    protected function generatePropData(): bool
    {
        $fn = fopen(__DIR__ . '/TemplatePropsData', "r");
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
        $nameFile = $this->getPathOverridesClases() . $this->nameClass() . 'Query.php';
        if (!file_exists($nameFile)) {
            file_put_contents($nameFile, $code);
            return true;
        }
        $this->addErrors('Класс ' . $this->getNamespaceOverrides() . '\\' . $this->nameClass() . 'ElementQuery уже существует');
        return false;
    }

    final protected function nameClass(): string
    {
        return 'User';
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
        $props = UserTools::getUserProperties();
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
        $props = UserTools::getUserProperties();
        $code = [];
        foreach ($props as $propName => $prop) {
            $code[] = '            \'' . $this->toCamelCaseSection($propName) . '\' => \'' . $propName . '\',';
        }
        return implode('
', $code);
    }

    protected function labels(): string
    {
        $props = UserTools::getUserProperties();
        $code = [];
        foreach ($props as $propName => $prop) {
            $code[] = '            \'' . $this->toCamelCaseSection($propName) . '\' => \'' . $prop['EDIT_FORM_LABEL'] . '\',';
        }
        return implode('
', $code);
    }
}