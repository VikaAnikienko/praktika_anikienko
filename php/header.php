<header id="header">
        <div class="container header-container">
            <a href="index.php" class="logo">FURRA</a>
            <nav>
                <ul>
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="collection.php">Коллекции</a></li>
                    <li><a href="aboutus.php">О нас</a></li>
                    <li><a href="contact.php">Контакты</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <style> /* Header */
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
        }</style>