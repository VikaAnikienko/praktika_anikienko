<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/index.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FURRA | Элитная мебель премиум-класса</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Raleway:wght@300;400;600&display=swap">
    
</head>
<body>
    <!-- Подключение к базе данных -->
    <?php
            $db = new mysqli('localhost', 'root', '', 'fm'); // Замените 'password' на реальный пароль или ''
        
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    $db->set_charset("utf8");
    
    // Получаем активные баннеры
    $banners = $db->query("SELECT * FROM banners WHERE is_active = 1 ORDER BY sort_order");
    
    // Получаем коллекции
    $collections = $db->query("SELECT * FROM collections WHERE is_active = 1 ORDER BY is_featured DESC, created_at DESC LIMIT 3");
    
    // Получаем отзывы
    $reviews = $db->query("SELECT * FROM reviews WHERE is_approved = 1 ORDER BY created_at DESC LIMIT 3");
    
    // Получаем настройки
    $settings = [];
    $settingsResult = $db->query("SELECT setting_key, setting_value FROM settings WHERE is_public = 1");
    while ($row = $settingsResult->fetch_assoc()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    ?>

    <!-- Header -->
    <?php include ("php/header.php") ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1><?php echo $settings['hero_title'] ?? 'Искусство престижного интерьера'; ?></h1>
            <p><?php echo $settings['hero_description'] ?? 'Эксклюзивная мебель ручной работы из редких пород дерева и натуральных материалов для вашего уникального пространства'; ?></p>
            <a href="collection.php" class="btn">Коллекции</a>
            <a href="/consultation" class="btn btn-outline">Консультация дизайнера</a>
        </div>
    </section>

    <!-- Collections Section -->
    <section class="section">
        <div class="container">
            <div class="section-title">
                <h2>Эксклюзивные коллекции</h2>
            </div>
            <div class="collections-grid">
                <?php while ($collection = $collections->fetch_assoc()): ?>
                <div class="collection-item">
                    <img src="<?php echo $collection['main_image_url'] ?? 'https://via.placeholder.com/600x400'; ?>" alt="<?php echo htmlspecialchars($collection['name']); ?>">
                    <div class="collection-overlay">
                        <h3><?php echo htmlspecialchars($collection['name']); ?></h3>
                        <p><?php echo htmlspecialchars($collection['short_description'] ?? ''); ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about">
        <div class="container">
            <div class="about-content">
                <div class="about-image">
                    <img src="<?php echo $settings['about_image'] ?? 'https://images.unsplash.com/photo-1600585152220-90363fe7e115?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'; ?>" alt="Наша мастерская">
                </div>
                <div class="about-text">
                    <h2>О FURRA</h2>
                    <p><?php echo $settings['about_text_1'] ?? 'С 2011 года мы создаем эксклюзивную мебель премиум-класса, сочетая вековые традиции мастерства с инновационными технологиями. Каждое изделие - это произведение искусства, созданное вручную лучшими мастерами Европы.'; ?></p>
                    <p><?php echo $settings['about_text_2'] ?? 'Мы используем только редкие породы дерева, натуральную кожу высочайшего качества и драгоценные металлы для отделки. Наша мебель - это инвестиция в ваш комфорт и статус на десятилетия вперед.'; ?></p>
                    <a href="/about" class="btn">Узнать больше</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section testimonials">
        <div class="container">
            <div class="section-title">
                <h2>Мнение наших клиентов</h2>
            </div>
            <div class="testimonials-slider">
                <?php if ($reviews->num_rows > 0): ?>
                    <?php while ($review = $reviews->fetch_assoc()): ?>
                    <div class="testimonial-item">
                        <p>"<?php echo htmlspecialchars($review['comment']); ?>"</p>
                        <div class="testimonial-author">— <?php echo htmlspecialchars($review['author_name']); ?></div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="testimonial-item">
                        <p>"Мебель превзошла все мои ожидания. Качество материалов и исполнения на уровне лучших мировых брендов, а индивидуальный подход делает покупку по-настоящему особенной."</p>
                        <div class="testimonial-author">— Михаил Соколов, Москва</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include ("php/footer.php") ?>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        // Sticky Header
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Simple testimonial slider
        const testimonialItems = document.querySelectorAll('.testimonial-item');
        let currentTestimonial = 0;
        
        function showTestimonial(index) {
            testimonialItems.forEach(item => item.style.display = 'none');
            testimonialItems[index].style.display = 'block';
        }
        
        function nextTestimonial() {
            currentTestimonial = (currentTestimonial + 1) % testimonialItems.length;
            showTestimonial(currentTestimonial);
        }
        
        // Показываем первый отзыв и запускаем таймер
        if (testimonialItems.length > 0) {
            showTestimonial(0);
            if (testimonialItems.length > 1) {
                setInterval(nextTestimonial, 5000);
            }
        }
    </script>
</body>
</html>
<?php
// Закрываем соединение с базой данных
$db->close();
?>