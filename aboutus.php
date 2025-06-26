<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас | FURRA</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Raleway:wght@300;400;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            height: 60vh;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1600585152220-90363fe7e115?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--light);
            padding-top: 80px;
            margin-bottom: 80px;
        }
        
        .page-header-content {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .page-header h1 {
            font-size: 60px;
            margin-bottom: 20px;
            letter-spacing: 3px;
        }
        
        .breadcrumbs {
            display: flex;
            justify-content: center;
            list-style: none;
            margin-bottom: 20px;
        }
        
        .breadcrumbs li {
            margin: 0 10px;
            position: relative;
        }
        
        .breadcrumbs li:after {
            content: '/';
            position: absolute;
            right: -15px;
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
        
        /* About Content */
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-bottom: 100px;
            align-items: center;
        }
        
        .about-text h2 {
            font-size: 36px;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .about-text h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 2px;
            background-color: var(--gold);
        }
        
        .about-text p {
            margin-bottom: 20px;
        }
        
        .about-image {
            position: relative;
        }
        
        .about-image img {
            width: 100%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .about-image:before {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            width: 100%;
            height: 100%;
            border: 2px solid var(--gold);
            z-index: -1;
        }
        
        /* History Section */
        .history-section {
            background-color: var(--dark);
            color: var(--light);
            padding: 100px 0;
            margin-bottom: 80px;
        }
        
        .history-container {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }
        
        .history-container h2 {
            font-size: 36px;
            margin-bottom: 50px;
            color: var(--gold);
        }
        
        .timeline {
            position: relative;
            padding-left: 150px;
            text-align: left;
        }
        
        .timeline:before {
            content: '';
            position: absolute;
            left: 70px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: var(--gold);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 50px;
            padding-left: 60px;
        }
        
        .timeline-year {
            position: absolute;
            left: 0;
            top: 0;
            width: 140px;
            text-align: right;
            padding-right: 30px;
            font-size: 24px;
            font-weight: 700;
            color: var(--gold);
        }
        
        .timeline-content h3 {
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        /* Team Section */
        .team-section {
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
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 40px;
        }
        
        .team-member {
            text-align: center;
        }
        
        .member-photo {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 25px;
            border: 3px solid var(--gold);
        }
        
        .member-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .member-info h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .member-position {
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        /* Values Section */
        .values-section {
            background-color: var(--gray);
            padding: 100px 0;
            margin-bottom: 80px;
        }
        
        .values-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 40px;
        }
        
        .value-card {
            text-align: center;
            padding: 40px 30px;
            background-color: white;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.05);
        }
        
        .value-icon {
            font-size: 50px;
            color: var(--gold);
            margin-bottom: 25px;
        }
        
        .value-card h3 {
            font-size: 24px;
            margin-bottom: 15px;
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
            .team-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
        
        @media (max-width: 992px) {
            .page-header h1 {
                font-size: 48px;
            }
            
            .about-content {
                grid-template-columns: 1fr;
            }
            
            .about-image:before {
                display: none;
            }
            
            .timeline {
                padding-left: 100px;
            }
            
            .timeline:before {
                left: 50px;
            }
            
            .timeline-year {
                width: 100px;
            }
        }
        
        @media (max-width: 768px) {
            .page-header {
                height: 50vh;
                margin-bottom: 50px;
            }
            
            .page-header h1 {
                font-size: 36px;
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
                height: 40vh;
            }
            
            .timeline {
                padding-left: 0;
            }
            
            .timeline:before {
                display: none;
            }
            
            .timeline-item {
                padding-left: 0;
                text-align: center;
            }
            
            .timeline-year {
                position: static;
                width: auto;
                text-align: center;
                padding-right: 0;
                margin-bottom: 10px;
            }
            
            .cta-section h2 {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include ("php/header.php") ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-content">
            <ul class="breadcrumbs">
                <li><a href="index.php">Главная</a></li>
                <li><a href="aboutus.php">О нас</a></li>
            </ul>
            <h1>О FURRA</h1>
            <p>История мастерства и страсти к созданию исключительной мебели</p>
        </div>
    </section>

    <!-- About Content -->
    <section class="about-content">
        <div class="container">
            <div class="about-text">
                <h2>Наша философия</h2>
                <p>FURRA - это не просто мебельная компания, это воплощение искусства, традиций и инноваций. С 2011 года мы создаем эксклюзивную мебель премиум-класса для самых требовательных клиентов.</p>
                <p>Наша миссия - превращать дома в произведения искусства, а мебель - в семейные реликвии, которые передаются из поколения в поколение. Мы верим, что истинная роскошь заключается в деталях, качестве материалов и безупречном исполнении.</p>
                <p>Каждое изделие FURRA - это результат кропотливой работы наших мастеров, которые сочетают вековые традиции мебельного искусства с современными технологиями.</p>
            </div>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1600210492493-0946911123ea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80" alt="Наша мастерская">
            </div>
        </div>
    </section>

    <!-- History Section -->
    <section class="history-section">
        <div class="container">
            <div class="history-container">
                <h2>Наша история</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-year">1992</div>
                        <div class="timeline-content">
                            <h3>Основание компании</h3>
                            <p>Александр Ворошилов открыл небольшую мастерскую по производству эксклюзивной мебели в центре Москвы</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-year">1998</div>
                        <div class="timeline-content">
                            <h3>Первая международная выставка</h3>
                            <p>Наша коллекция была представлена на Milan Design Week и получила признание международных экспертов</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-year">2005</div>
                        <div class="timeline-content">
                            <h3>Открытие шоурума</h3>
                            <p>В Москве открылся первый шоурум FURRA площадью 800 м²</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-year">2012</div>
                        <div class="timeline-content">
                            <h3>20 лет совершенства</h3>
                            <p>Юбилейный год отметили запуском ограниченной коллекции с инкрустацией драгоценными камнями</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-year">2020</div>
                        <div class="timeline-content">
                            <h3>Глобальное признание</h3>
                            <p>FURRA вошла в топ-10 мировых производителей элитной мебели по версии Elite Design Awards</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <div class="section-title">
                <h2>Наша команда</h2>
            </div>
            
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-photo">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1587&q=80" alt="Александр Ворошилов">
                    </div>
                    <div class="member-info">
                        <h3>Александр Ворошилов</h3>
                        <div class="member-position">Основатель и CEO</div>
                        <p>Мастер с 40-летним опытом, создатель уникальных технологий обработки дерева</p>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="member-photo">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1588&q=80" alt="Екатерина Смирнова">
                    </div>
                    <div class="member-info">
                        <h3>Екатерина Смирнова</h3>
                        <div class="member-position">Главный дизайнер</div>
                        <p>Выпускница Milan Design School, автор знаковых коллекций компании</p>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="member-photo">
                        <img src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Дмитрий Ковалев">
                    </div>
                    <div class="member-info">
                        <h3>Дмитрий Ковалев</h3>
                        <div class="member-position">Главный технолог</div>
                        <p>Инженер с 20-летним стажем, специалист по редким породам дерева</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="values-section">
        <div class="container">
            <div class="section-title">
                <h2>Наши ценности</h2>
            </div>
            
            <div class="values-container">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h3>Безупречное качество</h3>
                    <p>Мы используем только лучшие материалы и контролируем каждый этап производства</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-chess-queen"></i>
                    </div>
                    <h3>Эксклюзивность</h3>
                    <p>Каждое изделие уникально и может быть адаптировано под ваши требования</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3>Традиции мастерства</h3>
                    <p>Мы сохраняем и развиваем традиции мебельного искусства</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Экологичность</h3>
                    <p>Используем только сертифицированную древесину и безопасные материалы</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Страсть к деталям</h3>
                    <p>Мы уделяем внимание каждой детали, создавая совершенные изделия</p>
                </div>
                
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Инновации</h3>
                    <p>Постоянно исследуем новые технологии и материалы</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Хотите узнать больше о нашем производстве?</h2>
            <p>Запишитесь на экскурсию в нашу мастерскую и увидите, как создается настоящая люксовая мебель</p>
            <a href="contact.html" class="btn">Записаться на экскурсию</a>
            <a href="tel:+74951234567" class="btn btn-outline">+7 (495) 123-45-67</a>
        </div>
    </section>

    <!-- Footer -->
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
    </script>
</body>
</html>