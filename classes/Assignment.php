<?php

/**
 * Class Assignment
 * 
 * Handles all database operations related to assignments.
 * Uses the PDO connection provided by the Database class.
 */
class Assignment {

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
     * Returns all assignments from the database.
     * Optionally filtered by unit_id.
     * 
     * @param int|null $unit_id Optional unit filter
     * @return array List of assignments
     */
    public function getAll(?int $unit_id): array {
        if ($unit_id) {
            $stmt = $this->db->prepare(
                "SELECT assignment_id, unit_id, lecturer_id, title, 
                        description, file_path, due_date, created_at 
                 FROM assignments 
                 WHERE unit_id = :unit_id"
            );
            $stmt->execute([':unit_id' => $unit_id]);
        } else {
            $stmt = $this->db->prepare(
                "SELECT assignment_id, unit_id, lecturer_id, title, 
                        description, file_path, due_date, created_at 
                 FROM assignments"
            );
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Returns a single assignment by its assignment_id.
     * 
     * @param int $id The assignment_id to look up
     * @return array|null The assignment record or null if not found
     */
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare(
            "SELECT assignment_id, unit_id, lecturer_id, title, 
                    description, file_path, due_date, created_at 
             FROM assignments 
             WHERE assignment_id = :id"
        );
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Creates a new assignment in the database.
     * 
     * @param array $data Assignment data (unit_id, lecturer_id, 
     *                    title, description, file_path, due_date)
     * @return int The new assignment's assignment_id
     */
    public function create(array $data): int {
        $stmt = $this->db->prepare(
            "INSERT INTO assignments 
                (unit_id, lecturer_id, title, description, 
                 file_path, due_date, created_at) 
             VALUES 
                (:unit_id, :lecturer_id, :title, :description, 
                 :file_path, :due_date, NOW())"
        );
        $stmt->execute([
            ':unit_id'     => $data['unit_id'],
            ':lecturer_id' => $data['lecturer_id'],
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':file_path'   => $data['file_path'] ?? null,
            ':due_date'    => $data['due_date'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Fully updates an existing assignment by assignment_id.
     * 
     * @param int   $id   The assignment_id to update
     * @param array $data Updated fields (title, description, 
     *                    file_path, due_date)
     * @return bool True if the update was successful
     */
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE assignments 
             SET title       = :title, 
                 description = :description, 
                 file_path   = :file_path, 
                 due_date    = :due_date 
             WHERE assignment_id = :id"
        );
        return $stmt->execute([
            ':title'       => $data['title'],
            ':description' => $data['description'],
            ':file_path'   => $data['file_path'] ?? null,
            ':due_date'    => $data['due_date'],
            ':id'          => $id,
        ]);
    }

    /**
     * Deletes an assignment from the database by assignment_id.
     * 
     * @param int $id The assignment_id to delete
     * @return bool True if the deletion was successful
     */
    public function delete(int $id): bool {
        $stmt = $this->db->prepare(
            "DELETE FROM assignments WHERE assignment_id = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

}

?>