<?php
header('Content-Type: application/json');

// Подключение к базе данных
require_once 'config/db.php';

// Получаем данные из формы
$data = json_decode(file_get_contents('php://input'), true);

// Проверяем обязательные поля
if (empty($data['name']) || empty($data['phone']) || empty($data['message'])) {
    echo json_encode(['success' => false, 'message' => 'Заполните обязательные поля']);
    exit;
}

try {
    // Подготовка SQL запроса
    $stmt = $pdo->prepare("
        INSERT INTO contact_requests (name, phone, email, message, created_at) 
        VALUES (:name, :phone, :email, :message, NOW())
    ");
    
    // Выполнение запроса с параметрами
    $stmt->execute([
        ':name' => htmlspecialchars(trim($data['name'])),
        ':phone' => htmlspecialchars(trim($data['phone'])),
        ':email' => !empty($data['email']) ? htmlspecialchars(trim($data['email'])) : NULL,
        ':message' => htmlspecialchars(trim($data['message']))
    ]);
    
    // Успешный ответ
    echo json_encode([
        'success' => true,
        'message' => 'Ваша заявка успешно отправлена!'
    ]);
    
} catch (PDOException $e) {
    // Ошибка базы данных
    error_log('Database error: ' . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Произошла ошибка при отправке формы. Пожалуйста, попробуйте позже.'
    ]);
}