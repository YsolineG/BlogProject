<?php

namespace BlogProject\src\DAO;

use BlogProject\config\Parameter;
use BlogProject\src\model\User;

class UserDAO extends Database
{
    public function buildObject($row)
    {
        $user = new User();
        $user->setId($row['user_id']);
        $user->setPseudo($row['pseudo']);
        $user->setName($row['name']);
        $user->setEmail($row['email']);
        $user->setFirstName($row['firstname']);
        $user->setRole($row['name']);
        return $user;
    }

    public function getUsers()
    {
        $sql = 'SELECT user.user_id, user.pseudo, user.email, user.firstname, role.name FROM user INNER JOIN role ON user.id_role = role.role_id ORDER BY user.user_id DESC';
        $result = $this->createQuery($sql);
        $users = [];
        foreach ($result as $row){
            $userId = $row['user_id'];
            $users[$userId] = $this->buildObject($row);
        }
        return $users;
    }

    public function register(Parameter $post)
    {
        $sql = 'INSERT INTO user (pseudo, password, firstname, name, email, id_role) 
                VALUES (?, ?, ?, ?, ?, ?)';
        $this->createQuery(
            $sql,
            [
                $post->get('pseudo'),
                password_hash($post->get('password'), PASSWORD_BCRYPT),
                $post->get('firstname'),
                $post->get('name'),
                $post->get('email'),
                2
            ]
        );
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

    public function deleteUser($userId)
    {
        $sql = 'DELETE FROM user WHERE user_id = ?';
        $this->createQuery($sql, [$userId]);
    }
}