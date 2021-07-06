<?php

namespace BlogProject\src\DAO;

use BlogProject\config\Parameter;

class UserDAO extends Database
{
    public function register(Parameter $post)
    {
        $sql = 'INSERT INTO user (pseudo, password, first_name, last_name, email) 
                VALUES (?, ?, "ysoline", "ysoline", "ysoline")';
        $this->createQuery($sql, [$post->get('pseudo'), password_hash($post->get('password'), PASSWORD_BCRYPT)]);
    }
}