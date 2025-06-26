<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/collect.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Коллекции | FURRA</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Raleway:wght@300;400;600&display=swap">
</head>
<body>
    <?php
            $db = new mysqli('localhost', 'root', '', 'fm'); // Замените 'password' на реальный пароль или ''
            if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    $db->set_charset("utf8");
    
    // Получаем все активные коллекции
    $collections = $db->query("SELECT * FROM collections WHERE is_active = 1 ORDER BY is_featured DESC, created_at DESC");
    
    // Получаем настройки
    $settings = [];
    $settingsResult = $db->query("SELECT setting_key, setting_value FROM settings WHERE is_public = 1");
    while ($row = $settingsResult->fetch_assoc()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    ?>

    <?php include ("php/header.php") ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-content">
            <ul class="breadcrumbs">
                <li><a href="index.php">Главная</a></li>
                <li><a href="collections.php">Коллекции</a></li>
            </ul>
            <h1>Наши коллекции</h1>
            <p><?php echo $settings['collections_description'] ?? 'Эксклюзивные предметы мебели, созданные с безупречным вниманием к деталям'; ?></p>
        </div>
    </section>

    <!-- клееуия -->
    <div class="container">
        <div class="collections-grid">
            <?php if ($collections->num_rows > 0): ?>
                <?php while ($collection = $collections->fetch_assoc()): ?>
                    <a href="collection1.php?slug=<?php echo $collection['slug']; ?>" style="text-decoration: none;">
                        <div class="collection-card" data-category="<?php echo strtolower(str_replace(' ', '-', $collection['name'])); ?>">
                            <div class="collection-card-img">
                                <img src="<?php echo $collection['main_image_url'] ?? 'https://via.placeholder.com/600x400'; ?>" alt="<?php echo htmlspecialchars($collection['name']); ?>">
                            </div>
                            <div class="collection-card-info">
                                <h3><?php echo htmlspecialchars($collection['name']); ?></h3>
                                <p><?php echo htmlspecialchars($collection['short_description'] ?? ''); ?></p>
                                <div class="collection-price">
                                    <?php 
                                    $minPriceQuery = $db->query("SELECT MIN(price) as min_price FROM products WHERE collection_id = " . $collection['collection_id']);
                                    $minPrice = $minPriceQuery->fetch_assoc();
                                    if ($minPrice['min_price']) {
                                        echo 'от ' . number_format($minPrice['min_price'], 0, '', ' ') . ' ₽';
                                    } else {
                                        echo 'Цена по запросу';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Коллекции не найдены.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Создайте свой уникальный интерьер</h2>
            <p><?php echo $settings['cta_text'] ?? 'Наши дизайнеры помогут подобрать идеальную мебель для вашего пространства, учитывая все пожелания и особенности помещения'; ?></p>
            <a href="contact.php" class="btn">Заказать консультацию</a>
            <a href="tel:<?php echo $settings['contact_phone'] ?? '+74951234567'; ?>" class="btn btn-outline"><?php echo $settings['contact_phone'] ?? '+7 (495) 123-45-67'; ?></a>
        </div>
    </section>

    <?php include ("php/footer.php") ?>
    
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

        // Collection Filter
        const filterBtns = document.querySelectorAll('.filter-btn');
        const collectionCards = document.querySelectorAll('.collection-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class from all buttons
                filterBtns.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                btn.classList.add('active');
                
                const filter = btn.getAttribute('data-filter');
                
                collectionCards.forEach(card => {
                    if (filter === 'all' || card.getAttribute('data-category') === filter) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
    
    <?php $db->close(); ?>
</body>
</html>