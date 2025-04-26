<?php
session_start();
require_once 'config.php';

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();  // Make sure to exit after header to stop further script execution
}

// Handle user actions
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'delete':
        deleteUser($_GET['id']);
        break;
    case 'toggle_status':
        toggleUserStatus($_GET['id']);
        break;
}

// Fetch users
$users = fetchUsers();

function fetchUsers() {
    global $conn;
    $query = "SELECT id, username, email, role, is_active, created_at, last_login FROM users";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function deleteUser($userId) {
    global $conn;
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    header('Location: user_management.php');
    exit();  // Exit after redirect
}

function toggleUserStatus($userId) {
    global $conn;
    $query = "UPDATE users SET is_active = !is_active WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    header('Location: user_management.php');
    exit();  // Exit after redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">User Management</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td>
                        <?= $user['is_active'] ? 
                            '<span class="badge bg-success">Active</span>' : 
                            '<span class="badge bg-danger">Inactive</span>' 
                        ?>
                    </td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                    <td><?= $user['last_login'] ? htmlspecialchars($user['last_login']) : 'Never' ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="?action=toggle_status&id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                                <?= $user['is_active'] ? 'Deactivate' : 'Activate' ?>
                            </a>
                            <a href="?action=delete&id=<?= $user['id'] ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this user?')">
                                Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_user.php" class="btn btn-success">Add New User</a>
    </div>
</body>
</html>
