<?php

namespace lib;


use PDO;

class User {

    /** @var PDO */
    protected $db;

    /**
     * @param PDO $db
     */
    function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public function login($username, $password)
    {
        $this->logout();

        $sql = "SELECT * FROM User WHERE email = ? LIMIT 1;";

        $statement = $this->db->prepare($sql);
        $statement->bindValue(1, $username, PDO::PARAM_STR);
        $result = $statement->fetch();

        //@todo Implement real Check
        /**
        if (password_verify($password, $result['password'])) {
            $_SESSION['user_id'] = $result['id'];
            return true;
        } else {
            return false;
        }
        /**/

        $_SESSION['user_id'] = 1;

        return true;
    }

    /**
     * @return array
     */
    public function getLoginUserInfo()
    {
        return $this->getUserInfo($_SESSION['user_id']);
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public function getUserInfo($userId)
    {
        $sql = "SELECT * FROM User WHERE id = ? LIMIT 1;";

        $statement = $this->db->prepare($sql);
        $statement->bindValue(1, $userId, PDO::PARAM_INT);
        return $statement->fetch();
    }

    /**
     *
     */
    public function logout()
    {
        unset($_SESSION['user_id']);
    }

    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0;
    }

    public function createUser(Array $userInfos)
    {

        $userInfos['password'] = password_hash($userInfos['password'], PASSWORD_DEFAULT);

        //@todo actually insert data

        return true;

    }
}