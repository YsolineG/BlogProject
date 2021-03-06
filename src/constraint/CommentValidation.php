<?php

namespace BlogProject\src\constraint;

use BlogProject\config\Parameter;

class CommentValidation extends Validation
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
        if ($name === 'content') {
            $error = $this->checkContent($name, $value);
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

    private function checkContent($name, $value): string
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