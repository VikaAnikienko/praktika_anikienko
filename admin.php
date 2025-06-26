<?php
session_start();

// Проверка авторизации администратора
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Подключение к базе данных
require_once 'config/db.php';

// Обработка добавления нового товара
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $description = trim($_POST['description']);
    $short_description = trim($_POST['short_description']);
    $price = floatval($_POST['price']);
    $old_price = floatval($_POST['old_price']);
    $sku = trim($_POST['sku']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_new = isset($_POST['is_new']) ? 1 : 0;
    $is_bestseller = isset($_POST['is_bestseller']) ? 1 : 0;
    $is_customizable = isset($_POST['is_customizable']) ? 1 : 0;
    $in_stock = isset($_POST['in_stock']) ? 1 : 0;
    $dimensions = trim($_POST['dimensions']);
    $weight = floatval($_POST['weight']);
    $material = trim($_POST['material']);
    $color = trim($_POST['color']);
    $warranty_period = trim($_POST['warranty_period']);
    $meta_title = trim($_POST['meta_title']);
    $meta_description = trim($_POST['meta_description']);
    $collection_id = intval($_POST['collection_id']);
    $category_id = intval($_POST['category_id']);

    // Загрузка изображения
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/products/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid('product_') . '.' . $file_ext;
        $file_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
            $image_path = $file_path;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO products (
        name, slug, description, short_description, price, old_price, sku, stock_quantity, 
        is_featured, is_new, is_bestseller, is_customizable, in_stock, dimensions, weight, 
        material, color, warranty_period, meta_title, meta_description, collection_id, category_id, image_path
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )");
    
    $stmt->execute([
        $name, $slug, $description, $short_description, $price, $old_price, $sku, $stock_quantity,
        $is_featured, $is_new, $is_bestseller, $is_customizable, $in_stock, $dimensions, $weight,
        $material, $color, $warranty_period, $meta_title, $meta_description, $collection_id, $category_id, $image_path
    ]);
    
    header('Location: admin.php');
    exit;
}

// Обработка удаления товара
if (isset($_GET['delete'])) {
    $product_id = intval($_GET['delete']);
    
    // Получаем путь к изображению для удаления
    $stmt = $pdo->prepare("SELECT image_path FROM products WHERE product_id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    
    if ($product && !empty($product['image_path']) && file_exists($product['image_path'])) {
        unlink($product['image_path']);
    }
    
    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->execute([$product_id]);
    
    header('Location: admin.php');
    exit;
}

// Обработка обновления товара
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $product_id = intval($_POST['product_id']);
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $description = trim($_POST['description']);
    $short_description = trim($_POST['short_description']);
    $price = floatval($_POST['price']);
    $old_price = floatval($_POST['old_price']);
    $sku = trim($_POST['sku']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_new = isset($_POST['is_new']) ? 1 : 0;
    $is_bestseller = isset($_POST['is_bestseller']) ? 1 : 0;
    $is_customizable = isset($_POST['is_customizable']) ? 1 : 0;
    $in_stock = isset($_POST['in_stock']) ? 1 : 0;
    $dimensions = trim($_POST['dimensions']);
    $weight = floatval($_POST['weight']);
    $material = trim($_POST['material']);
    $color = trim($_POST['color']);
    $warranty_period = trim($_POST['warranty_period']);
    $meta_title = trim($_POST['meta_title']);
    $meta_description = trim($_POST['meta_description']);
    $collection_id = intval($_POST['collection_id']);
    $category_id = intval($_POST['category_id']);

    // Обновление изображения, если загружено новое
    $image_path = $_POST['existing_image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Удаляем старое изображение
        if (!empty($image_path) && file_exists($image_path)) {
            unlink($image_path);
        }
        
        // Загружаем новое
        $upload_dir = 'uploads/products/';
        $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid('product_') . '.' . $file_ext;
        $file_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
            $image_path = $file_path;
        }
    }

    $stmt = $pdo->prepare("UPDATE products SET 
        name = ?, slug = ?, description = ?, short_description = ?, price = ?, old_price = ?, 
        sku = ?, stock_quantity = ?, is_featured = ?, is_new = ?, is_bestseller = ?, 
        is_customizable = ?, in_stock = ?, dimensions = ?, weight = ?, material = ?, 
        color = ?, warranty_period = ?, meta_title = ?, meta_description = ?, 
        collection_id = ?, category_id = ?, image_path = ?, updated_at = NOW()
        WHERE product_id = ?");
    
    $stmt->execute([
        $name, $slug, $description, $short_description, $price, $old_price,
        $sku, $stock_quantity, $is_featured, $is_new, $is_bestseller,
        $is_customizable, $in_stock, $dimensions, $weight, $material,
        $color, $warranty_period, $meta_title, $meta_description,
        $collection_id, $category_id, $image_path, $product_id
    ]);
    
    header('Location: admin.php');
    exit;
}

// Получение списка всех товаров
$stmt = $pdo->query("SELECT * FROM products ORDER BY product_id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Получение списка категорий и коллекций (предполагается, что эти таблицы существуют)
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$collections = $pdo->query("SELECT * FROM collections")->fetchAll(PDO::FETCH_ASSOC);
// Обработка добавления новой коллекции
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_collection'])) {
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $description = trim($_POST['description']);
    $short_description = trim($_POST['short_description']);
    $meta_title = trim($_POST['meta_title']);
    $meta_description = trim($_POST['meta_description']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Загрузка изображения
    $main_image_url = '';
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/collections/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid('collection_') . '.' . $file_ext;
        $file_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['main_image']['tmp_name'], $file_path)) {
            $main_image_url = $file_path;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO collections (
        name, slug, description, short_description, main_image_url, 
        meta_title, meta_description, is_featured, is_active
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->execute([
        $name, $slug, $description, $short_description, $main_image_url,
        $meta_title, $meta_description, $is_featured, $is_active
    ]);
    
    header('Location: admin.php?tab=collections');
    exit;
}

// Обработка обновления коллекции
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_collection'])) {
    $collection_id = intval($_POST['collection_id']);
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $description = trim($_POST['description']);
    $short_description = trim($_POST['short_description']);
    $meta_title = trim($_POST['meta_title']);
    $meta_description = trim($_POST['meta_description']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Обновление изображения
    $main_image_url = $_POST['existing_image'];
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
        // Удаляем старое изображение
        if (!empty($main_image_url) && file_exists($main_image_url)) {
            unlink($main_image_url);
        }
        
        // Загружаем новое
        $upload_dir = 'uploads/collections/';
        $file_ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid('collection_') . '.' . $file_ext;
        $file_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['main_image']['tmp_name'], $file_path)) {
            $main_image_url = $file_path;
        }
    }

    $stmt = $pdo->prepare("UPDATE collections SET 
        name = ?, slug = ?, description = ?, short_description = ?, main_image_url = ?,
        meta_title = ?, meta_description = ?, is_featured = ?, is_active = ?, updated_at = NOW()
        WHERE collection_id = ?");
    
    $stmt->execute([
        $name, $slug, $description, $short_description, $main_image_url,
        $meta_title, $meta_description, $is_featured, $is_active, $collection_id
    ]);
    
    header('Location: admin.php?tab=collections');
    exit;
}

// Обработка удаления коллекции
if (isset($_GET['delete_collection'])) {
    $collection_id = intval($_GET['delete_collection']);
    
    // Получаем путь к изображению для удаления
    $stmt = $pdo->prepare("SELECT main_image_url FROM collections WHERE collection_id = ?");
    $stmt->execute([$collection_id]);
    $collection = $stmt->fetch();
    
    if ($collection && !empty($collection['main_image_url']) && file_exists($collection['main_image_url'])) {
        unlink($collection['main_image_url']);
    }
    
    $stmt = $pdo->prepare("DELETE FROM collections WHERE collection_id = ?");
    $stmt->execute([$collection_id]);
    
    header('Location: admin.php?tab=collections');
    exit;
}

// Обработка изменения статуса заказа
if (isset($_POST['update_order_status'])) {
    $order_id = intval($_POST['order_id']);
    $status = trim($_POST['status']);
    $notes = trim($_POST['notes']);

    // Обновляем статус заказа
    $stmt = $pdo->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE order_id = ?");
    $stmt->execute([$status, $order_id]);

    // Добавляем запись в историю статусов
    $stmt = $pdo->prepare("INSERT INTO order_status_history (order_id, status, notes) VALUES (?, ?, ?)");
    $stmt->execute([$order_id, $status, $notes]);

    header('Location: admin.php?tab=orders');
    exit;
}

// Получение списка всех товаров
$products = $pdo->query("SELECT * FROM products ORDER BY product_id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Получение списка категорий и коллекций
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$collections = $pdo->query("SELECT * FROM collections ORDER BY collection_id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Получение списка заказов с информацией о клиенте
$orders = $pdo->query("
    SELECT o.*, COUNT(oi.item_id) as items_count 
    FROM orders o
    LEFT JOIN order_items oi ON o.order_id = oi.order_id
    GROUP BY o.order_id
    ORDER BY o.created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);

// Получение истории статусов для заказов
$order_status_history = [];
foreach ($orders as $order) {
    $stmt = $pdo->prepare("SELECT * FROM order_status_history WHERE order_id = ? ORDER BY created_at DESC");
    $stmt->execute([$order['order_id']]);
    $order_status_history[$order['order_id']] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Получение текущей вкладки
$current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'products';
// Получение данных
$products = $pdo->query("SELECT * FROM products ORDER BY product_id DESC")->fetchAll();
$collections = $pdo->query("SELECT * FROM collections ORDER BY collection_id DESC")->fetchAll();
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$requests = $pdo->query("SELECT * FROM contact_requests ORDER BY created_at DESC")->fetchAll();

$current_tab = $_GET['tab'] ?? 'products';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Административная панель</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .product-image, .collection-image {
            max-width: 100px;
            max-height: 100px;
        }
        .form-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .order-status {
            font-weight: bold;
        }
        .status-new { color: #0d6efd; }
        .status-processing { color: #fd7e14; }
        .status-shipped { color: #20c997; }
        .status-delivered { color: #198754; }
        .status-cancelled { color: #dc3545; }
        .status-refunded { color: #6c757d; }
        .form-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .form-section h5 {
            color: #6c757d;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
        <div class="row">
            <!-- Боковая панель -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white <?= $current_tab === 'products' ? 'active' : '' ?>" href="admin.php?tab=products">
                                <i class="bi bi-box-seam"></i> Товары
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white <?= $current_tab === 'collections' ? 'active' : '' ?>" href="admin.php?tab=collections">
                                <i class="bi bi-collection"></i> Коллекции
                            </a>
                        </li>
                        <li class="nav-item">
    <a class="nav-link text-white <?= $current_tab === 'requests' ? 'active' : '' ?>" href="admin.php?tab=requests">
        <i class="bi bi-envelope"></i> Заявки
    </a>
</li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i> Выйти
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Основное содержимое -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <?php 
                            switch($current_tab) {
                                case 'products': echo 'Управление товарами'; break;
                                case 'collections': echo 'Управление коллекциями'; break;
                                case 'orders': echo 'Управление заказами'; break;
                                default: echo 'Административная панель';
                            }
                        ?>
                    </h1>
                </div>

                <!-- Вкладки -->
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link <?= $current_tab === 'products' ? 'active' : '' ?>" href="admin.php?tab=products">Товары</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_tab === 'collections' ? 'active' : '' ?>" href="admin.php?tab=collections">Коллекции</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_tab === 'orders' ? 'active' : '' ?>" href="admin.php?tab=requests">Заявки</a>
                    </li>
                </ul>

                <!-- Содержимое вкладок -->
                <div class="tab-content">
                    <!-- Вкладка товаров -->
                    <div class="tab-pane fade <?= $current_tab === 'products' ? 'show active' : '' ?>" id="products-tab">
                        <!-- Форма добавления товара -->
                        <div class="form-container mb-4">
                            <h4>Добавить новый товар</h4>
                            <form method="POST" enctype="multipart/form-data">
                <!-- Форма добавления товара -->
                <div class="form-container mb-4">
                    <h4>Добавить новый товар</h4>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-section">
                            <h5>Основная информация</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Название товара</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="slug" class="form-label">URL-адрес (slug)</label>
                                    <input type="text" class="form-control" id="slug" name="slug" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="collection_id" class="form-label">Коллекция</label>
                                    <select class="form-select" id="collection_id" name="collection_id" required>
                                        <option value="">Выберите коллекцию</option>
                                        <?php foreach ($collections as $collection): ?>
                                            <option value="<?= $collection['collection_id'] ?>"><?= htmlspecialchars($collection['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="category_id" class="form-label">Категория</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">Выберите категорию</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="description" class="form-label">Описание</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="short_description" class="form-label">Краткое описание</label>
                                    <textarea class="form-control" id="short_description" name="short_description" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h5>Цены и наличие</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="price" class="form-label">Цена</label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="old_price" class="form-label">Старая цена</label>
                                    <input type="number" step="0.01" class="form-control" id="old_price" name="old_price">
                                </div>
                                <div class="col-md-4">
                                    <label for="sku" class="form-label">Артикул (SKU)</label>
                                    <input type="text" class="form-control" id="sku" name="sku" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="stock_quantity" class="form-label">Количество на складе</label>
                                    <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mt-4 pt-2">
                                        <input class="form-check-input" type="checkbox" id="in_stock" name="in_stock" value="1" checked>
                                        <label class="form-check-label" for="in_stock">Есть в наличии</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h5>Характеристики</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="dimensions" class="form-label">Габариты</label>
                                    <input type="text" class="form-control" id="dimensions" name="dimensions" placeholder="ДxШxВ">
                                </div>
                                <div class="col-md-4">
                                    <label for="weight" class="form-label">Вес (кг)</label>
                                    <input type="number" step="0.01" class="form-control" id="weight" name="weight">
                                </div>
                                <div class="col-md-4">
                                    <label for="material" class="form-label">Материал</label>
                                    <input type="text" class="form-control" id="material" name="material">
                                </div>
                                <div class="col-md-4">
                                    <label for="color" class="form-label">Цвет</label>
                                    <input type="text" class="form-control" id="color" name="color">
                                </div>
                                <div class="col-md-4">
                                    <label for="warranty_period" class="form-label">Гарантия</label>
                                    <input type="text" class="form-control" id="warranty_period" name="warranty_period" placeholder="Например, 12 месяцев">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h5>Метки и SEO</h5>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1">
                                        <label class="form-check-label" for="is_featured">Рекомендуемый</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_new" name="is_new" value="1">
                                        <label class="form-check-label" for="is_new">Новинка</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_bestseller" name="is_bestseller" value="1">
                                        <label class="form-check-label" for="is_bestseller">Хит продаж</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_customizable" name="is_customizable" value="1">
                                        <label class="form-check-label" for="is_customizable">Индивидуальный</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="meta_title" class="form-label">Мета-заголовок</label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title">
                                </div>
                                <div class="col-12">
                                    <label for="meta_description" class="form-label">Мета-описание</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h5>Изображение товара</h5>
                            <div class="mb-3">
                                <label for="image" class="form-label">Изображение товара</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" name="add_product" class="btn btn-primary">Добавить товар</button>
                        </div>
                    </form>
                </div>

                <!-- Список товаров -->
                <h4>Список товаров</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Изображение</th>
                                <th>Название</th>
                                <th>Цена</th>
                                <th>Категория</th>
                                <th>На складе</th>
                                <th>Метки</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['product_id']) ?></td>
                                <td>
                                    <?php if (!empty($product['image_path'])): ?>
                                        <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="Изображение товара" class="product-image">
                                    <?php else: ?>
                                        Нет изображения
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= htmlspecialchars($product['price']) ?> руб.</td>
                                <td>
                                    <?php 
                                        $category_name = '';
                                        foreach ($categories as $cat) {
                                            if ($cat['category_id'] == $product['category_id']) {
                                                $category_name = $cat['name'];
                                                break;
                                            }
                                        }
                                        echo htmlspecialchars($category_name);
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($product['stock_quantity']) ?></td>
                                <td>
                                    <?php 
                                        $badges = [];
                                        if ($product['is_featured']) $badges[] = '<span class="badge bg-primary">Рекомендуемый</span>';
                                        if ($product['is_new']) $badges[] = '<span class="badge bg-success">Новинка</span>';
                                        if ($product['is_bestseller']) $badges[] = '<span class="badge bg-warning text-dark">Хит</span>';
                                        if ($product['is_customizable']) $badges[] = '<span class="badge bg-info">Индивидуальный</span>';
                                        echo implode(' ', $badges);
                                    ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $product['product_id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <a href="admin.php?delete=<?= $product['product_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этот товар?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Модальное окно редактирования -->
                            <div class="modal fade" id="editModal<?= $product['product_id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $product['product_id'] ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?= $product['product_id'] ?>">Редактирование товара</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                                <input type="hidden" name="existing_image" value="<?= $product['image_path'] ?>">
                                                
                                                <div class="form-section">
                                                    <h5>Основная информация</h5>
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label for="name<?= $product['product_id'] ?>" class="form-label">Название товара</label>
                                                            <input type="text" class="form-control" id="name<?= $product['product_id'] ?>" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="slug<?= $product['product_id'] ?>" class="form-label">URL-адрес (slug)</label>
                                                            <input type="text" class="form-control" id="slug<?= $product['product_id'] ?>" name="slug" value="<?= htmlspecialchars($product['slug']) ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="collection_id<?= $product['product_id'] ?>" class="form-label">Коллекция</label>
                                                            <select class="form-select" id="collection_id<?= $product['product_id'] ?>" name="collection_id" required>
                                                                <option value="">Выберите коллекцию</option>
                                                                <?php foreach ($collections as $collection): ?>
                                                                    <option value="<?= $collection['collection_id'] ?>" <?= $collection['collection_id'] == $product['collection_id'] ? 'selected' : '' ?>>
                                                                        <?= htmlspecialchars($collection['name']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="category_id<?= $product['product_id'] ?>" class="form-label">Категория</label>
                                                            <select class="form-select" id="category_id<?= $product['product_id'] ?>" name="category_id" required>
                                                                <option value="">Выберите категорию</option>
                                                                <?php foreach ($categories as $category): ?>
                                                                    <option value="<?= $category['category_id'] ?>" <?= $category['category_id'] == $product['category_id'] ? 'selected' : '' ?>>
                                                                        <?= htmlspecialchars($category['name']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="description<?= $product['product_id'] ?>" class="form-label">Описание</label>
                                                            <textarea class="form-control" id="description<?= $product['product_id'] ?>" name="description" rows="3" required><?= htmlspecialchars($product['description']) ?></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="short_description<?= $product['product_id'] ?>" class="form-label">Краткое описание</label>
                                                            <textarea class="form-control" id="short_description<?= $product['product_id'] ?>" name="short_description" rows="2"><?= htmlspecialchars($product['short_description']) ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-section">
                                                    <h5>Цены и наличие</h5>
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label for="price<?= $product['product_id'] ?>" class="form-label">Цена</label>
                                                            <input type="number" step="0.01" class="form-control" id="price<?= $product['product_id'] ?>" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="old_price<?= $product['product_id'] ?>" class="form-label">Старая цена</label>
                                                            <input type="number" step="0.01" class="form-control" id="old_price<?= $product['product_id'] ?>" name="old_price" value="<?= htmlspecialchars($product['old_price']) ?>">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="sku<?= $product['product_id'] ?>" class="form-label">Артикул (SKU)</label>
                                                            <input type="text" class="form-control" id="sku<?= $product['product_id'] ?>" name="sku" value="<?= htmlspecialchars($product['sku']) ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="stock_quantity<?= $product['product_id'] ?>" class="form-label">Количество на складе</label>
                                                            <input type="number" class="form-control" id="stock_quantity<?= $product['product_id'] ?>" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']) ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check mt-4 pt-2">
                                                                <input class="form-check-input" type="checkbox" id="in_stock<?= $product['product_id'] ?>" name="in_stock" value="1" <?= $product['in_stock'] ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="in_stock<?= $product['product_id'] ?>">Есть в наличии</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-section">
                                                    <h5>Характеристики</h5>
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <label for="dimensions<?= $product['product_id'] ?>" class="form-label">Габариты</label>
                                                            <input type="text" class="form-control" id="dimensions<?= $product['product_id'] ?>" name="dimensions" value="<?= htmlspecialchars($product['dimensions']) ?>" placeholder="ДxШxВ">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="weight<?= $product['product_id'] ?>" class="form-label">Вес (кг)</label>
                                                            <input type="number" step="0.01" class="form-control" id="weight<?= $product['product_id'] ?>" name="weight" value="<?= htmlspecialchars($product['weight']) ?>">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="material<?= $product['product_id'] ?>" class="form-label">Материал</label>
                                                            <input type="text" class="form-control" id="material<?= $product['product_id'] ?>" name="material" value="<?= htmlspecialchars($product['material']) ?>">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="color<?= $product['product_id'] ?>" class="form-label">Цвет</label>
                                                            <input type="text" class="form-control" id="color<?= $product['product_id'] ?>" name="color" value="<?= htmlspecialchars($product['color']) ?>">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="warranty_period<?= $product['product_id'] ?>" class="form-label">Гарантия</label>
                                                            <input type="text" class="form-control" id="warranty_period<?= $product['product_id'] ?>" name="warranty_period" value="<?= htmlspecialchars($product['warranty_period']) ?>" placeholder="Например, 12 месяцев">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-section">
                                                    <h5>Метки и SEO</h5>
                                                    <div class="row g-3">
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="is_featured<?= $product['product_id'] ?>" name="is_featured" value="1" <?= $product['is_featured'] ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="is_featured<?= $product['product_id'] ?>">Рекомендуемый</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="is_new<?= $product['product_id'] ?>" name="is_new" value="1" <?= $product['is_new'] ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="is_new<?= $product['product_id'] ?>">Новинка</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="is_bestseller<?= $product['product_id'] ?>" name="is_bestseller" value="1" <?= $product['is_bestseller'] ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="is_bestseller<?= $product['product_id'] ?>">Хит продаж</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="is_customizable<?= $product['product_id'] ?>" name="is_customizable" value="1" <?= $product['is_customizable'] ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="is_customizable<?= $product['product_id'] ?>">Индивидуальный</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="meta_title<?= $product['product_id'] ?>" class="form-label">Мета-заголовок</label>
                                                            <input type="text" class="form-control" id="meta_title<?= $product['product_id'] ?>" name="meta_title" value="<?= htmlspecialchars($product['meta_title']) ?>">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="meta_description<?= $product['product_id'] ?>" class="form-label">Мета-описание</label>
                                                            <textarea class="form-control" id="meta_description<?= $product['product_id'] ?>" name="meta_description" rows="2"><?= htmlspecialchars($product['meta_description']) ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-section">
                                                    <h5>Изображение товара</h5>
                                                    <div class="mb-3">
                                                        <label for="image<?= $product['product_id'] ?>" class="form-label">Новое изображение товара</label>
                                                        <input type="file" class="form-control" id="image<?= $product['product_id'] ?>" name="image" accept="image/*">
                                                        <?php if (!empty($product['image_path'])): ?>
                                                            <small class="text-muted">Текущее изображение: <?= basename($product['image_path']) ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                                <button type="submit" name="update_product" class="btn btn-primary">Сохранить изменения</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                </table>
                        </div>
                    </div>

                    <!-- Вкладка коллекций -->
                    <div class="tab-pane fade <?= $current_tab === 'collections' ? 'show active' : '' ?>" id="collections-tab">
                        <!-- Форма добавления коллекции -->
                        <div class="form-container mb-4">
                            <h4>Добавить новую коллекцию</h4>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-section">
                                    <h5>Основная информация</h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="collection_name" class="form-label">Название коллекции</label>
                                            <input type="text" class="form-control" id="collection_name" name="name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="collection_slug" class="form-label">URL-адрес (slug)</label>
                                            <input type="text" class="form-control" id="collection_slug" name="slug" required>
                                        </div>
                                        <div class="col-12">
                                            <label for="collection_description" class="form-label">Описание</label>
                                            <textarea class="form-control" id="collection_description" name="description" rows="3"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label for="collection_short_description" class="form-label">Краткое описание</label>
                                            <textarea class="form-control" id="collection_short_description" name="short_description" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h5>Изображение и метки</h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="collection_main_image" class="form-label">Основное изображение</label>
                                            <input type="file" class="form-control" id="collection_main_image" name="main_image" accept="image/*">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check mt-4 pt-2">
                                                <input class="form-check-input" type="checkbox" id="collection_is_featured" name="is_featured" value="1">
                                                <label class="form-check-label" for="collection_is_featured">Рекомендуемая</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check mt-4 pt-2">
                                                <input class="form-check-input" type="checkbox" id="collection_is_active" name="is_active" value="1" checked>
                                                <label class="form-check-label" for="collection_is_active">Активная</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h5>SEO</h5>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="collection_meta_title" class="form-label">Мета-заголовок</label>
                                            <input type="text" class="form-control" id="collection_meta_title" name="meta_title">
                                        </div>
                                        <div class="col-12">
                                            <label for="collection_meta_description" class="form-label">Мета-описание</label>
                                            <textarea class="form-control" id="collection_meta_description" name="meta_description" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" name="add_collection" class="btn btn-primary">Добавить коллекцию</button>
                                </div>
                            </form>
                        </div>

                        <!-- Список коллекций -->
                        <h4>Список коллекций</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Изображение</th>
                                        <th>Название</th>
                                        <th>Статус</th>
                                        <th>Метки</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($collections as $collection): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($collection['collection_id']) ?></td>
                                        <td>
                                            <?php if (!empty($collection['main_image_url'])): ?>
                                                <img src="<?= htmlspecialchars($collection['main_image_url']) ?>" alt="Изображение коллекции" class="collection-image">
                                            <?php else: ?>
                                                Нет изображения
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($collection['name']) ?></td>
                                        <td>
                                            <span class="badge <?= $collection['is_active'] ? 'bg-success' : 'bg-secondary' ?>">
                                                <?= $collection['is_active'] ? 'Активна' : 'Неактивна' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($collection['is_featured']): ?>
                                                <span class="badge bg-primary">Рекомендуемая</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCollectionModal<?= $collection['collection_id'] ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <a href="admin.php?tab=collections&delete_collection=<?= $collection['collection_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту коллекцию?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Модальное окно редактирования коллекции -->
                                    <div class="modal fade" id="editCollectionModal<?= $collection['collection_id'] ?>" tabindex="-1" aria-labelledby="editCollectionModalLabel<?= $collection['collection_id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editCollectionModalLabel<?= $collection['collection_id'] ?>">Редактирование коллекции</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="collection_id" value="<?= $collection['collection_id'] ?>">
                                                        <input type="hidden" name="existing_image" value="<?= $collection['main_image_url'] ?>">
                                                        
                                                        <div class="form-section">
                                                            <h5>Основная информация</h5>
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label for="edit_collection_name<?= $collection['collection_id'] ?>" class="form-label">Название коллекции</label>
                                                                    <input type="text" class="form-control" id="edit_collection_name<?= $collection['collection_id'] ?>" name="name" value="<?= htmlspecialchars($collection['name']) ?>" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="edit_collection_slug<?= $collection['collection_id'] ?>" class="form-label">URL-адрес (slug)</label>
                                                                    <input type="text" class="form-control" id="edit_collection_slug<?= $collection['collection_id'] ?>" name="slug" value="<?= htmlspecialchars($collection['slug']) ?>" required>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label for="edit_collection_description<?= $collection['collection_id'] ?>" class="form-label">Описание</label>
                                                                    <textarea class="form-control" id="edit_collection_description<?= $collection['collection_id'] ?>" name="description" rows="3"><?= htmlspecialchars($collection['description']) ?></textarea>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label for="edit_collection_short_description<?= $collection['collection_id'] ?>" class="form-label">Краткое описание</label>
                                                                    <textarea class="form-control" id="edit_collection_short_description<?= $collection['collection_id'] ?>" name="short_description" rows="2"><?= htmlspecialchars($collection['short_description']) ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-section">
                                                            <h5>Изображение и метки</h5>
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label for="edit_collection_main_image<?= $collection['collection_id'] ?>" class="form-label">Новое изображение</label>
                                                                    <input type="file" class="form-control" id="edit_collection_main_image<?= $collection['collection_id'] ?>" name="main_image" accept="image/*">
                                                                    <?php if (!empty($collection['main_image_url'])): ?>
                                                                        <small class="text-muted">Текущее изображение: <?= basename($collection['main_image_url']) ?></small>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-check mt-4 pt-2">
                                                                        <input class="form-check-input" type="checkbox" id="edit_collection_is_featured<?= $collection['collection_id'] ?>" name="is_featured" value="1" <?= $collection['is_featured'] ? 'checked' : '' ?>>
                                                                        <label class="form-check-label" for="edit_collection_is_featured<?= $collection['collection_id'] ?>">Рекомендуемая</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-check mt-4 pt-2">
                                                                        <input class="form-check-input" type="checkbox" id="edit_collection_is_active<?= $collection['collection_id'] ?>" name="is_active" value="1" <?= $collection['is_active'] ? 'checked' : '' ?>>
                                                                        <label class="form-check-label" for="edit_collection_is_active<?= $collection['collection_id'] ?>">Активная</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-section">
                                                            <h5>SEO</h5>
                                                            <div class="row g-3">
                                                                <div class="col-12">
                                                                    <label for="edit_collection_meta_title<?= $collection['collection_id'] ?>" class="form-label">Мета-заголовок</label>
                                                                    <input type="text" class="form-control" id="edit_collection_meta_title<?= $collection['collection_id'] ?>" name="meta_title" value="<?= htmlspecialchars($collection['meta_title']) ?>">
                                                                </div>
                                                                <div class="col-12">
                                                                    <label for="edit_collection_meta_description<?= $collection['collection_id'] ?>" class="form-label">Мета-описание</label>
                                                                    <textarea class="form-control" id="edit_collection_meta_description<?= $collection['collection_id'] ?>" name="meta_description" rows="2"><?= htmlspecialchars($collection['meta_description']) ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                                        <button type="submit" name="update_collection" class="btn btn-primary">Сохранить изменения</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                   <!-- Вкладка заявок -->
                <div class="tab-pane fade <?= $current_tab === 'requests' ? 'show active' : '' ?>" id="requests-tab">
                    <h4>Список заявок</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Статус</th>
                                    <th>Дата</th>
                                    <th>Имя</th>
                                    <th>Телефон</th>
                                    <th>email</th>
                                    <th>Сообщение</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($requests as $request): ?>
                                <tr>
                                    <td><?= $request['request_id'] ?></td>
                                      <td>
                                        <span class="status-<?= $request['status'] ?>">
                                            <?= match($request['status']) {
                                                'new' => 'Новая',
                                                'in_progress' => 'В работе',
                                                'completed' => 'Завершена',
                                                default => $request['status']
                                            } ?>
                                        </span>
                                    </td>
                                    <td><?= date('d.m.Y H:i', strtotime($request['created_at'])) ?></td>
                                    <td><?= htmlspecialchars($request['name']) ?></td>
                                    <td><?= htmlspecialchars($request['phone']) ?></td>
                                    <td><?= htmlspecialchars($request['email']) ?></td>
                                    <td><?= htmlspecialchars($request['message']) ?></td>
                                  
                                    
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Генерация slug из названия товара
        document.getElementById('name').addEventListener('input', function() {
            const slugInput = document.getElementById('slug');
            if (!slugInput.value) {
                const slug = this.value.toLowerCase()
                    .replace(/\s+/g, '-') // Заменяем пробелы на дефисы
                    .replace(/[^\w\-]+/g, '') // Удаляем все не-слова
                    .replace(/\-\-+/g, '-') // Удаляем двойные дефисы
                    .replace(/^-+/, '') // Удаляем дефисы с начала
                    .replace(/-+$/, ''); // Удаляем дефисы с конца
                slugInput.value = slug;
            }
        });
    </script>
</body>
</html>