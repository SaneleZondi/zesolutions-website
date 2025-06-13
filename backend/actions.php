<?php
require 'db.php';
header('Content-Type: application/json');

session_start();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'submit_inspection':
        // Employee submitting inspection
        if (empty($_SESSION['employee_id'])) {
            echo json_encode(['success' => false, 'message' => 'Not authorized']);
            exit;
        }
        
        $inspectionId = $_POST['bookingId'];
        $type = $_POST['inspectionType'];
        $employeeId = $_SESSION['employee_id'];
        
        // Process inspection data
        $data = [
            'type' => $type,
            'employee_id' => $employeeId,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        // Add type-specific data
        if ($type === 'electrical') {
            $data['voltage'] = $_POST['voltage'];
            $data['circuit_status'] = $_POST['circuitStatus'];
        } else {
            $data['water_pressure'] = $_POST['waterPressure'];
            $data['pipe_condition'] = $_POST['pipeCondition'];
        }
        
        // Process file uploads
        $photos = [];
        if (!empty($_FILES['photos'])) {
            $uploadDir = '../uploads/inspections/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmpName) {
                $filename = $inspectionId . '_' . basename($_FILES['photos']['name'][$key]);
                $target = $uploadDir . $filename;
                
                if (move_uploaded_file($tmpName, $target)) {
                    $photos[] = 'uploads/inspections/' . $filename;
                }
            }
        }
        
        $data['photos'] = $photos;
        
        // Save to database
        $stmt = $conn->prepare("
            INSERT INTO inspections 
            (inspection_id, employee_id, inspection_data, created_at) 
            VALUES (?, ?, ?, NOW())
        ");
        $stmt->bind_param("sss", $inspectionId, $employeeId, json_encode($data));
        
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'inspectionId' => $inspectionId,
                'message' => 'Inspection submitted successfully'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Database error: ' . $conn->error
            ]);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}