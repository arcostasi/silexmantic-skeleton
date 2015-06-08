<?php

namespace App\Model;

/**
 * Base Model
 *
 * @author Anderson Costa <arcostasi@gmail.com>
 */
class BaseModel {

    protected $db;

    /**
     * Database Connect
     * 
     * @param $db
     */
    function __construct($db)
    {
        $this->db = $db;
    }

}