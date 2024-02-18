<?php

namespace Alexpr94\BitrixModels;

class BaseErrorStore
{
    protected array $errors = [];

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getStrErrors(): string
    {
        $errors = $this->getErrors();
        foreach ($errors as $k => $error) {
            if (is_array($error)) {
                $errors[$k] = implode(', ', $error);
            }
        }
        return implode(', ', $errors);
    }

    public function addErrors($errors, ?string $key = null)
    {
        if (is_array($errors)) {
            foreach ($errors as $error) {
                if (is_null($key)) {
                    $this->errors[] = $error;
                } else {
                    $this->errors[$key][] = $error;
                }
            }
        } else {
            if (is_null($key)) {
                $this->errors[] = $errors;
            } else {
                $this->errors[$key] = $errors;
            }
        }
    }
}