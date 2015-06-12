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
}