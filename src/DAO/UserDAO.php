<?php

namespace BlogProject\src\DAO;

use BlogProject\config\Parameter;

class UserDAO extends Database
{
    public function register(Parameter $post)
    {
        $sql = 'INSERT INTO user (pseudo, password, first_name, last_name, email) 
                VALUES (?, ?, "ysoline", "ysoline", ?)';
        $this->createQuery($sql, [$post->get('pseudo'), password_hash($post->get('password'), PASSWORD_BCRYPT), $post->get('email')]);
    }

    public function login($post)
    {
        $sql = 'SELECT user_id, password FROM user WHERE pseudo = ?';
        $data = $this->createQuery($sql, [$post->get('pseudo')]);
        $result = $data->fetch();
        $isPasswordValid = password_verify($post->get('password'), $result['password']);
        return [
            'result' => $result,
            'isPasswordValid' => $isPasswordValid
        ];
    }

    public function updatePassword($post, $pseudo)
    {
        $sql = 'UPDATE user SET password = ? WHERE pseudo = ?';
        $this->createQuery($sql, [password_hash($post->get('password'), PASSWORD_BCRYPT), $pseudo]);
    }
}