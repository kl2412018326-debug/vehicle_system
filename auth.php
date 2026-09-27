<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function handleLogin(PDO $pdo, array $data): array {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE LOWER(email) = LOWER(?)");
    $stmt->execute([$data['email']]);
    $user = $stmt->fetch();

    if ($user && password_verify($data['password'], $user['password'])) {
        $_SESSION['user'] = $user;
        return ['success' => true, 'user' => $user];
    }
    
    return ['success' => false, 'message' => 'Invalid email or password'];
}

function handleRegistration(PDO $pdo, array $data): array {
    if ($data['role'] === 'admin') {
        if (!in_array($data['adminKey'], ['UPTM2026', 'ADMIN123'])) {
            return ['success' => false, 'message' => 'Invalid Admin Security Code'];
        }
    }

    $stmt = $pdo->prepare("SELECT id FROM users WHERE LOWER(email) = LOWER(?)");
    $stmt->execute([$data['email']]);
    if ($stmt->fetch()) {
        return ['success' => false, 'message' => 'Email address already registered'];
    }

    $hash = password_hash($data['password'], PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, role, password, branch) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$data['name'], $data['email'], $data['phone'], $data['role'], $hash, $data['branch'] ?? null]);

    $newUser = [
        'id' => $pdo->lastInsertId(),
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'role' => $data['role'],
        'branch' => $data['branch'] ?? null
    ];
    $_SESSION['user'] = $newUser;
    
    return ['success' => true, 'user' => $newUser];
}

function handleLogout(): array {
    session_destroy();
    return ['success' => true];
}
?>