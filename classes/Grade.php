<?php

/**
 * Class Grade
 * 
 * Handles all database operations related to grades.
 * Uses the PDO connection provided by the Database class.
 */
class Grade {

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
     * Returns all grades from the database.
     * Optionally filtered by student_id or lecturer_id.
     * 
     * @param int|null $student_id  Optional student filter
     * @param int|null $lecturer_id Optional lecturer filter
     * @return array List of grades
     */
    public function getAll(?int $student_id, ?int $lecturer_id): array {
        if ($student_id) {
            $stmt = $this->db->prepare(
                "SELECT g.grade_id, g.submission_id, g.lecturer_id, 
                        g.mark, g.feedback, g.graded_at 
                 FROM grades g
                 JOIN submissions s ON g.submission_id = s.submission_id
                 WHERE s.student_id = :student_id"
            );
            $stmt->execute([':student_id' => $student_id]);
        } elseif ($lecturer_id) {
            $stmt = $this->db->prepare(
                "SELECT grade_id, submission_id, lecturer_id, 
                        mark, feedback, graded_at 
                 FROM grades 
                 WHERE lecturer_id = :lecturer_id"
            );
            $stmt->execute([':lecturer_id' => $lecturer_id]);
        } else {
            $stmt = $this->db->prepare(
                "SELECT grade_id, submission_id, lecturer_id, 
                        mark, feedback, graded_at 
                 FROM grades"
            );
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Returns a single grade by its grade_id.
     * 
     * @param int $id The grade_id to look up
     * @return array|null The grade record or null if not found
     */
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare(
            "SELECT grade_id, submission_id, lecturer_id, 
                    mark, feedback, graded_at 
             FROM grades 
             WHERE grade_id = :id"
        );
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Creates a new grade record in the database.
     * 
     * @param array $data Grade data (submission_id, 
     *                    lecturer_id, mark, feedback)
     * @return int The new grade's grade_id
     */
    public function create(array $data): int {
        $stmt = $this->db->prepare(
            "INSERT INTO grades 
                (submission_id, lecturer_id, mark, feedback, graded_at) 
             VALUES 
                (:submission_id, :lecturer_id, :mark, :feedback, NOW())"
        );
        $stmt->execute([
            ':submission_id' => $data['submission_id'],
            ':lecturer_id'   => $data['lecturer_id'],
            ':mark'          => $data['mark'],
            ':feedback'      => $data['feedback'] ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Partially updates an existing grade record by grade_id.
     * Only mark and feedback can be updated.
     * 
     * @param int   $id   The grade_id to update
     * @param array $data Updated fields (mark, feedback)
     * @return bool True if the update was successful
     */
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE grades 
             SET mark     = :mark, 
                 feedback = :feedback 
             WHERE grade_id = :id"
        );
        return $stmt->execute([
            ':mark'     => $data['mark'],
            ':feedback' => $data['feedback'] ?? null,
            ':id'       => $id,
        ]);
    }

    /**
     * Deletes a grade from the database by grade_id.
     * 
     * @param int $id The grade_id to delete
     * @return bool True if the deletion was successful
     */
    public function delete(int $id): bool {
        $stmt = $this->db->prepare(
            "DELETE FROM grades WHERE grade_id = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

}

?>
