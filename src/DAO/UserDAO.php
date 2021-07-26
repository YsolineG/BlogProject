<?php

namespace BlogProject\src\DAO;

use BlogProject\config\Parameter;

class UserDAO extends Database
{
    public function register(Parameter $post)
    {
        $sql = 'INSERT INTO user (pseudo, password, first_name, last_name, email, id_role) 
                VALUES (?, ?, "ysoline", "ysoline", ?, ?)';
        $this->createQuery($sql, [$post->get('pseudo'), password_hash($post->get('password'), PASSWORD_BCRYPT), $post->get('email'), 2]);
    }

    public function login($post)
    {
        $sql = 'SELECT user.user_id, user.id_role, user.password, role.name FROM user INNER JOIN role ON role.role_id = user.id_role WHERE pseudo = ?';
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

    public function deleteAccount($pseudo)
    {
        $sql = 'DELETE FROM user WHERE pseudo = ?';
        $this->createQuery($sql, [$pseudo]);
    }
}