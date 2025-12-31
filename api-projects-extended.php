<?php
// Додаткові ендпоінти для проектів
function getProject($id) {
    try {
        $db = BIMHub\Core\Database::getInstance();
        
        $project = $db->fetchOne("
            SELECT p.*, u.full_name as creator_name 
            FROM projects p 
            LEFT JOIN users u ON p.created_by = u.id 
            WHERE p.id = ?
        ", [$id]);
        
        if (!$project) {
            sendResponse([
                'status' => 'error',
                'message' => 'Project not found'
            ], 404);
        }
        
        sendResponse([
            'status' => 'success',
            'data' => $project
        ]);
        
    } catch (Exception $e) {
        sendResponse([
            'status' => 'error',
            'message' => 'Failed to fetch project',
            'error' => $e->getMessage()
        ], 500);
    }
}

function createProject() {
    // Перевірка авторизації
    if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
        sendResponse([
            'status' => 'error',
            'message' => 'Authorization required'
        ], 401);
    }
    
    $data = getJsonInput();
    
    // Валідація
    $required = ['name', 'description', 'location'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            sendResponse([
                'status' => 'error',
                'message' => "Field '$field' is required"
            ], 400);
        }
    }
    
    try {
        $db = BIMHub\Core\Database::getInstance();
        
        // Генеруємо slug
        $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['name']));
        
        // Створюємо проект
        $projectId = $db->insert('projects', [
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'],
            'location' => $data['location'],
            'status' => $data['status'] ?? 'planning',
            'budget' => $data['budget'] ?? 0,
            'progress_percentage' => $data['progress_percentage'] ?? 0,
            'bim_level' => $data['bim_level'] ?? 'LOD 200',
            'created_by' => 1 // Тимчасово, поки немає авторизації
        ]);
        
        sendResponse([
            'status' => 'success',
            'message' => 'Project created successfully',
            'data' => [
                'project_id' => $projectId,
                'name' => $data['name'],
                'slug' => $slug
            ]
        ], 201);
        
    } catch (Exception $e) {
        sendResponse([
            'status' => 'error',
            'message' => 'Failed to create project',
            'error' => $e->getMessage()
        ], 500);
    }
}

function updateProject($id) {
    // Перевірка авторизації
    if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
        sendResponse([
            'status' => 'error',
            'message' => 'Authorization required'
        ], 401);
    }
    
    $data = getJsonInput();
    
    try {
        $db = BIMHub\Core\Database::getInstance();
        
        // Перевіряємо чи існує проект
        $existing = $db->fetchOne("SELECT id FROM projects WHERE id = ?", [$id]);
        if (!$existing) {
            sendResponse([
                'status' => 'error',
                'message' => 'Project not found'
            ], 404);
        }
        
        // Оновлюємо проект
        $updateData = [];
        $allowedFields = ['name', 'description', 'location', 'status', 'budget', 'progress_percentage', 'bim_level'];
        
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $updateData[$field] = $data[$field];
            }
        }
        
        if (!empty($updateData)) {
            $updateData['updated_at'] = date('Y-m-d H:i:s');
            
            $setClause = implode(' = ?, ', array_keys($updateData)) . ' = ?';
            $values = array_values($updateData);
            $values[] = $id;
            
            $db->query("UPDATE projects SET $setClause WHERE id = ?", $values);
        }
        
        sendResponse([
            'status' => 'success',
            'message' => 'Project updated successfully',
            'data' => [
                'project_id' => $id,
                'updated_fields' => array_keys($updateData)
            ]
        ]);
        
    } catch (Exception $e) {
        sendResponse([
            'status' => 'error',
            'message' => 'Failed to update project',
            'error' => $e->getMessage()
        ], 500);
    }
}

function deleteProject($id) {
    // Перевірка авторизації
    if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
        sendResponse([
            'status' => 'error',
            'message' => 'Authorization required'
        ], 401);
    }
    
    try {
        $db = BIMHub\Core\Database::getInstance();
        
        // Перевіряємо чи існує проект
        $existing = $db->fetchOne("SELECT id FROM projects WHERE id = ?", [$id]);
        if (!$existing) {
            sendResponse([
                'status' => 'error',
                'message' => 'Project not found'
            ], 404);
        }
        
        // Видаляємо проект
        $db->query("DELETE FROM projects WHERE id = ?", [$id]);
        
        sendResponse([
            'status' => 'success',
            'message' => 'Project deleted successfully'
        ]);
        
    } catch (Exception $e) {
        sendResponse([
            'status' => 'error',
            'message' => 'Failed to delete project',
            'error' => $e->getMessage()
        ], 500);
    }
}
?>
