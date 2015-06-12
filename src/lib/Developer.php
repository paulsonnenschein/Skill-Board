<?php

namespace lib;

use PDO;

class Developer extends dbObject
{

    static protected $table = "developer";
    static protected $primaryKeys = [
        'project' => 'Project_id',
        'user' => 'User_id'
    ];
    static protected $fields = [
        "statusUser" => [
            "db_key" => "statusUser"
        ],
        "statusProject" => [
            "db_key" => "statusProject"
        ],
        "rateing" => [
            "db_key" => "rateing"
        ]
    ];

    function __construct(PDO $db, $projectId = null, $userId = null)
    {
        parent::__construct($db, [
            'Project_id' => $projectId,
            'User_id' => $userId
        ]);
    }

    public function getUser()
    {
        $uid = $this->getId('user');
        if (!$uid)
            return null;

        return (new UserHelpers($this->db))->getUserInfo($uid);
    }

    public function setUser($uid)
    {
        $this->setId('user', $uid);
    }

    public function getProject()
    {
        $pid = $this->getId('project');
        if (!$pid)
            return null;

        return new UserHelpers($this->db, $pid);
    }

    public function setProject($p)
    {
        $this->setId('project', $p->getId());
    }

}