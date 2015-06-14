<?php

namespace lib;


use PDO;

class ProjectHelpers {

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
     * @param int $userId
     *
     * @return array
     */
    public function getAllFromOwner($userId)
    {
        $sql = "SELECT * FROM Project WHERE Owner_id = $userId;";

        return $this->db->query($sql)->fetchAll();
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getLangsById($id)
    {
        $sql = "SELECT lang.* FROM requirements
                JOIN ProgrammingLanguages AS lang on lang.id = requirements.ProgrammingLanguages_id
                WHERE Project_id  = $id;";

        $result = $this->db->query($sql)->fetchAll();

        $return = [];
        foreach ($result as $row) {
            $return[$row['id']] = $row;
        }

        return $return;
    }

    public function getLangsForProjects(Array $idList)
    {
        $idString = implode(', ', $idList);

        $sql = "SELECT Project_id AS id, lang.name FROM requirements
                JOIN ProgrammingLanguages AS lang on lang.id = requirements.ProgrammingLanguages_id
                WHERE Project_id  IN ($idString);";

        $result = $this->db->query($sql)->fetchAll();

        $return = [];
        foreach ($result as $row) {
            $return[$row['id']][] = $row;
        }

        return $return;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getById($id)
    {
        $sql = "SELECT Project.*, CONCAT(User.firstName, \" \", User.lastName) AS 'owner',  User.id AS 'owner_id' FROM Project
                JOIN User on User.id = Project.Owner_id WHERE Project.id = $id Limit 1;";

        return $this->db->query($sql)->fetch();
    }

    /**
     * @return array
     */
    public function getLangs()
    {
        $sql = "SELECT * FROM ProgrammingLanguages;";

        $result = $this->db->query($sql)->fetchAll();

        $return = [];
        foreach ($result as $row) {
            $return[$row['id']] = $row;
        }

        return $return;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    private function getProjectDevs($id)
    {
        $sql = "SELECT User.*, developer.* FROM developer
                JOIN User on User.id = developer.User_id WHERE Project_id = $id
                ORDER BY `developer`.statusUser, `developer`.statusProject;";

        return $this->db->query($sql)->fetchAll();
    }

    /**
     * @param int $projectId
     *
     * @return array
     */
    public function getRecomendetDevsForProject($projectId)
    {
        $sql = "SELECT DISTINCT User.* FROM User
                JOIN skills on skills.User_id = User.id
                LEFT JOIN developer on developer.User_id = User.id
                WHERE skills.ProgrammingLanguages_id IN (
                    SELECT `requirements`.`ProgrammingLanguages_id` FROM `Project`
                    JOIN `requirements` ON (`requirements`.`Project_id` = `Project`.`id`)
                    WHERE `Project`.`id` = $projectId)
                AND (developer.Project_id <> $projectId OR developer.Project_id IS NULL);";

        return $this->db->query($sql)->fetchAll();
    }

    /**
     * @param int $userId
     * @param Array $input
     *
     * @return int
     */
    public function create($userId, Array $input)
    {
        $now = date('Y-m-d');
        $sql = "INSERT INTO Project (name, description, Owner_id, creationDate)
                VALUES (\"{$input['name']}\", \"{$input['description']}\", $userId, \"$now\");";

        $this->db->query($sql);
        $id = $this->db->lastInsertId();

        if (count($input['pl']) > 0) {
            $langString = "($id, \"" . implode("\"), ($id, \"", $input['pl']) . '")';

            $sql = "INSERT INTO requirements (Project_id, ProgrammingLanguages_id)
                    VALUES $langString;";

            $this->db->query($sql);
        }


        return $id;
    }

    /**
     * @param Array $input
     *
     * @return bool
     */
    public function update(Array $input)
    {
        $sql = "UPDATE Project
                SET name = \"{$input['name']}\", description = \"{$input['description']}\"
                WHERE id = {$input['id']};";

        $statement = $this->db->query($sql);

        $sql = "DELETE FROM requirements WHERE Project_id = {$input['id']};";

        $this->db->query($sql);

        if (count($input['pl']) > 0) {
            $langString = "({$input['id']}, \"" . implode("\"), ({$input['id']}, \"", $input['pl']) . '")';

            $sql = "INSERT INTO requirements (Project_id, ProgrammingLanguages_id)
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
    public function getProjectPage($id)
    {
        return [
            'project' => $this->getById($id),
            'languages' => $this->getLangsById($id),
            'developers' => $this->getProjectDevs($id),
            'recomendet_devs' => $this->getRecomendetDevsForProject($id)
        ];
    }
}