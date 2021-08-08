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
        } elseif ($name === 'Comment') {
            $commentValidation = new CommentValidation();
            $errors = $commentValidation->check($data);
            return $errors;
        } elseif ($name === 'User') {
            $userValidation = new UserValidation();
            $errors = $userValidation->check($data);
            return $errors;
        }
    }
}