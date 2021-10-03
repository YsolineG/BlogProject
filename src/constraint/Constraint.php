<?php

namespace BlogProject\src\constraint;

class Constraint
{
    public function notBlank($value): string
    {
        if(empty($value)) {
            return 'Le champ de saisi est vide';
        }

        return '';
    }
    public function minLength($value, $minSize): string
    {
        if(strlen($value) < $minSize) {
            return 'Le champ doit contenir au moins '.$minSize.' caractères';
        }

        return '';
    }
    public function maxLength($value, $maxSize): string
    {
        if(strlen($value) > $maxSize) {
            return 'Le champ doit contenir au maximum '.$maxSize.' caractères';
        }

        return '';
    }
}