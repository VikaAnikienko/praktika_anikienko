<?php
// Подключение к базе данных
$db = new mysqli('localhost', 'root', '', 'fm');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$db->set_charset("utf8");

// Безопасное получение slug из URL
$slug = isset($_GET['slug']) ? $db->real_escape_string($_GET['slug']) : '';

// Запрос коллекции с подготовленным выражением
$stmt = $db->prepare("SELECT * FROM collections WHERE slug = ? AND is_active = 1");
$stmt->bind_param("s", $slug);
$stmt->execute();
$collection = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$collection) {
    header("HTTP/1.0 404 Not Found");
    include('404.php');
    exit;
}

// Получаем все товары коллекции (без ограничения is_new)
$stmt = $db->prepare("SELECT * FROM products WHERE collection_id = ? ORDER BY is_featured DESC, created_at DESC");
$stmt->bind_param("i", $collection['collection_id']);
$stmt->execute();
$products = $stmt->get_result();

// Получаем настройки
$settings = [];
$settingsResult = $db->query("SELECT setting_key, setting_value FROM settings WHERE is_public = 1");
while ($row = $settingsResult->fetch_assoc()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($collection['name']); ?> | FURRA</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Raleway:wght@300;400;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/collect.css">
</head>
<body>
    <?php include("php/header.php") ?>
    <style>
        :root {
            --gold: #D4AF37;
            --dark: #1A1A1A;
            --light: #F8F8F8;
            --gray: #E8E8E8;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Raleway', sans-serif;
            color: var(--dark);
            background-color: var(--light);
            line-height: 1.6;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        header {
            background-color: rgba(26, 26, 26, 0.9);
            position: fixed;
            width: 100%;
            z-index: 1000;
            padding: 20px 0;
            transition: all 0.3s ease;
        }
        
        header.scrolled {
            padding: 10px 0;
            background-color: var(--dark);
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            color: var(--gold);
            text-decoration: none;
            letter-spacing: 2px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 30px;
        }
        
        nav ul li a {
            color: var(--light);
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 1px;
            transition: color 0.3s ease;
        }
        
        nav ul li a:hover {
            color: var(--gold);
        }
        
        /* Page Header */
        .page-header {
            height: 70vh;
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
            display: flex;
            align-items: flex-end;
            color: var(--light);
            padding-top: 80px;
            margin-bottom: 80px;
        }
        
        .page-header-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 20px;
            width: 100%;
        }
        
        .page-header h1 {
            font-size: 72px;
            margin-bottom: 20px;
            letter-spacing: 3px;
        }
        
        .page-header p {
            max-width: 600px;
            font-size: 20px;
            margin-bottom: 30px;
        }
        
        .breadcrumbs {
            display: flex;
            list-style: none;
            margin-bottom: 20px;
        }
        
        .breadcrumbs li {
            margin-right: 15px;
            position: relative;
        }
        
        .breadcrumbs li:after {
            content: '/';
            position: absolute;
            right: -12px;
            color: var(--gold);
        }
        
        .breadcrumbs li:last-child:after {
            display: none;
        }
        
        .breadcrumbs a {
            color: var(--light);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .breadcrumbs a:hover {
            color: var(--gold);
        }
        
        /* Collection Intro */
        .collection-intro {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-bottom: 100px;
            align-items: center;
        }
        
        .collection-description h2 {
            font-size: 36px;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .collection-description h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 2px;
            background-color: var(--gold);
        }
        
        .collection-description p {
            margin-bottom: 20px;
        }
        
        .collection-features {
            margin-top: 40px;
        }
        
        .feature-item {
            display: flex;
            margin-bottom: 15px;
        }
        
        .feature-icon {
            color: var(--gold);
            margin-right: 15px;
            font-size: 18px;
        }
        
        .collection-image {
            position: relative;
        }
        
        .collection-image img {
            width: 100%;
            height: auto;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .collection-image:before {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            width: 100%;
            height: 100%;
            border: 2px solid var(--gold);
            z-index: -1;
        }
        
        /* Products Grid */
        .products-section {
            margin-bottom: 100px;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-title h2 {
            font-size: 42px;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }
        
        .section-title h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 2px;
            background-color: var(--gold);
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 40px;
        }
        
        .product-card {
            position: relative;
            margin-bottom: 30px;
        }
        
        .product-image {
            height: 400px;
            overflow: hidden;
            margin-bottom: 20px;
            position: relative;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.05);
        }
        
        .product-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: var(--gold);
            color: var(--dark);
            padding: 5px 15px;
            font-weight: 600;
            font-size: 14px;
        }
        
        .product-info {
            text-align: center;
        }
        
        .product-info h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .product-info p {
            color: #666;
            margin-bottom: 15px;
        }
        
        .product-price {
            font-size: 20px;
            font-weight: 600;
            color: var(--gold);
        }
        
        /* Customization Section */
        .customization-section {
            background-color: var(--dark);
            color: var(--light);
            padding: 100px 0;
            margin-bottom: 80px;
        }
        
        .customization-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .customization-image {
            position: relative;
        }
        
        .customization-image img {
            width: 100%;
        }
        
        .customization-image:before {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            width: 100%;
            height: 100%;
            border: 2px solid var(--gold);
            z-index: -1;
        }
        
        .customization-content h2 {
            font-size: 36px;
            margin-bottom: 30px;
            color: var(--gold);
        }
        
        .customization-content p {
            margin-bottom: 20px;
        }
        
        .customization-options {
            margin-top: 40px;
        }
        
        .option-item {
            margin-bottom: 15px;
        }
        
        .option-title {
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }
        
        .option-title i {
            color: var(--gold);
            margin-right: 10px;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1618220179428-22790b461013?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1527&q=80') no-repeat center center/cover;
            padding: 100px 0;
            text-align: center;
            color: var(--light);
            margin-bottom: 80px;
        }
        
        .cta-section h2 {
            font-size: 42px;
            margin-bottom: 30px;
        }
        
        .cta-section p {
            max-width: 700px;
            margin: 0 auto 40px;
            font-size: 18px;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--gold);
            color: var(--dark);
            padding: 15px 40px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            background-color: var(--light);
            transform: translateY(-3px);
        }
        
        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--gold);
            color: var(--gold);
            margin-left: 20px;
        }
        
        .btn-outline:hover {
            background-color: var(--gold);
            color: var(--dark);
        }
        
        /* Footer */
        footer {
            background-color: var(--dark);
            color: var(--light);
            padding: 60px 0 20px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-column h3 {
            color: var(--gold);
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column ul li {
            margin-bottom: 10px;
        }
        
        .footer-column ul li a {
            color: var(--light);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-column ul li a:hover {
            color: var(--gold);
        }
        
        .social-links {
            display: flex;
            gap: 15px;
        }
        
        .social-links a {
            color: var(--light);
            font-size: 20px;
            transition: color 0.3s ease;
        }
        
        .social-links a:hover {
            color: var(--gold);
        }
        
        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }
        
        @media (max-width: 992px) {
            .page-header h1 {
                font-size: 56px;
            }
            
            .collection-intro, .customization-container {
                grid-template-columns: 1fr;
            }
            
            .collection-image:before, .customization-image:before {
                display: none;
            }
            
            .collection-image, .customization-image {
                order: -1;
                margin-bottom: 40px;
            }
        }
        
        @media (max-width: 768px) {
            .page-header {
                height: 60vh;
                margin-bottom: 50px;
            }
            
            .page-header h1 {
                font-size: 42px;
            }
            
            .section-title h2 {
                font-size: 36px;
            }
            
            .btn-outline {
                margin-left: 0;
                margin-top: 15px;
                display: block;
            }
            
            .header-container {
                flex-direction: column;
            }
            
            .logo {
                margin-bottom: 20px;
            }
            
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            nav ul li {
                margin: 0 10px 10px;
            }
        }
        
        @media (max-width: 576px) {
            .page-header {
                height: 50vh;
            }
            
            .page-header h1 {
                font-size: 36px;
            }
            
            .product-image {
                height: 300px;
            }
            
            .cta-section h2 {
                font-size: 32px;
            }
        } </style>
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-content">
            <ul class="breadcrumbs">
                <li><a href="index.php">Главная</a></li>
                <li><a href="collection.php">Коллекции</a></li>
                <li><a href="#"><?php echo htmlspecialchars($collection['name']); ?></a></li>
            </ul>
            <h1>Коллекция "<?php echo htmlspecialchars($collection['name']); ?>"</h1>
            <p><?php echo htmlspecialchars($collection['short_description'] ?? 'Эксклюзивная мебель премиум-класса'); ?></p>
            <a href="#products" class="btn">Смотреть коллекцию</a>
        </div>
    </section>

    <!-- Collection Intro -->
    <section class="collection-intro">
        <div class="container">
            <div class="collection-description">
                <h2><?php echo htmlspecialchars($collection['meta_title'] ?? $collection['name']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($collection['description'] ?? 'Описание коллекции')); ?></p>
                
                <div class="collection-features">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-check"></i></div>
                        <div class="feature-text">
                            <h4>Эксклюзивные материалы</h4>
                            <p>Используем только отборную древесину возрастом от 80 лет</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-check"></i></div>
                        <div class="feature-text">
                            <h4>Ручная работа</h4>
                            <p>Более 200 часов ручной работы на каждый предмет мебели</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-check"></i></div>
                        <div class="feature-text">
                            <h4>Пожизненная гарантия</h4>
                            <p>Гарантия на все изделия коллекции</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="collection-image">
                <img src="<?php echo htmlspecialchars($collection['main_image_url'] ?? 'https://via.placeholder.com/800x600'); ?>" alt="<?php echo htmlspecialchars($collection['name']); ?>">
            </div>
        </div>
    </section>

    <!-- продукты -->
    <section class="products-section" id="products">
        <div class="container">
            <div class="section-title">
                <h2>Предметы коллекции</h2>
            </div>
            
            <div class="products-grid">
                <?php if ($products->num_rows > 0): ?>
                    <?php while ($product = $products->fetch_assoc()): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <img src="<?php echo htmlspecialchars($product['image_path'] ?? 'https://via.placeholder.com/600x400'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <?php if ($product['is_new']): ?>
                                    <div class="product-badge">Новинка</div>
                                <?php endif; ?>
                                <?php if ($product['is_bestseller']): ?>
                                    <div class="product-badge">Хит продаж</div>
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p><?php echo htmlspecialchars($product['short_description'] ?? ''); ?></p>
                                <div class="product-price"><?php echo number_format($product['price'], 0, '', ' '); ?> ₽</div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-products">
                        <p>В этой коллекции пока нет товаров</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Customization Section -->
    <section class="customization-section">
        <div class="container">
            <div class="customization-container">
                <div class="customization-image">
                    <img src="https://images.unsplash.com/photo-1600210491892-03d54c0aaf87?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1454&q=80" alt="Индивидуальная настройка">
                </div>
                <div class="customization-content">
                    <h2>Индивидуальные решения</h2>
                    <p>Каждый предмет коллекции "<?php echo htmlspecialchars($collection['name']); ?>" может быть адаптирован под ваши требования.</p>
                    
                    <div class="customization-options">
                        <div class="option-item">
                            <div class="option-title">
                                <i class="fas fa-palette"></i>
                                <h4>Выбор материалов</h4>
                            </div>
                            <p>12 пород дерева, 8 видов мрамора, 24 варианта тканей и кожи</p>
                        </div>
                        <div class="option-item">
                            <div class="option-title">
                                <i class="fas fa-ruler-combined"></i>
                                <h4>Изменение размеров</h4>
                            </div>
                            <p>Адаптация габаритов под ваше помещение</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Закажите мебель из коллекции "<?php echo htmlspecialchars($collection['name']); ?>"</h2>
            <p>Оставьте заявку на консультацию с нашим дизайнером</p>
            <a href="contact.php" class="btn">Оставить заявку</a>
            <a href="tel:<?php echo htmlspecialchars($settings['contact_phone'] ?? '+74951234567'); ?>" class="btn btn-outline">
                <?php echo htmlspecialchars($settings['contact_phone'] ?? '+7 (495) 123-45-67'); ?>
            </a>
        </div>
    </section>

    <?php include("php/footer.php") ?>

    <script>
        // Sticky Header
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Product hover effects
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                const img = this.querySelector('img');
                if (img) img.style.transform = 'scale(1.05)';
            });
            card.addEventListener('mouseleave', function() {
                const img = this.querySelector('img');
                if (img) img.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>
<?php 
$db->close();
?> 