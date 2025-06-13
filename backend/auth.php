<?php
require 'db.php';
header('Content-Type: application/json');

session_start();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'employee_login':
        // Employee login logic
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $stmt = $conn->prepare("SELECT id, password FROM employees WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $employee = $result->fetch_assoc();
            if (password_verify($password, $employee['password'])) {
                $_SESSION['employee_id'] = $employee['id'];
                $_SESSION['user_role'] = 'employee';
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Employee not found']);
        }
        break;
        
    case 'client_login':
        // Client login with inspection ID
        $inspectionId = $_POST['inspectionId'];
        
        $stmt = $conn->prepare("SELECT id FROM inspections WHERE inspection_id = ?");
        $stmt->bind_param("s", $inspectionId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $_SESSION['inspection_id'] = $inspectionId;
            $_SESSION['user_role'] = 'client';
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid inspection ID']);
        }
        break;
        
    case 'admin_login':
        // Admin login logic
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['user_role'] = 'admin';
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Admin not found']);
        }
        break;
        
    case 'logout':
        session_destroy();
        echo json_encode(['success' => true]);
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}