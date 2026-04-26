<?php

/**
 * Class User
 * * Handles all database operations related to users.
 * Uses the PDO connection provided by the Database class.
 */
class User {

    /** @var PDO $db Holds the PDO database connection instance */
    private PDO $db;

    /**
     * Constructor — receives the PDO connection and stores it.
     * * @param PDO $db The PDO connection instance
     */
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Returns all users from the database.
     * Optionally filtered by role (student, lecturer, admin).
     * * @param string|null $role Optional role filter
     * @return array List of users
     */
    public function getAll(?string $role): array {
        if ($role) {
            $stmt = $this->db->prepare(
                "SELECT user_id, username, name, surname, email, role 
                 FROM users 
                 WHERE role = :role"
            );
            $stmt->execute([':role' => $role]);
        } else {
            $stmt = $this->db->prepare(
                "SELECT user_id, username, name, surname, email, role 
                 FROM users"
            );
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Returns a single user by their user_id.
     * * @param int $id The user_id to look up
     * @return array|null The user record or null if not found
     */
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare(
            "SELECT user_id, username, name, surname, 
                    email, role, date_of_birth, created_at 
             FROM users 
             WHERE user_id = :id"
        );
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Creates a new user in the database with validation.
     * * @param array $data User data (username, password, role, name, surname, email)
     * @return int The new user's user_id
     * @throws Exception If validation fails or user already exists
     */
    public function create(array $data): int {
        // 1. Validate required fields
        if (empty($data['username']) || empty($data['password']) || empty($data['email'])) {
            throw new Exception("Validation Error: username, password, and email are mandatory.");
        }

        // 2. Check for existing username or email to prevent duplicates
        $checkStmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
        $checkStmt->execute([
            ':username' => $data['username'],
            ':email'    => $data['email']
        ]);
        
        if ($checkStmt->fetchColumn() > 0) {
            throw new Exception("Conflict Error: User with this username or email already exists.");
        }

        // 3. Insert new user if validation passes
        $stmt = $this->db->prepare(
            "INSERT INTO users (username, password, role, name, surname, email, created_at) 
             VALUES (:username, :password, :role, :name, :surname, :email, NOW())"
        );
        
        $stmt->execute([
            ':username' => $data['username'],
            ':password' => password_hash($data['password'], PASSWORD_BCRYPT),
            ':role'     => $data['role'],
            ':name'     => $data['name'],
            ':surname'  => $data['surname'],
            ':email'    => $data['email'],
        ]);
        
        return (int) $this->db->lastInsertId();
    }

    /**
     * Authenticate a user by username and password.
     * * @param string $username
     * @param string $password
     * @return array|false Returns user data on success, false on failure
     */
    public function login(string $username, string $password) {
        // 1. Find the user by username
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. If user exists, verify the hashed password
        if ($user && password_verify($password, $user['password'])) {
            // Remove password from the array before returning for security
            unset($user['password']);
            return $user;
        }

        // 3. Return false if authentication fails
        return false;
    }

    /**
     * Updates an existing user record by user_id.
     * * @param int   $id   The user_id to update
     * @param array $data Updated fields (name, surname, email, role)
     * @return bool True if the update was successful
     */
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE users 
             SET name = :name, surname = :surname, 
                 email = :email, role = :role 
             WHERE user_id = :id"
        );
        return $stmt->execute([
            ':name'    => $data['name'],
            ':surname' => $data['surname'],
            ':email'   => $data['email'],
            ':role'    => $data['role'],
            ':id'      => $id,
        ]);
    }

    /**
     * Deletes a user from the database by user_id.
     * * @param int $id The user_id to delete
     * @return bool True if the deletion was successful
     */
    public function delete(int $id): bool {
        $stmt = $this->db->prepare(
            "DELETE FROM users WHERE user_id = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

}

?>