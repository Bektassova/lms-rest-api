<?php

/**
 * Class Submission
 * 
 * Handles all database operations related to submissions.
 * Uses the PDO connection provided by the Database class.
 */
class Submission {

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
     * Returns all submissions from the database.
     * Optionally filtered by student_id or assignment_id.
     * 
     * @param int|null $student_id    Optional student filter
     * @param int|null $assignment_id Optional assignment filter
     * @return array List of submissions
     */
    public function getAll(?int $student_id, ?int $assignment_id): array {
        if ($student_id && $assignment_id) {
            $stmt = $this->db->prepare(
                "SELECT submission_id, assignment_id, student_id, 
                        submission_date 
                 FROM submissions 
                 WHERE student_id = :student_id 
                 AND assignment_id = :assignment_id"
            );
            $stmt->execute([
                ':student_id'    => $student_id,
                ':assignment_id' => $assignment_id,
            ]);
        } elseif ($student_id) {
            $stmt = $this->db->prepare(
                "SELECT submission_id, assignment_id, student_id, 
                        submission_date 
                 FROM submissions 
                 WHERE student_id = :student_id"
            );
            $stmt->execute([':student_id' => $student_id]);
        } elseif ($assignment_id) {
            $stmt = $this->db->prepare(
                "SELECT submission_id, assignment_id, student_id, 
                        submission_date 
                 FROM submissions 
                 WHERE assignment_id = :assignment_id"
            );
            $stmt->execute([':assignment_id' => $assignment_id]);
        } else {
            $stmt = $this->db->prepare(
                "SELECT submission_id, assignment_id, student_id, 
                        submission_date 
                 FROM submissions"
            );
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Returns a single submission by its submission_id.
     * 
     * @param int $id The submission_id to look up
     * @return array|null The submission record or null if not found
     */
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare(
            "SELECT submission_id, assignment_id, student_id, 
                    submission_date 
             FROM submissions 
             WHERE submission_id = :id"
        );
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Creates a new submission in the database.
     * 
     * @param array $data Submission data (assignment_id, student_id)
     * @return int The new submission's submission_id
     */
    public function create(array $data): int {
        $stmt = $this->db->prepare(
            "INSERT INTO submissions 
                (assignment_id, student_id, submission_date) 
             VALUES 
                (:assignment_id, :student_id, NOW())"
        );
        $stmt->execute([
            ':assignment_id' => $data['assignment_id'],
            ':student_id'    => $data['student_id'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Deletes a submission from the database by submission_id.
     * 
     * @param int $id The submission_id to delete
     * @return bool True if the deletion was successful
     */
    public function delete(int $id): bool {
        $stmt = $this->db->prepare(
            "DELETE FROM submissions WHERE submission_id = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

}

?>