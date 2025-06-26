<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты | FURRA</title>
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
        
      
        /* Page Header */
        .page-header {
            height: 50vh;
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
        
        /* Contact Sections */
        .contact-sections {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-bottom: 80px;
        }
        
        .contact-info {
            padding: 40px;
            background-color: var(--dark);
            color: var(--light);
        }
        
        .contact-info h2 {
            font-size: 32px;
            margin-bottom: 30px;
            color: var(--gold);
        }
        
        .info-item {
            display: flex;
            margin-bottom: 25px;
        }
        
        .info-icon {
            font-size: 24px;
            color: var(--gold);
            margin-right: 20px;
            width: 30px;
        }
        
        .info-content h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .info-content a {
            color: var(--light);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .info-content a:hover {
            color: var(--gold);
        }
        
        /* Contact Form */
        .contact-form {
            padding: 40px;
            background-color: white;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
        }
        
        .contact-form h2 {
            font-size: 32px;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .contact-form h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 2px;
            background-color: var(--gold);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            font-family: 'Raleway', sans-serif;
            font-size: 16px;
            transition: border 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--gold);
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
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
            background-color: var(--dark);
            color: var(--gold);
        }
        
        /* Showroom Section */
        .showroom-section {
            background-color: var(--gray);
            padding: 80px 0;
            margin-bottom: 80px;
        }
        
        .showroom-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .showroom-image {
            position: relative;
            height: 500px;
        }
        
        .showroom-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .showroom-image:before {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            width: 100%;
            height: 100%;
            border: 2px solid var(--gold);
            z-index: -1;
        }
        
        .showroom-content h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        
        .showroom-content p {
            margin-bottom: 30px;
        }
        
        /* Map Section */
        .map-section {
            height: 500px;
            margin-bottom: 80px;
        }
        
        .map-section iframe {
            width: 100%;
            height: 100%;
            border: none;
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
            .contact-sections, .showroom-container {
                gap: 40px;
            }
        }
        
        @media (max-width: 992px) {
            .page-header h1 {
                font-size: 48px;
            }
            
            .contact-sections, .showroom-container {
                grid-template-columns: 1fr;
            }
            
            .showroom-image {
                height: 400px;
                order: -1;
            }
            
            .showroom-image:before {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .page-header {
                height: 40vh;
                margin-bottom: 50px;
            }
            
            .page-header h1 {
                font-size: 36px;
            }
            
            .contact-info, .contact-form {
                padding: 30px;
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
                height: 35vh;
            }
            
            .contact-info, .contact-form {
                padding: 25px 20px;
            }
            
            .showroom-image {
                height: 300px;
            }
            
            .map-section {
                height: 350px;
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
                <li><a href="contact.html">Контакты</a></li>
            </ul>
            <h1>Наши контакты</h1>
            <p>Мы всегда рады видеть вас в нашем шоуруме или обсудить ваш проект онлайн</p>
        </div>
    </section>

    <!-- Contact Sections -->
    <div class="container">
        <div class="contact-sections">
            <!-- Contact Info -->
            <div class="contact-info">
                <h2>Свяжитесь с нами</h2>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-content">
                        <h3>Адрес</h3>
                        <p>Барнаул, ул. Попова, 256г</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="info-content">
                        <h3>Телефон</h3>
                        <p><a href="tel:+74951234567">+7 (495) 123-45-67</a></p>
                        <p><a href="tel:+79161234567">+7 (916) 123-45-67</a> (WhatsApp)</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-content">
                        <h3>Email</h3>
                        <p><a href="im-furra@yandex.com">im-furra@yandex.com</a></p>
                        <p><a href="im-furra@yandex.com">im-furra@yandex.com</a></p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-content">
                        <h3>Часы работы</h3>
                        <p>Пн-Пт: 10:00 - 20:00</p>
                        <p>Сб-Вс: 11:00 - 18:00</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="info-content">
                        <h3>Социальные сети</h3>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-pinterest"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
           <!-- Замените существующую форму на эту -->
<div class="contact-form">
    <h2>Форма обратной связи</h2>
    <form id="contactForm">
        <div class="form-group">
            <label for="name">Ваше имя *</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Телефон *</label>
            <input type="tel" id="phone" name="phone" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="message">Сообщение *</label>
            <textarea id="message" name="message" class="form-control" required></textarea>
        </div>
        
        <button type="submit" class="btn">Отправить</button>
        
        <div id="formMessage" style="margin-top: 20px; display: none;"></div>
    </form>
</div>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Показываем загрузку
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Отправка...';
    
    const formData = {
        name: document.getElementById('name').value,
        phone: document.getElementById('phone').value,
        email: document.getElementById('email').value,
        message: document.getElementById('message').value
    };
    
    fetch('submit_contact.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        const messageEl = document.getElementById('formMessage');
        messageEl.style.display = 'block';
        
        if (data.success) {
            messageEl.innerHTML = `<div style="color: green;">${data.message}</div>`;
            document.getElementById('contactForm').reset();
        } else {
            messageEl.innerHTML = `<div style="color: red;">${data.message || 'Ошибка отправки'}</div>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('formMessage').innerHTML = 
            '<div style="color: red;">Произошла ошибка при отправке формы</div>';
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Отправить';
    });
});
    </script>
</body>
</html>