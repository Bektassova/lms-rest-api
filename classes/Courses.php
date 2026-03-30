<?php

/**
 * Class Course
 * 
 * Handles all database operations related to courses.
 * Uses the PDO connection provided by the Database class.
 */
class Course {

    /** @var PDO $db Holds the PDO database connection instance */
    private PDO $db;

    /**
     * Constructor — receives the PDO connection and stores it.
     * 
     * @param PDO $db The PDO connection instance
     */
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Returns all courses from the database.
     * 
     * @return array List of all courses
     */
    public function getAll(): array {
        $stmt = $this->db->prepare(
            "SELECT course_id, course_name, course_description, created_at 
             FROM courses"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Returns a single course by its course_id.
     * 
     * @param int $id The course_id to look up
     * @return array|null The course record or null if not found
     */
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare(
            "SELECT course_id, course_name, course_description, created_at 
             FROM courses 
             WHERE course_id = :id"
        );
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Creates a new course in the database.
     * 
     * @param array $data Course data (course_name, course_description)
     * @return int The new course's course_id
     */
    public function create(array $data): int {
        $stmt = $this->db->prepare(
            "INSERT INTO courses (course_name, course_description, created_at) 
             VALUES (:course_name, :course_description, NOW())"
        );
        $stmt->execute([
            ':course_name'        => $data['course_name'],
            ':course_description' => $data['course_description'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Fully updates an existing course record by course_id.
     * 
     * @param int   $id   The course_id to update
     * @param array $data Updated fields (course_name, course_description)
     * @return bool True if the update was successful
     */
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE courses 
             SET course_name = :course_name, 
                 course_description = :course_description 
             WHERE course_id = :id"
        );
        return $stmt->execute([
            ':course_name'        => $data['course_name'],
            ':course_description' => $data['course_description'],
            ':id'                 => $id,
        ]);
    }

    /**
     * Deletes a course from the database by course_id.
     * 
     * @param int $id The course_id to delete
     * @return bool True if the deletion was successful
     */
    public function delete(int $id): bool {
        $stmt = $this->db->prepare(
            "DELETE FROM courses WHERE course_id = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

}

?>