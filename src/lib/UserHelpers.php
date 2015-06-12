<?php

namespace lib;


use PDO;

class UserHelpers
{

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

    /**
     * @param array $userInfos
     *
     * @return bool
     */
    public function createUser(Array $userInfos)
    {
        $userInfos['password'] = password_hash($userInfos['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO User (email, password, firstName, lastName) VALUES " .
            "(\"{$userInfos['email']}\", \"{$userInfos['password']}\", \"{$userInfos['firstName']}\", \"{$userInfos['lastName']}\");";

        $statement = $this->db->query($sql);

        return $statement->rowCount() === 1;

    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getProfile($id)
    {
        $user = $this->getUserInfo($id);

        // Skills
        $sql = "SELECT `ProgrammingLanguages`.`name` AS `name` FROM `skills`
                LEFT JOIN `ProgrammingLanguages` ON (`ProgrammingLanguages`.`id` = `skills`.`ProgrammingLanguages_id`)
                WHERE `skills`.`User_id`='" . $user['id'] . "' ORDER BY `name` ASC";
        $statement = $this->db->query($sql);
        $skills = $statement->fetchAll();

        // Matches
        $sql = "SELECT DISTINCT `Project`.`id` AS `id`, `Project`.`name` AS `name` FROM `Project`
                JOIN `requirements` ON (`requirements`.`Project_id` = `Project`.`id`)
                LEFT JOIN `developer` ON (`developer`.`Project_id` = `Project`.`id`)
                WHERE `requirements`.`ProgrammingLanguages_id` IN (
                    SELECT `skills`.`ProgrammingLanguages_id` FROM `User`
                    JOIN `skills` ON (`skills`.`User_id` = `User`.`id`)
                    WHERE `User`.`id` = " . $user['id'] . ")
                AND (`developer`.`User_id` != " . $user['id'] . " OR `developer`.`User_id` IS NULL)";

        $statement = $this->db->query($sql);
        $matches = $statement->fetchAll();

        // Projects
        $sql = "SELECT `Project`.`id` AS `id`, `Project`.`name` AS `name` FROM `developer`
                LEFT JOIN `User` ON (`User`.`id` = `developer`.`User_id`)
                LEFT JOIN `Project` ON (`Project`.`id` = `developer`.`Project_id`)
                WHERE `User`.`id` = " . $user['id'];
        $statement = $this->db->query($sql);
        $projects = $statement->fetchAll();

        // Output
        $array = [
            'gravatar' => md5(strtolower(trim($user['email']))),
            'name' => $user['firstName'] . ' ' . $user['lastName'],
            'description' => $user['description'],
            'match' => $matches,
            'project' => $projects,
            'skill' => $skills
        ];

        return $array;
    }
}