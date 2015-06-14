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
     * @param int $userId
     *
     * @return array
     */
    public function getUserLangs($userId)
    {
        $sql = "SELECT `ProgrammingLanguages`.* FROM `skills`
                LEFT JOIN `ProgrammingLanguages` ON (`ProgrammingLanguages`.`id` = `skills`.`ProgrammingLanguages_id`)
                WHERE `skills`.`User_id`='" . $userId . "' ORDER BY `name` ASC";
        $statement = $this->db->query($sql);
        $result = $statement->fetchAll();

        $return = [];
        foreach ($result as $row) {
            $return[$row['id']] = $row;
        }

        return $return;
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
    public function create(Array $userInfos)
    {
        $userInfos['password'] = password_hash($userInfos['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO User (email, password, firstName, lastName) VALUES " .
            "(\"{$userInfos['email']}\", \"{$userInfos['password']}\", \"{$userInfos['firstName']}\", \"{$userInfos['lastName']}\");";

        $statement = $this->db->query($sql);

        return $statement->rowCount() === 1;

    }

    /**
     * @param array $input
     *
     * @return bool
     */
    public function update(Array $input)
    {
        $sql = "UPDATE User
                SET firstName = \"{$input['firstName']}\", lastName = \"{$input['lastName']}\",
                description = \"{$input['description']}\", email = \"{$input['email']}\"
                WHERE id = {$input['id']};";

        $statement = $this->db->query($sql);

        $sql = "DELETE FROM skills WHERE User_id = {$input['id']};";

        $this->db->query($sql);

        if (count($input['pl']) > 0) {
            $langString = "({$input['id']}, \"" . implode("\"), ({$input['id']}, \"", $input['pl']) . '")';

            $sql = "INSERT INTO skills (user_id, ProgrammingLanguages_id)
                    VALUES $langString;";

            $this->db->query($sql);
        }

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
        $skills = $this->getUserLangs($id);

        // Matches
        $sql = "SELECT DISTINCT `Project`.`id` AS `id`, `Project`.`name` AS `name` FROM `Project`
                JOIN `requirements` ON (`requirements`.`Project_id` = `Project`.`id`)
                LEFT JOIN `developer` ON (`developer`.`Project_id` = `Project`.`id`)
                WHERE `requirements`.`ProgrammingLanguages_id` IN (
                    SELECT `skills`.`ProgrammingLanguages_id` FROM `User`
                    JOIN `skills` ON (`skills`.`User_id` = `User`.`id`)
                    WHERE `User`.`id` = {$user['id']})
                AND `Project`.`Owner_id` <> {$user['id']}
                AND (`developer`.`User_id` <> {$user['id']} OR `developer`.`User_id` IS NULL)";

        $statement = $this->db->query($sql);
        $matches = $statement->fetchAll();

        // Projects
        $sql = "SELECT * FROM Project
                LEFT JOIN developer on developer.Project_id = Project.id
                WHERE `developer`.`User_id` = {$user['id']} OR `Project`.`Owner_id` = {$user['id']}
                ORDER BY `developer`.statusUser, `developer`.statusProject;";
        $statement = $this->db->query($sql);
        $projects = $statement->fetchAll();

        // Output
        $array = [
            'id' => $user['id'],
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