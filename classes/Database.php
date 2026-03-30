<?php

/**
 * Class Database
 * 
 * Handles the connection to the SchoolManagement MySQL database.
 * Uses the PDO connection created in config/config.php.
 * All other classes will use this connection to interact with the database.
 */
class Database {

    /** @var PDO $db Holds the PDO database connection instance */
    private PDO $db;

    /**
     * Constructor — receives the PDO connection from config.php
     * and stores it for use by all database methods.
     * 
     * @param PDO $db The PDO connection instance
     */
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Returns the PDO connection instance.
     * Used by all resource classes (User, Course, Assignment, etc.)
     * to access the database.
     * 
     * @return PDO
     */
    public function getConnection(): PDO {
        return $this->db;
    }

}

?>