<?php

namespace BlogProject\src\constraint;

use BlogProject\config\Parameter;

class ContactFormValidation extends Validation
{
    private $errors = [];
    private $constraint;

    public function __construct()
    {
        $this->constraint = new Constraint();
    }

    public function check(Parameter $post): array
    {
        foreach ($post->all() as $key => $value) {
            $this->checkField($key, $value);
        }
        return $this->errors;
    }

    private function checkField($name, $value): void
    {
        if($name === 'name') {
            $error = $this->checkName($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'firstname') {
            $error = $this->checkFirstName($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'email') {
            $error = $this->checkEmail($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'object') {
            $error = $this->checkObject($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'message') {
            $error = $this->checkMessage($name, $value);
            $this->addError($name, $error);
        }
    }

    private function addError($name, $error): void
    {
        if($error) {
            $this->errors += [
                $name => $error
            ];
        }
    }

    private function checkName($name, $value): string
    {
        if($this->constraint->notBlank($value)) {
            return $this->constraint->notBlank($value);
        }
        if($this->constraint->minLength($value, 2)) {
            return $this->constraint->minLength($value, 2);
        }
        if($this->constraint->maxLength($value, 255)) {
            return $this->constraint->maxLength($value, 255);
        }

        return '';
    }

    private function checkFirstName($name, $value): string
    {
        if($this->constraint->notBlank($value)) {
            return $this->constraint->notBlank($value);
        }
        if($this->constraint->minLength($value, 2)) {
            return $this->constraint->minLength($value, 2);
        }
        if($this->constraint->maxLength($value, 255)) {
            return $this->constraint->maxLength($value, 255);
        }

        return '';
    }

    private function checkEmail($name, $value): string
    {
        if($this->constraint->notBlank($value)) {
            return $this->constraint->notBlank($value);
        }
        if($this->constraint->minLength($value, 2)) {
            return $this->constraint->minLength($value, 2);
        }
        if($this->constraint->maxLength($value, 255)) {
            return $this->constraint->maxLength($value, 255);
        }

        return '';
    }

    private function checkObject($name, $value): string
    {
        if($this->constraint->notBlank($value)) {
            return $this->constraint->notBlank($value);
        }
        if($this->constraint->minLength($value, 2)) {
            return $this->constraint->minLength($value, 2);
        }
        if($this->constraint->maxLength($value, 255)) {
            return $this->constraint->maxLength($value, 255);
        }

        return '';
    }

    private function checkMessage($name, $value): string
    {
        if($this->constraint->notBlank($value)) {
            return $this->constraint->notBlank($value);
        }
        if($this->constraint->minLength($value, 2)) {
            return $this->constraint->minLength($value, 2);
        }

        return '';
    }
}