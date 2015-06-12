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
        $sql = "SELECT * FROM Project WHERE Owner_id = $userId";

        return $this->db->query($sql)->fetchAll();
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
}