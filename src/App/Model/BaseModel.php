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
     * 
     * @param Database Provider
     */
    function __construct($db) 
    {
        $this->db = $db;
    }

}