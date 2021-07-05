<?php

namespace BlogProject\src\constraint;

class Validation
{
    public function validate($data, $name)
    {
        if($name === 'BlogPost') {
            $blogPostValidation = new BlogPostValidation();
            $errors = $blogPostValidation->check($data);
            return $errors;
        }
    }
}