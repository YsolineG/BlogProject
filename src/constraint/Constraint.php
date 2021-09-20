<?php

namespace BlogProject\src\constraint;

class Constraint
{
    public function notBlank($name, $value)
    {
        if(empty($value)) {
            return 'Le champ de saisi est vide';
        }
    }
    public function minLength($name, $value, $minSize)
    {
        if(strlen($value) < $minSize) {
            return 'Le champ doit contenir au moins '.$minSize.' caractères';
        }
    }
    public function maxLength($name, $value, $maxSize)
    {
        if(strlen($value) > $maxSize) {
            return 'Le champ doit contenir au maximum '.$maxSize.' caractères';
        }
    }
}