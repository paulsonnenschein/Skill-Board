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

        $sql = "SELECT * FROM User WHERE email = \"$username\" LIMIT 1;";

        $statement = $this->db->query($sql);
        $result = $statement->fetch();

        if ($result !== false && password_verify($password, $result['password'])) {
            $_SESSION['user_id'] = $result['id'];
            return true;
        } else {
            return false;
        }
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
        $sql = "SELECT * FROM User WHERE id = $userId LIMIT 1;";

        $statement = $this->db->query($sql);
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

        $sql = "INSERT INTO User (email, password, firstName, lastName) VALUES " .
               "(\"{$userInfos['email']}\", \"{$userInfos['password']}\", \"{$userInfos['firstName']}\", \"{$userInfos['lastName']}\");";

        $statement = $this->db->query($sql);
        return $statement->rowCount() === 1;

    }

    public function getProfile($id){
        $user = $this->getUserInfo($id);
        $sql = "SELECT `programminglanguages`.`name` AS `name` FROM `skills` LEFT JOIN `programminglanguages` ON (`programminglanguages`.`id` = `skills`.`ProgrammingLanguages_id`) WHERE `skills`.`User_id`='".$user['id']."' ORDER BY `name` ASC";
        $statement = $this->db->query($sql);
        $skill = $statement->fetchAll();

        $array = array(
            'name' => $user['firstName'].' '.$user['lastName'],
            'description' => $user['description'],
            'skill' => $skill
        );

        return $array;
    }
}